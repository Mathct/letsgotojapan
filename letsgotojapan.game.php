<?php
 /**
  *------
  * BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
  * letsgotojapan implementation : © <Mathieu Chatrain> <mathieu.chatrain@gmail.com>
  * 
  * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
  * See http://en.boardgamearena.com/#!doc/Studio for more information.
  * -----
  * 
  * letsgotojapan.game.php
  *
  * This is the main file for your game logic.
  *
  * In this PHP file, you are going to defines the rules of the game.
  *
  */


require_once( APP_GAMEMODULE_PATH.'module/table/table.game.php' );
include('modules/Pending.php');
include('modules/CardTokyo.php');
include('modules/CardKyoto.php');
include('modules/AgentCardTokyo.php');
include('modules/AgentCardKyoto.php');




class letsgotojapan extends Table
{
    public static $instance = null;

	function __construct( )
	{
        // Your global variables labels:
        //  Here, you can assign labels to global variables you are using for this game.
        //  You can use any number of global variables with IDs between 10 and 99.
        //  If your game has options (variants), you also have to associate here a label to
        //  the corresponding ID in gameoptions.inc.php.
        // Note: afterwards, you can get/set the global variables with getGameStateValue/setGameStateInitialValue/setGameStateValue
        parent::__construct();
        
        self::initGameStateLabels( array( 
            "game_mode" => 100,

        ) );

        self::$instance = $this;

        $this->tokyo = self::getNew( "module.common.deck" );
        $this->tokyo->init( "tokyo" );
        $this->tokyo->autoreshuffle = true;

        $this->kyoto = self::getNew( "module.common.deck" );
        $this->kyoto->init( "kyoto" );
        $this->kyoto->autoreshuffle = true;

        $this->passport = self::getNew( "module.common.deck" );
        $this->passport->init( "passport" );
        $this->passport->autoreshuffle = true;

        
	}
	
    protected function getGameName( )
    {
		// Used for translations and stuff. Please do not modify.
        return "letsgotojapan";
    }	

    /*
        setupNewGame:
        
        This method is called only once, when a new game is launched.
        In this method, you must setup the game according to the game rules, so that
        the game is ready to be played.
    */
    protected function setupNewGame( $players, $options = array() )
    {    
        // Set the colors of the players with HTML color code
        // The default below is red/green/blue/orange/brown
        // The number of colors defined here must correspond to the maximum number of players allowed for the gams
        $gameinfos = $this->getGameinfos();
        $default_colors = $gameinfos['player_colors'];
 
        // Create players
        // Note: if you added some extra field on "player" table in the database (dbmodel.sql), you can initialize it there.
        $sql = "INSERT INTO player (player_id, player_color, player_canal, player_name, player_avatar) VALUES ";
        $values = array();
        foreach( $players as $player_id => $player )
        {
            $color = array_shift( $default_colors );
            $values[] = "('".$player_id."','$color','".$player['player_canal']."','".addslashes( $player['player_name'] )."','".addslashes( $player['player_avatar'] )."')";
        }
        $sql .= implode( ',', $values );
        $this->DbQuery( $sql );
        //$this->reattributeColorsBasedOnPreferences( $players, $gameinfos['player_colors'] );
        $this->reloadPlayersBasicInfos();
        
/////////////////////////////////////////////////////////////////////////////////  
//       _____                        _____       _ _   _       _ _          _   _             
//      / ____|                      |_   _|     (_) | (_)     | (_)        | | (_)            
//     | |  __  __ _ _ __ ___   ___    | |  _ __  _| |_ _  __ _| |_ ______ _| |_ _  ___  _ __  
//     | | |_ |/ _` | '_ ` _ \ / _ \   | | | '_ \| | __| |/ _` | | |_  / _` | __| |/ _ \| '_ \ 
//     | |__| | (_| | | | | | |  __/  _| |_| | | | | |_| | (_| | | |/ / (_| | |_| | (_) | | | |
//      \_____|\__,_|_| |_| |_|\___| |_____|_| |_|_|\__|_|\__,_|_|_/___\__,_|\__|_|\___/|_| |_|
//                                                                                               
/////////////////////////////////////////////////////////////////////////////////    

        $gamemode = $this->gamestate->table_globals[100];
        $countplayer = count(self::getObjectListFromDB( "SELECT player_id FROM player", true ));

        //////// AI ///////

        self::DbQuery( "INSERT INTO agent (name) VALUES ('agent')" );

        ///////////////////
        

        if($gamemode == 1)
        {
        self::DbQuery( "INSERT INTO mode (name, mode, actif) VALUES ('mode', 1, 0)" );
        }
        if($gamemode == 2)
        {
        self::DbQuery( "INSERT INTO mode (name, mode, actif) VALUES ('mode', 2, 1)" );
            if($countplayer == 1)
            {
                self::DbQuery( "UPDATE agent set r = 3  WHERE name = 'agent'" );
                self::DbQuery( "UPDATE agent set g = 3  WHERE name = 'agent'" );
                self::DbQuery( "UPDATE agent set p = 3  WHERE name = 'agent'" );
                self::DbQuery( "UPDATE agent set y = 3  WHERE name = 'agent'" );
                self::DbQuery( "UPDATE agent set b = 3  WHERE name = 'agent'" );
            }

        }


        
        $tokyo = array();
        for ($i = 1; $i <= 80; $i++)
        {
            
            $tokyo[] = array( 'type' => $i, 'type_arg' => 1, 'nbr' => 1);
           
        }

        $this->tokyo->createCards( $tokyo, 'deck' );
        $this->tokyo->shuffle( 'deck' );

        $kyoto = array();
        for ($i = 1; $i <= 80; $i++)
        {
            
            $kyoto[] = array( 'type' => $i, 'type_arg' => 2, 'nbr' => 1);
           
        }

        $this->kyoto->createCards( $kyoto, 'deck' );
        $this->kyoto->shuffle( 'deck' );


        $passport = array();
        for ($i = 1; $i <= 18; $i++)
        {
            
            $passport[] = array( 'type' => $i, 'type_arg' => 1, 'nbr' => 1);
           
        }

        $this->passport->createCards( $passport, 'deck' );
        $this->passport->shuffle( 'deck' );
        

        if(($countplayer >1)&&($gamemode == 1))
        {

            foreach( $players as $player_id => $player )
            {
                
                $this->tokyo->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->kyoto->pickCardForLocation( 'deck', 'playerhand', $player_id);
                

            }

        }

        if(($countplayer >1)&&($gamemode == 2))
        {
            

            foreach( $players as $player_id => $player )
            {
                
                $this->passport->pickCardForLocation( 'deck', 'passporthand', $player_id);
                $this->passport->pickCardForLocation( 'deck', 'passporthand', $player_id);


                // A deporter
                $this->tokyo->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->kyoto->pickCardForLocation( 'deck', 'playerhand', $player_id);
                
                

            }

        }

        if(($countplayer ==1)&&($gamemode == 2))
        {
            

            foreach( $players as $player_id => $player )
            {
                
                $this->passport->pickCardForLocation( 'deck', 'passporthand', $player_id);
                $this->passport->pickCardForLocation( 'deck', 'passporthand', $player_id);


                

            }

        }



        //////// TOKENS ///////

        self::DbQuery( "INSERT INTO tokens (type, name, level) VALUES ('turn', 'turn', 1)" );

        $valeurs = [1, 2, 3, 4, 5, 6];
        function tirerEtRetirerValeur(&$tableau) {
            // Choisir un index aléatoire
            $indexAleatoire = array_rand($tableau);
            // Récupérer la valeur à cet index
            $valeur = $tableau[$indexAleatoire];
            // Retirer la valeur du tableau
            unset($tableau[$indexAleatoire]);
            // Ré-indexer le tableau
            $tableau = array_values($tableau);
            // Retourner la valeur
            return $valeur;
        }
        $valeur1 = tirerEtRetirerValeur($valeurs);
        $valeur2 = tirerEtRetirerValeur($valeurs);
        $valeur3 = tirerEtRetirerValeur($valeurs);
        $valeur4 = tirerEtRetirerValeur($valeurs);
        $valeur5 = tirerEtRetirerValeur($valeurs);
        $valeur6 = tirerEtRetirerValeur($valeurs);

        self::DbQuery( "INSERT INTO tokens (type, name, level) VALUES ('general', '1', $valeur1)" );
        self::DbQuery( "INSERT INTO tokens (type, name, level) VALUES ('general', '2', $valeur2)" );
        self::DbQuery( "INSERT INTO tokens (type, name, level) VALUES ('general', '3', $valeur3)" );
        self::DbQuery( "INSERT INTO tokens (type, name, level) VALUES ('general', '4', $valeur4)" );
        self::DbQuery( "INSERT INTO tokens (type, name, level) VALUES ('general', '5', $valeur5)" );
        self::DbQuery( "INSERT INTO tokens (type, name, level) VALUES ('general', '6', $valeur6)" );

        for ($i=72; $i<=80; $i++)
        {
            self::DbQuery( "UPDATE tokyo set finallocation = 0  WHERE card_type = {$i}" );
            self::DbQuery( "UPDATE kyoto set finallocation = 0  WHERE card_type = {$i}" );
        }


        

        //Pref Confirm///

        foreach( $players as $player_id => $player )
            {
                
                self::DbQuery( "INSERT INTO prefconfirm (player_id, valeur) VALUES ($player_id, 1)" );
                

            }

        

        /// SAVE COPY FIRST BASES MULTI PLAYER ////

        if($countplayer >1)
        {
            $copydecktokyo = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk FROM tokyo WHERE card_location != 'deck' and card_location != 'discard' and card_location != 'discardboardhidden' and card_location != 'discardboard' and card_location != 'playerhand'");
            $copydeckkyoto = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk FROM kyoto WHERE card_location != 'deck' and card_location != 'discard' and card_location != 'discardboardhidden' and card_location != 'discardboard' and card_location != 'playerhand'");
            $copybonus = self::getObjectListFromDB( "SELECT player_id id, smile smile, happy happy, angry angry, recherche recherche, train train, trainstart trainstart, wild wild FROM player");

            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                if($copydecktokyo != NULL)
                {
                    foreach ($copydecktokyo as $tokyo)
                    {
                        if($player_id == $tokyo['location_arg'])
                        {
                            self::DbQuery("INSERT INTO copytokyo (card_id, card_type, card_type_arg, card_location, card_location_arg, walk, finallocation, finalwalk) VALUES ('{$tokyo['id']}', '{$tokyo['type']}', '{$tokyo['type_arg']}', '{$tokyo['location']}', '{$tokyo['location_arg']}', '{$tokyo['walk']}', '{$tokyo['finallocation']}', '{$tokyo['finalwalk']}')");
                        }
                    }
                }

                if($copydeckkyoto != NULL)
                {
                    foreach ($copydeckkyoto as $kyoto)
                    {
                        if($player_id == $kyoto['location_arg'])
                        {
                            self::DbQuery("INSERT INTO copykyoto (card_id, card_type, card_type_arg, card_location, card_location_arg, walk, finallocation, finalwalk) VALUES ('{$kyoto['id']}', '{$kyoto['type']}', '{$kyoto['type_arg']}', '{$kyoto['location']}', '{$kyoto['location_arg']}', '{$kyoto['walk']}', '{$kyoto['finallocation']}', '{$kyoto['finalwalk']}')");
                        }
                    }
                }

                foreach($copybonus as $bonus)
                {
                    if($player_id == $bonus['id'])
                    {
                    self::DbQuery("INSERT INTO copybonus (player_id, smile, happy, angry, recherche, train, trainstart, wild) VALUES ('{$bonus['id']}', '{$bonus['smile']}', '{$bonus['happy']}', '{$bonus['angry']}', '{$bonus['recherche']}', '{$bonus['train']}', '{$bonus['trainstart']}', '{$bonus['wild']}')");
                    }
                }

            }

        }


        //////// LANCEMENT DU JEU ///////

        if($gamemode == 1)
        {

        if($countplayer >1)
        {
            foreach( $players as $player_id => $player )
            {
                $this->addPendingFirst($player_id, "Phase1Step1");
            }
        }

        if($countplayer ==1)
        {
            foreach( $players as $player_id => $player )
            {
                $this->addPendingFirst($player_id, "SoloLevel");
            }
        }

        }

        
        if($gamemode == 2)
        {

        
            foreach( $players as $player_id => $player )
            {
                $this->addPendingFirst($player_id, "Passport1");
            }
        

        }

        $this->gamestate->setAllPlayersMultiactive();

        /************ End of the game initialization *****/
    }

/////////////////////////////////////////////////////////////////////////////////  
//               _            _ _ _____        _            
//              | |     /\   | | |  __ \      | |           
//     __ _  ___| |_   /  \  | | | |  | | __ _| |_ __ _ ___ 
//    / _` |/ _ \ __| / /\ \ | | | |  | |/ _` | __/ _` / __|
//   | (_| |  __/ |_ / ____ \| | | |__| | (_| | || (_| \__ \
//    \__, |\___|\__/_/    \_\_|_|_____/ \__,_|\__\__,_|___/
//     __/ |                                                
//    |___/                                                 
/////////////////////////////////////////////////////////////////////////////////


    protected function getAllDatas()
    {
        $result = array();

        //self::repairBiggy();

        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!

        // Get information about players
        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
        $sql = "SELECT player_id id, player_score score FROM player ";
        $result['players'] = self::getCollectionFromDb( $sql );

        $result['listplayers'] = self::getObjectListFromDB( "SELECT player_id id FROM player", true );
        $result['countplayers'][] = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

        $result['tokyo'] = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk, train train, checkcard checkcard FROM tokyo WHERE card_location != 'deck' and card_location != 'discard'");
        $result['kyoto'] = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk, train train, checkcard checkcard FROM kyoto WHERE card_location != 'deck' and card_location != 'discard'");

        $result['copytokyo'] = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk FROM copytokyo WHERE card_location != 'deck' and card_location != 'discard'");
        $result['copykyoto'] = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk FROM copykyoto WHERE card_location != 'deck' and card_location != 'discard'");

        $result['turn'] = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");

        $result['tokenjour'] = self::getObjectListFromDB( "SELECT name name, level level FROM tokens WHERE type = 'general'");

        $result['mode'] = self::getUniqueValueFromDB("SELECT mode FROM mode WHERE name ='mode' ");
        $result['modeactif'] = self::getUniqueValueFromDB("SELECT actif FROM mode WHERE name ='mode' ");
        $result['passport'] = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_location location, card_location_arg location_arg FROM passport WHERE card_location != 'deck' and card_location != 'discard'");

        $listplayers = self::getObjectListFromDB("SELECT player_id id FROM player", true);
        foreach($listplayers as $player)
        {
            $result['smile'][$player] = self::getUniqueValueFromDB("SELECT smile FROM player WHERE player_id={$player}");
            $result['copysmile'][$player] = self::getUniqueValueFromDB("SELECT smile FROM copybonus WHERE player_id={$player}");
            $result['happy'][$player] = self::getUniqueValueFromDB("SELECT happy FROM player WHERE player_id={$player}");
            $result['copyhappy'][$player] = self::getUniqueValueFromDB("SELECT happy FROM copybonus WHERE player_id={$player}");
            $result['angry'][$player] = self::getUniqueValueFromDB("SELECT angry FROM player WHERE player_id={$player}");
            $result['copyangry'][$player] = self::getUniqueValueFromDB("SELECT angry FROM copybonus WHERE player_id={$player}");
            $result['color'][$player] = self::getUniqueValueFromDB("SELECT player_color FROM player WHERE player_id={$player}");
            $result['nbrerecherche'][$player] = self::getUniqueValueFromDB("SELECT recherche FROM player WHERE player_id={$player}");
            $result['copynbrerecherche'][$player] = self::getUniqueValueFromDB("SELECT recherche FROM copybonus WHERE player_id={$player}");
            $result['nbretrain'][$player] = self::getUniqueValueFromDB("SELECT train FROM player WHERE player_id={$player}");
            $result['copynbretrain'][$player] = self::getUniqueValueFromDB("SELECT train FROM copybonus WHERE player_id={$player}");
            $result['nbrewild'][$player] = self::getUniqueValueFromDB("SELECT wild FROM player WHERE player_id={$player}");
            $result['copynbrewild'][$player] = self::getUniqueValueFromDB("SELECT wild FROM copybonus WHERE player_id={$player}");
            $result['nbretrainstart'][$player] = self::getUniqueValueFromDB("SELECT trainstart FROM player WHERE player_id={$player}");
            $result['compteurcardtokyodiscard'][$player] = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location = 'discardboard' and card_location_arg = {$player}", true));
            $result['compteurcardkyotodiscard'][$player] = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location = 'discardboard' and card_location_arg = {$player}", true));
            $result['r'][$player] = self::getUniqueValueFromDB("SELECT r FROM player WHERE player_id={$player}");
            $result['g'][$player] = self::getUniqueValueFromDB("SELECT g FROM player WHERE player_id={$player}");
            $result['p'][$player] = self::getUniqueValueFromDB("SELECT p FROM player WHERE player_id={$player}");
            $result['y'][$player] = self::getUniqueValueFromDB("SELECT y FROM player WHERE player_id={$player}");
            $result['b'][$player] = self::getUniqueValueFromDB("SELECT b FROM player WHERE player_id={$player}");
            $result['happy1'][$player] = self::getUniqueValueFromDB("SELECT happy1 FROM player WHERE player_id={$player}");
            $result['happy2'][$player] = self::getUniqueValueFromDB("SELECT happy2 FROM player WHERE player_id={$player}");
            $result['angry1'][$player] = self::getUniqueValueFromDB("SELECT angry1 FROM player WHERE player_id={$player}");
            $result['angry2'][$player] = self::getUniqueValueFromDB("SELECT angry2 FROM player WHERE player_id={$player}");
            $result['numero'][$player] = self::getUniqueValueFromDB("SELECT player_no FROM player WHERE player_id={$player}");
            $result['name'][$player] = self::getUniqueValueFromDB("SELECT player_name FROM player WHERE player_id={$player}");
            $result['lundi'][$player] = self::getUniqueValueFromDB("SELECT lundi FROM player WHERE player_id={$player}");
            $result['mardi'][$player] = self::getUniqueValueFromDB("SELECT mardi FROM player WHERE player_id={$player}");
            $result['mercredi'][$player] = self::getUniqueValueFromDB("SELECT mercredi FROM player WHERE player_id={$player}");
            $result['jeudi'][$player] = self::getUniqueValueFromDB("SELECT jeudi FROM player WHERE player_id={$player}");
            $result['vendredi'][$player] = self::getUniqueValueFromDB("SELECT vendredi FROM player WHERE player_id={$player}");
            $result['samedi'][$player] = self::getUniqueValueFromDB("SELECT samedi FROM player WHERE player_id={$player}");
            $result['scorehumeur'][$player] = self::getUniqueValueFromDB("SELECT scorehumeur FROM player WHERE player_id={$player}");
            $result['scoretoken'][$player] = self::getUniqueValueFromDB("SELECT scoretoken FROM player WHERE player_id={$player}");
            $result['scoretrain'][$player] = self::getUniqueValueFromDB("SELECT scoretrain FROM player WHERE player_id={$player}");
            $result['scorerecherche'][$player] = self::getUniqueValueFromDB("SELECT scorerecherche FROM player WHERE player_id={$player}");
            $result['scoretotal'][$player] = self::getUniqueValueFromDB("SELECT scoretotal FROM player WHERE player_id={$player}");
            $result['lundicheck'][$player] = self::getUniqueValueFromDB("SELECT lundicheck FROM player WHERE player_id={$player}");
            $result['mardicheck'][$player] = self::getUniqueValueFromDB("SELECT mardicheck FROM player WHERE player_id={$player}");
            $result['mercredicheck'][$player] = self::getUniqueValueFromDB("SELECT mercredicheck FROM player WHERE player_id={$player}");
            $result['jeudicheck'][$player] = self::getUniqueValueFromDB("SELECT jeudicheck FROM player WHERE player_id={$player}");
            $result['vendredicheck'][$player] = self::getUniqueValueFromDB("SELECT vendredicheck FROM player WHERE player_id={$player}");
            $result['samedicheck'][$player] = self::getUniqueValueFromDB("SELECT samedicheck FROM player WHERE player_id={$player}");

            $result['passportcard'][$player] = self::getUniqueValueFromDB("SELECT passportcard FROM player WHERE player_id={$player}");
            $result['passportscore'][$player] = self::getUniqueValueFromDB("SELECT passportscore FROM player WHERE player_id={$player}");

            

        }

        $count= count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

        if($count == 1)
        {
        $result['r'][0] = self::getUniqueValueFromDB("SELECT r FROM agent WHERE name='agent'");
        $result['g'][0] = self::getUniqueValueFromDB("SELECT g FROM agent WHERE name='agent'");
        $result['p'][0] = self::getUniqueValueFromDB("SELECT p FROM agent WHERE name='agent'");
        $result['y'][0] = self::getUniqueValueFromDB("SELECT y FROM agent WHERE name='agent'");
        $result['b'][0] = self::getUniqueValueFromDB("SELECT b FROM agent WHERE name='agent'");
        $result['smile'][0] = self::getUniqueValueFromDB("SELECT smile FROM agent WHERE name='agent'");
        $result['happy'][0] = self::getUniqueValueFromDB("SELECT happy FROM agent WHERE name='agent'");
        $result['angry'][0] = self::getUniqueValueFromDB("SELECT angry FROM agent WHERE name='agent'");
        $result['lundi'][0] = self::getUniqueValueFromDB("SELECT lundi FROM agent WHERE name='agent'");
        $result['mardi'][0] = self::getUniqueValueFromDB("SELECT mardi FROM agent WHERE name='agent'");
        $result['mercredi'][0] = self::getUniqueValueFromDB("SELECT mercredi FROM agent WHERE name='agent'");
        $result['jeudi'][0] = self::getUniqueValueFromDB("SELECT jeudi FROM agent WHERE name='agent'");
        $result['vendredi'][0] = self::getUniqueValueFromDB("SELECT vendredi FROM agent WHERE name='agent'");
        $result['samedi'][0] = self::getUniqueValueFromDB("SELECT samedi FROM agent WHERE name='agent'");
        $result['scorehumeur'][0] = self::getUniqueValueFromDB("SELECT scorehumeur FROM agent WHERE name='agent'");
        $result['scoretoken'][0] = self::getUniqueValueFromDB("SELECT scoretoken FROM agent WHERE name='agent'");
        $result['scoretrain'][0] = self::getUniqueValueFromDB("SELECT scoretrain FROM agent WHERE name='agent'");
        $result['scorerecherche'][0] = self::getUniqueValueFromDB("SELECT scorerecherche FROM agent WHERE name='agent'");
        $result['scoretotal'][0] = self::getUniqueValueFromDB("SELECT scoretotal FROM agent WHERE name='agent'");
        $result['lundicheck'][0] = self::getUniqueValueFromDB("SELECT lundicheck FROM agent WHERE name='agent'");
        $result['mardicheck'][0] = self::getUniqueValueFromDB("SELECT mardicheck FROM agent WHERE name='agent'");
        $result['mercredicheck'][0] = self::getUniqueValueFromDB("SELECT mercredicheck FROM agent WHERE name='agent'");
        $result['jeudicheck'][0] = self::getUniqueValueFromDB("SELECT jeudicheck FROM agent WHERE name='agent'");
        $result['vendredicheck'][0] = self::getUniqueValueFromDB("SELECT vendredicheck FROM agent WHERE name='agent'");
        $result['samedicheck'][0] = self::getUniqueValueFromDB("SELECT samedicheck FROM agent WHERE name='agent'");

        $result['lvl'][] = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name='agent'");

        $playersolo = self::getUniqueValueFromDB("SELECT player_id FROM player WHERE player_no=1");
        $result['maxtrip'][0] = max(self::CountTrip($playersolo));
        $result['phase'][0] = self::getUniqueValueFromDB("SELECT function FROM pending WHERE player_id={$playersolo}");
        }

        $result['tokyocards'] = $this->tokyocards;
        $result['kyotocards'] = $this->kyotocards;
        $result['passportcards'] = $this->passportcards;

        

        return $result;
    }

    
    
/////////////////////////////////////////////////////////////////////////////////  
//     _____                      _____                                   _             
//    / ____|                    |  __ \                                 (_)            
//   | |  __  __ _ _ __ ___   ___| |__) | __ ___   __ _ _ __ ___  ___ ___ _  ___  _ __  
//   | | |_ |/ _` | '_ ` _ \ / _ \  ___/ '__/ _ \ / _` | '__/ _ \/ __/ __| |/ _ \| '_ \ 
//   | |__| | (_| | | | | | |  __/ |   | | | (_) | (_| | | |  __/\__ \__ \ | (_) | | | |
//    \_____|\__,_|_| |_| |_|\___|_|   |_|  \___/ \__, |_|  \___||___/___/_|\___/|_| |_|
//                                                 __/ |                                
//                                                |___/                                 
////////////////////////////////////////////////////////////////////////////////


function getGameProgression()
{
    $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
    $progession = floor(($turn*100)/15);

    return $progession;
}



/////////////////////////////////////////////////////////////////////////////////  
//     _    _ _   _ _ _ _            __                  _   _                 
//    | |  | | | (_) (_) |          / _|                | | (_)                
//    | |  | | |_ _| |_| |_ _   _  | |_ _   _ _ __   ___| |_ _  ___  _ __  ___ 
//    | |  | | __| | | | __| | | | |  _| | | | '_ \ / __| __| |/ _ \| '_ \/ __|
//    | |__| | |_| | | | |_| |_| | | | | |_| | | | | (__| |_| | (_) | | | \__ \
//     \____/ \__|_|_|_|\__|\__, | |_|  \__,_|_| |_|\___|\__|_|\___/|_| |_|___/
//                           __/ |                                             
//                          |___/                                              
/////////////////////////////////////////////////////////////////////////////////   

   
function addPending($player_id, $function, $arg = NULL, $arg2 = NULL, $arg3 = NULL, $arg4 = NULL) {
    $sql = "INSERT INTO pending (player_id, function, arg, arg2, arg3, arg4) VALUES (".$player_id.", '".$function."', '".$arg."', '".$arg2."', '".$arg3."', '".$arg4."')";
    self::DbQuery( $sql );
}

function addPendingTarget($player_id, $function, $target, $arg = NULL, $arg2 = NULL, $arg3 = NULL, $arg4 = NULL) {
    $sql = "INSERT INTO pending (player_id, function, target, arg, arg2, arg3, arg4) VALUES (".$player_id.", '".$function."', '".$target."', '".$arg."', '".$arg2."', '".$arg3."', '".$arg4."')";
    self::DbQuery( $sql );
}

function addPendingFirst($player_id, $function, $arg = NULL, $arg2 = NULL, $arg3 = NULL, $arg4 = NULL) {
    $minid = self::getUniqueValueFromDB( "select min(id) from pending")-1;
    $sql = "INSERT INTO pending (id, player_id, function, arg, arg2) VALUES (".$minid.",".$player_id.", '".$function."', '".$arg."', '".$arg2."')";
    self::DbQuery( $sql );
}

function checkArgs($arg1)
    {
        $ret = self::argPlayerTurn();

        $id = self::getCurrentPlayerId();

            
        if(!in_array($arg1,$ret[$id][0]['selectable']) && !in_array($arg1,$ret[$id][0]['selectable2']) && !in_array($arg1,$ret[$id][0]['selectableswitch']) && !in_array($arg1,$ret[$id][0]['buttons']))
        {
            throw new feException( "Not a valid selection");
        }
        
    }

function getPlayerRelativePositions()  // permet de mettre dans view.php les joueurs dans l'ordre de la base de données et de positionner le current player en haut avec les autres joueurs dans l'ordre du tour
    {
        $result = array();
        
        $players = self::loadPlayersBasicInfos();
        $nextPlayer = self::createNextPlayerTable(array_keys($players)); //met joueurs dans l'ordre du tour au niveau de l'affichage à droite
        
        $current_player = self::getCurrentPlayerId();
        
        if(!isset($nextPlayer[$current_player])) {
            // Spectator mode: prend la vue du premier joueur de la liste
            $player_id = $nextPlayer[0];
        }
        else {
            // Normal mode: current player est premier de la liste puis les autres dans l ordre de la base de données player
            $player_id = $current_player;
        }
        $result[] = $player_id;
        
        for($i=1; $i<count($players); $i++) {
            $player_id = $nextPlayer[$player_id];
            $result[] = $player_id;
        }
        return $result;
    }

function CountTrip($id)
{
    if($id != 0)
    {
    $count1 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_1%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_1%'", true )));
    $count2 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_2%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_2%'", true )));
    $count3 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_3%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_3%'", true )));
    $count4 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_4%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_4%'", true )));
    $count5 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_5%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_5%'", true )));
    $count6 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_6%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_6%'", true )));
    }

    if($id == 0)
    {
    $count1 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_1%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_1%'", true )));
    $count2 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_2%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_2%'", true )));
    $count3 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_3%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_3%'", true )));
    $count4 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_4%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_4%'", true )));
    $count5 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_5%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_5%'", true )));
    $count6 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_6%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_6%'", true )));
    }


    $ret = [$count1,$count2,$count3,$count4,$count5,$count6];
    
    return $ret;
 
}

function Deployer($id)
{
    $counttrip = letsgotojapan::$instance->CountTrip($id);
    $jour = 0;
    $card1 = null;
    $card2 = null;

    foreach ($counttrip as $count)
    {
        $jour = $jour+1;
        if (($count>=1)&&($count <= 2))
        {
            $ville1 =1;
            $ville2 =1;

            if ($count == 2)
            {
                $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                if ($card2 != null)
                {
                letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_4', $id);
                }
                if ($card2 == null)
                {
                    $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                    $ville2 =2;
                    letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_4', $id);
                }

            }

            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_1'");
            if ($card1 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_2', $id);
            }
            if ($card1 == null)
            {
                $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_1'");
                $ville1 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_2', $id);
            }

            
            $maxtrip = max(letsgotojapan::$instance->CountTrip($id));

            letsgotojapan::$instance->notifyAllPlayers('deployer','', array(
                'jour' =>  $jour,
                'count' => $count,
                'card1' => $card1,
                'card2' => $card2,
                'ville1' => $ville1,
                'ville2' => $ville2,
                'playerid' => $id,
                'maxtrip' => $maxtrip,
                    
                )
                );
        }
    
    }
}

function DeployerExtraWalk($id, $jour)
{
    $card1 = null;
    $card2 = null;
    $card3 = null;

    
        
    $ville1 =1;
    $ville2 =1;
    $ville3 =1;


    $card3 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_3'");
        if ($card3 != null)
        {
        letsgotojapan::$instance->tokyo->moveCard( $card3, 'cardposition_'.$jour.'_6', $id);
        }
        if ($card3 == null)
        {
            $card3 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_3'");
            $ville3 =2;
            letsgotojapan::$instance->kyoto->moveCard( $card3, 'cardposition_'.$jour.'_6', $id);
        }

    $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
    if ($card2 != null)
    {
    letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_4', $id);
    }
    if ($card2 == null)
    {
        $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
        $ville2 =2;
        letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_4', $id);
    }

    
    $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_1'");
    if ($card1 != null)
    {
        letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_2', $id);
    }
    if ($card1 == null)
    {
        $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_1'");
        $ville1 =2;
        letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_2', $id);
    }

            


            letsgotojapan::$instance->notifyAllPlayers('deployerextrawalk','', array(
                'jour' =>  $jour,
                'card1' => $card1,
                'card2' => $card2,
                'card3' => $card3,
                'ville1' => $ville1,
                'ville2' => $ville2,
                'ville3' => $ville3,
                'playerid' => $id,
                    
                )
                );
        
    
    
}

function Condenser($id, $new)
{
    $counttrip = letsgotojapan::$instance->CountTrip($id);
    $jour = 0;
    
        
    if ($new == 0)
    {

        foreach ($counttrip as $count)
        {
            $jour = $jour+1;
            if (($count>=1)&&($count<=2))
            {
                $card1 = null;
                $card2 = null;
                $card3 = null;
                $ville1 =1;
                $ville2 =1;
                $ville3 =1;

                $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                if ($card1 != null)
                {
                    letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                }
                if ($card1 == null)
                {
                    $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                    $ville1 =2;
                    letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                }

                if ($count >=2)
                {
                    $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                    if ($card2 != null)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                    }
                    if ($card2 == null)
                    {
                        $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                        $ville2 =2;
                        letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                    }

                }

                
                $maxtrip = max(letsgotojapan::$instance->CountTrip($id));
                
                letsgotojapan::$instance->notifyAllPlayers('condensersansmodif','', array(
                    'jour' =>  $jour,
                    'count' => $count,
                    'card1' => $card1,
                    'card2' => $card2,
                    'card3' => $card3,
                    'ville1' => $ville1,
                    'ville2' => $ville2,
                    'ville3' => $ville3,
                    'playerid' => $id,
                    'maxtrip' => $maxtrip,
                        
                    )
                    );
            }
        
        }
    }

    else
    {
        $explode = explode('_',$new);
        $jouradd = $explode[1];
        $positionadd = $explode[2];

        foreach ($counttrip as $count)
        {
            $jour = $jour+1;

            if (($count>=1)&&($count <= 2)&&($jour!=$jouradd))
            {
                $card1 = null;
                $card2 = null;
                $card3 = null;
                $ville1 =1;
                $ville2 =1;
                $ville3 =1;

                $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                if ($card1 != null)
                {
                    letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                }
                if ($card1 == null)
                {
                    $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                    $ville1 =2;
                    letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                }

                if ($count >=2)
                {
                    $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                    if ($card2 != null)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                    }
                    if ($card2 == null)
                    {
                        $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                        $ville2 =2;
                        letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                    }

                }

                $maxtrip = max(letsgotojapan::$instance->CountTrip($id));

                letsgotojapan::$instance->notifyAllPlayers('condenseravecmodif','', array(
                    'jour' =>  $jour,
                    'count' => $count,
                    'count0' => 1,
                    'card1' => $card1,
                    'card2' => $card2,
                    'card3' => $card3,
                    'ville1' => $ville1,
                    'ville2' => $ville2,
                    'ville3' => $ville3,
                    'playerid' => $id,
                    'maxtrip' => $maxtrip,
                        
                    )
                    );
            }


            if (($count>=1)&&($count <= 3)&&($jour==$jouradd))
            {   
                $card1 = null;
                $card2 = null;
                $card3 = null;
                $ville1 =1;
                $ville2 =1;
                $ville3 =1;

                if($count == 1)
                {

                    $maxtrip = max(letsgotojapan::$instance->CountTrip($id));

                    letsgotojapan::$instance->notifyAllPlayers('condenseravecmodif','', array(
                        'count0' => 1,
                        'maxtrip' => $maxtrip,
                            
                        )
                        );

                }

                if($count == 2)
                {
                    if($positionadd==3)
                    {
                        $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                        if ($card1 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                        }
                        if ($card1 == null)
                        {
                            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                            $ville1 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                        }

                        $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_3'");
                        if ($card2 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                        }
                        if ($card2 == null)
                        {
                            $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_3'");
                            $ville2 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                        }

                        $maxtrip = max(letsgotojapan::$instance->CountTrip($id));

                        letsgotojapan::$instance->notifyAllPlayers('condenseravecmodif','', array(
                            'jour' =>  $jour,
                            'count' => $count,
                            'count0' => 1,
                            'card1' => $card1,
                            'card2' => $card2,
                            'card3' => $card3,
                            'ville1' => $ville1,
                            'ville2' => $ville2,
                            'ville3' => $ville3,
                            'playerid' => $id,
                            'maxtrip' => $maxtrip,
                                
                            )
                            );
                        
                    }


                }

                if($count == 3)
                {
                    if($positionadd==1)
                    {
                        $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_1'");
                        if ($card1 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                        }
                        if ($card1 == null)
                        {
                            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_1'");
                            $ville1 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                        }

                        $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                        if ($card2 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                        }
                        if ($card2 == null)
                        {
                            $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                            $ville2 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                        }

                        $card3 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                        if ($card3 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
                        }
                        if ($card3 == null)
                        {
                            $card3 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                            $ville3 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
                        }
                    }

                    if($positionadd==3)
                    {
                        $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                        if ($card1 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                        }
                        if ($card1 == null)
                        {
                            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                            $ville1 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                        }

                        $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_3'");
                        if ($card2 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                        }
                        if ($card2 == null)
                        {
                            $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_3'");
                            $ville2 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                        }

                        $card3 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                        if ($card3 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
                        }
                        if ($card3 == null)
                        {
                            $card3 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                            $ville3 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
                        }
                    }

                    if($positionadd==5)
                    {
                        $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                        if ($card1 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                        }
                        if ($card1 == null)
                        {
                            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                            $ville1 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
                        }

                        $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                        if ($card2 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                        }
                        if ($card2 == null)
                        {
                            $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                            $ville2 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
                        }

                        $card3 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_5'");
                        if ($card3 != null)
                        {
                            letsgotojapan::$instance->tokyo->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
                        }
                        if ($card3 == null)
                        {
                            $card3 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_5'");
                            $ville3 =2;
                            letsgotojapan::$instance->kyoto->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
                        }
                    }

                    
                    $maxtrip = max(letsgotojapan::$instance->CountTrip($id));

                        letsgotojapan::$instance->notifyAllPlayers('condenseravecmodif','', array(
                            'jour' =>  $jour,
                            'count' => $count,
                            'count0' => 1,
                            'card1' => $card1,
                            'card2' => $card2,
                            'card3' => $card3,
                            'ville1' => $ville1,
                            'ville2' => $ville2,
                            'ville3' => $ville3,
                            'playerid' => $id,
                            'maxtrip' => $maxtrip,
                                
                            )
                            );
                

                }


            }


        }

    }
}

function CondenserExtraWalk($id, $jour, $new)
{
    

    if ($new == 0)
    {

        $card1 = null;
        $card2 = null;
        $card3 = null;
        $ville1 =1;
        $ville2 =1;
        $ville3 =1;

        $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
        if ($card1 != null)
        {
            letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
        }
        if ($card1 == null)
        {
            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
            $ville1 =2;
            letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
        }

    
        $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
        if ($card2 != null)
        {
            letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
        }
        if ($card2 == null)
        {
            $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
            $ville2 =2;
            letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
        }

        $card3 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
        if ($card3 != null)
        {
            letsgotojapan::$instance->tokyo->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
        }
        if ($card3 == null)
        {
            $card3 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
            $ville3 =2;
            letsgotojapan::$instance->kyoto->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
        }

                

                
                letsgotojapan::$instance->notifyAllPlayers('condensersansmodif','', array(
                    'jour' =>  $jour,
                    'count' => 3,
                    'card1' => $card1,
                    'card2' => $card2,
                    'card3' => $card3,
                    'ville1' => $ville1,
                    'ville2' => $ville2,
                    'ville3' => $ville3,
                    'playerid' => $id,
                        
                    )
                    );
    }
        
        
    

    else
    {
        $explode = explode('_',$new);
        $positionadd = $explode[2];

        $card1 = null;
        $card2 = null;
        $card3 = null;
        $card4 = null;
        $ville1 =1;
        $ville2 =1;
        $ville3 =1;
        $ville4 =1;


        if($positionadd==1)
        {
            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_1'");
            if ($card1 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
            }
            if ($card1 == null)
            {
                $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_1'");
                $ville1 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
            }

            $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
            if ($card2 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
            }
            if ($card2 == null)
            {
                $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                $ville2 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
            }

            $card3 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
            if ($card3 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
            }
            if ($card3 == null)
            {
                $card3 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                $ville3 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
            }

            $card4 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
            if ($card4 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card4, 'cardposition_'.$jour.'_4', $id);
            }
            if ($card4 == null)
            {
                $card4 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
                $ville4 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card4, 'cardposition_'.$jour.'_4', $id);
            }
        }

        if($positionadd==3)
        {
            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
            if ($card1 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
            }
            if ($card1 == null)
            {
                $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                $ville1 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
            }

            $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_3'");
            if ($card2 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
            }
            if ($card2 == null)
            {
                $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_3'");
                $ville2 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
            }

            $card3 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
            if ($card3 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
            }
            if ($card3 == null)
            {
                $card3 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                $ville3 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
            }

            $card4 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
            if ($card4 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card4, 'cardposition_'.$jour.'_4', $id);
            }
            if ($card4 == null)
            {
                $card4 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
                $ville4 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card4, 'cardposition_'.$jour.'_4', $id);
            }
        }

        if($positionadd==5)
        {
            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
            if ($card1 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
            }
            if ($card1 == null)
            {
                $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                $ville1 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
            }

            $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
            if ($card2 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
            }
            if ($card2 == null)
            {
                $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                $ville2 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
            }

            $card3 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_5'");
            if ($card3 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
            }
            if ($card3 == null)
            {
                $card3 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_5'");
                $ville3 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
            }

            $card4 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
            if ($card4 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card4, 'cardposition_'.$jour.'_4', $id);
            }
            if ($card4 == null)
            {
                $card4 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
                $ville4 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card4, 'cardposition_'.$jour.'_4', $id);
            }
        }

        if($positionadd==7)
        {
            $card1 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
            if ($card1 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
            }
            if ($card1 == null)
            {
                $card1 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_2'");
                $ville1 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card1, 'cardposition_'.$jour.'_1', $id);
            }

            $card2 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
            if ($card2 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
            }
            if ($card2 == null)
            {
                $card2 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_4'");
                $ville2 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card2, 'cardposition_'.$jour.'_2', $id);
            }

            $card3 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
            if ($card3 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
            }
            if ($card3 == null)
            {
                $card3 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_6'");
                $ville3 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card3, 'cardposition_'.$jour.'_3', $id);
            }

            $card4 = self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_7'");
            if ($card4 != null)
            {
                letsgotojapan::$instance->tokyo->moveCard( $card4, 'cardposition_'.$jour.'_4', $id);
            }
            if ($card4 == null)
            {
                $card4 = self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$id} AND card_location ='cardposition_" . $jour . "_7'");
                $ville4 =2;
                letsgotojapan::$instance->kyoto->moveCard( $card4, 'cardposition_'.$jour.'_4', $id);
            }
        }

        letsgotojapan::$instance->notifyAllPlayers('condenserextrawalkavecmodif','', array(
            'jour' =>  $jour,
            'card1' => $card1,
            'card2' => $card2,
            'card3' => $card3,
            'card4' => $card4,
            'ville1' => $ville1,
            'ville2' => $ville2,
            'ville3' => $ville3,
            'ville4' => $ville4,
            'playerid' => $id,
                
            )
            );
        


    }

    
}

function Smile($gain, $player)
{
    $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");

    if($player!=0)
    {
    if ($gain>0)
    {
        for($i=1; $i<=$gain; $i++)
        {
            self::DbQuery( "UPDATE player set smile = smile + 1  WHERE player_id = {$player}" );
            $newsmile = self::getUniqueValueFromDB("SELECT smile FROM player WHERE player_id={$player}");
            letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                'position' => $newsmile,
                'player' => $player,
                'turn' => $turn,
                )
                );
            

            if ($newsmile == 3)
            {
                self::DbQuery( "UPDATE player set smile = 0  WHERE player_id = {$player}" );
                $newsmile = self::getUniqueValueFromDB("SELECT smile FROM player WHERE player_id={$player}");
                letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                    'position' => $newsmile,
                    'player' => $player,
                    'turn' => $turn,
                    )
                    );
                
                
                $happy = self::getUniqueValueFromDB("SELECT happy FROM player WHERE player_id={$player}");
                if($happy < 3)
                {
                    self::DbQuery( "UPDATE player set happy = happy+1  WHERE player_id = {$player}" );
                    $newhappy = self::getUniqueValueFromDB("SELECT happy FROM player WHERE player_id={$player}");
                    letsgotojapan::$instance->notifyAllPlayers('happy','', array(
                        'position' => $newhappy,
                        'player' => $player,
                        'turn' => $turn,
                        )
                        );

                }


            }


        }

    }

    if ($gain<0)
    {
        for($i=-1; $i>=$gain; $i--)
        {
            self::DbQuery( "UPDATE player set smile = smile - 1  WHERE player_id = {$player}" );
            $newsmile = self::getUniqueValueFromDB("SELECT smile FROM player WHERE player_id={$player}");
            letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                'position' => $newsmile,
                'player' => $player,
                'turn' => $turn,
                )
                );
            

            if ($newsmile == -3)
            {
                self::DbQuery( "UPDATE player set smile = 0  WHERE player_id = {$player}" );
                $newsmile = self::getUniqueValueFromDB("SELECT smile FROM player WHERE player_id={$player}");
                letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                    'position' => $newsmile,
                    'player' => $player,
                    'turn' => $turn,
                    )
                    );
                

                $angry = self::getUniqueValueFromDB("SELECT angry FROM player WHERE player_id={$player}");
                if($angry < 3)
                {
                    self::DbQuery( "UPDATE player set angry = angry+1  WHERE player_id = {$player}" );
                    $newangry = self::getUniqueValueFromDB("SELECT angry FROM player WHERE player_id={$player}");
                    letsgotojapan::$instance->notifyAllPlayers('angry','', array(
                        'position' => $newangry,
                        'player' => $player,
                        'turn' => $turn,
                        )
                        );

                }

            }


        }

    }
    }

    if($player==0)
    {
    if ($gain>0)
    {
        for($i=1; $i<=$gain; $i++)
        {
            self::DbQuery( "UPDATE agent set smile = smile + 1  WHERE name = 'agent'" );
            $newsmile = self::getUniqueValueFromDB("SELECT smile FROM agent WHERE name = 'agent'");
            letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                'position' => $newsmile,
                'player' => $player,
                'turn' => $turn,
                )
                );
            

            if ($newsmile == 3)
            {
                self::DbQuery( "UPDATE agent set smile = 0 WHERE name = 'agent'" );;
                $newsmile = self::getUniqueValueFromDB("SELECT smile FROM agent WHERE name = 'agent'");
                letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                    'position' => $newsmile,
                    'player' => $player,
                    'turn' => $turn,
                    )
                    );
                
                
                $happy = self::getUniqueValueFromDB("SELECT happy FROM agent WHERE name = 'agent'");
                if($happy < 3)
                {
                    self::DbQuery( "UPDATE agent set happy = happy + 1  WHERE name = 'agent'" );
                    $newhappy = self::getUniqueValueFromDB("SELECT happy FROM agent WHERE name = 'agent'");
                    letsgotojapan::$instance->notifyAllPlayers('happy','', array(
                        'position' => $newhappy,
                        'player' => $player,
                        'turn' => $turn,
                        )
                        );

                }


            }


        }

    }

    if ($gain<0)
    {
        for($i=-1; $i>=$gain; $i--)
        {
            self::DbQuery( "UPDATE agent set smile = smile - 1  WHERE name = 'agent'" );
            $newsmile = self::getUniqueValueFromDB("SELECT smile FROM agent WHERE name = 'agent'");
            letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                'position' => $newsmile,
                'player' => $player,
                'turn' => $turn,
                )
                );
            

            if ($newsmile == -3)
            {
                self::DbQuery( "UPDATE agent set smile = 0 WHERE name = 'agent'" );;
                $newsmile = self::getUniqueValueFromDB("SELECT smile FROM agent WHERE name = 'agent'");
                letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                    'position' => $newsmile,
                    'player' => $player,
                    'turn' => $turn,
                    )
                    );
                

                $angry = self::getUniqueValueFromDB("SELECT angry FROM agent WHERE name = 'agent'");
                if($angry < 3)
                {
                    self::DbQuery( "UPDATE agent set angry = angry + 1  WHERE name = 'agent'" );
                    $newangry = self::getUniqueValueFromDB("SELECT angry FROM agent WHERE name = 'agent'");
                    letsgotojapan::$instance->notifyAllPlayers('angry','', array(
                        'position' => $newangry,
                        'player' => $player,
                        'turn' => $turn,
                        )
                        );

                }

            }


        }

    }
    }

}

function MajPannel ($id)
{
    $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");

    $recherche = self::getUniqueValueFromDB("SELECT recherche FROM player WHERE player_id={$id}");
    $train = self::getUniqueValueFromDB("SELECT train FROM player WHERE player_id={$id}");
    $trainstart = self::getUniqueValueFromDB("SELECT trainstart FROM player WHERE player_id={$id}");
    $wild = self::getUniqueValueFromDB("SELECT wild FROM player WHERE player_id={$id}");

    letsgotojapan::$instance->notifyAllPlayers('majpannel','', array(
        'id' =>  $id,
        'recherche' => $recherche,
        'train' => $train,
        'trainstart' => $trainstart,
        'wild' => $wild,
        'turn' => $turn,
        
        )
        );



}

function getLogsType( $type ) 
{
    if($type == 1)
    {return "<div class='logsmile' title=''></div>";}
    if($type == 2)
    {return "<div class='logrecherche' title=''></div>";}
    if($type == 3)
    {return "<div class='logwild' title=''></div>";}
    if($type == 4)
    {return "<div class='logwalk' title=''></div>";}
    if($type == 5)
    {return "<div class='logtrainstart' title=''></div>";}
    if($type == 6)
    {return "<div class='logtrainbonus' title=''></div>";}
    if($type == 7)
    {return "<div class='logtrainmalus' title=''></div>";}
    if($type == 8)
    {return "<div class='logpv' title=''></div>";}
    if($type == 9)
    {return "<div class='logr' title=''></div>";}
    if($type == 10)
    {return "<div class='logg' title=''></div>";}
    if($type ==11)
    {return "<div class='logp' title=''></div>";}
    if($type == 12)
    {return "<div class='logy' title=''></div>";}
    if($type == 13)
    {return "<div class='logb' title=''></div>";}
    
        

}

function Gain($type, $player)
{
    if($player !=0 )
    {
        $passport = self::getUniqueValueFromDB("SELECT passportcard FROM player WHERE player_id = {$player}");

    if($type == 'r')
    {
        self::DbQuery( "UPDATE player set r = r +1   WHERE player_id = {$player}" );
        $new = self::getUniqueValueFromDB("SELECT r FROM player WHERE player_id = {$player}");

        
        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'r',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'r',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'r',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'r',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }

    }

    if($type == 'g')
    {
        self::DbQuery( "UPDATE player set g = g +1   WHERE player_id = {$player}" );
        $new = self::getUniqueValueFromDB("SELECT g FROM player WHERE player_id = {$player}");
        
        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'g',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'g',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'g',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'g',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }
        
    }

    if($type == 'p')
    {
        self::DbQuery( "UPDATE player set p = p +1   WHERE player_id = {$player}" );
        $new = self::getUniqueValueFromDB("SELECT p FROM player WHERE player_id = {$player}");

        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'p',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'p',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'p',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'p',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }
    }

    if($type == 'y')
    {
        self::DbQuery( "UPDATE player set y = y +1   WHERE player_id = {$player}" );
        $new = self::getUniqueValueFromDB("SELECT y FROM player WHERE player_id = {$player}");

        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'y',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'y',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'y',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'y',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }
    }

    if($type == 'b')
    {
        self::DbQuery( "UPDATE player set b = b +1   WHERE player_id = {$player}" );
        $new = self::getUniqueValueFromDB("SELECT b FROM player WHERE player_id = {$player}");

        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'b',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'b',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'b',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'b',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }

        if($passport== 9)
        {
            letsgotojapan::$instance->Smile(1,$player);
            self::DbQuery( "UPDATE player set passportscore = passportscore +1   WHERE player_id = {$player}" );
            letsgotojapan::$instance->MajScorePassport(9,$player);
        }

    }

    if($type == 'h1')
    {
        self::DbQuery( "UPDATE player set happy1 = happy1 +1   WHERE player_id = {$player}" );
        letsgotojapan::$instance->Smile(1,$player);

        if($passport== 8)
        {
            
            self::DbQuery( "UPDATE player set passportscore = passportscore +1   WHERE player_id = {$player}" );
            letsgotojapan::$instance->MajScorePassport(8,$player);
        }
        
    }

    if($type == 'h2')
    {
        self::DbQuery( "UPDATE player set happy2 = happy2 +1   WHERE player_id = {$player}" );
        letsgotojapan::$instance->Smile(1,$player);

        if($passport== 2)
        {
            letsgotojapan::$instance->Smile(1,$player);
            self::DbQuery( "UPDATE player set passportscore = passportscore +1   WHERE player_id = {$player}" );
            letsgotojapan::$instance->MajScorePassport(2,$player);
        }
    }

    if($type == 'a1')
    {
        self::DbQuery( "UPDATE player set angry1 = angry1 +1   WHERE player_id = {$player}" );
        letsgotojapan::$instance->Smile(-1,$player);

        if($passport== 8)
        {
            
            self::DbQuery( "UPDATE player set passportscore = passportscore +2   WHERE player_id = {$player}" );
            letsgotojapan::$instance->MajScorePassport(8,$player);
        }
    }

    if($type == 'a2')
    {
        self::DbQuery( "UPDATE player set angry2 = angry2 +1   WHERE player_id = {$player}" );
        if($passport!= 7)
        {
        letsgotojapan::$instance->Smile(-1,$player);
        }
        if($passport== 7)
        {
            self::DbQuery( "UPDATE player set passportscore = passportscore +1   WHERE player_id = {$player}" );
            letsgotojapan::$instance->MajScorePassport(7,$player);
        }
    }
    }


    if($player == 0 )
    {
    if($type == 'r')
    {
        self::DbQuery( "UPDATE agent set r = r +1   WHERE name = 'agent'" );
        $new = self::getUniqueValueFromDB("SELECT r FROM agent WHERE name = 'agent'");

        
        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'r',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'r',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'r',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'r',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }

    }

    if($type == 'g')
    {
        self::DbQuery( "UPDATE agent set g = g +1   WHERE name = 'agent'" );
        $new = self::getUniqueValueFromDB("SELECT g FROM agent WHERE name = 'agent'");
        
        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'g',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'g',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'g',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'g',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }
        
    }

    if($type == 'p')
    {
        self::DbQuery( "UPDATE agent set p = p +1   WHERE name = 'agent'" );
        $new = self::getUniqueValueFromDB("SELECT p FROM agent WHERE name = 'agent'");

        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'p',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'p',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'p',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'p',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }
    }

    if($type == 'y')
    {
        self::DbQuery( "UPDATE agent set y = y +1   WHERE name = 'agent'" );
        $new = self::getUniqueValueFromDB("SELECT y FROM agent WHERE name = 'agent'");

        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'y',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'y',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'y',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'y',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }
    }

    if($type == 'b')
    {
        self::DbQuery( "UPDATE agent set b = b +1   WHERE name = 'agent'" );
        $new = self::getUniqueValueFromDB("SELECT b FROM agent WHERE name = 'agent'");

        if($new < 12)
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'b',
            'score' => $new,
            'player' => $player,
            'plus' => 0,
                        
            )
            );
        }
        if ($new == 12)
        {
            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'b',
                'score' => $new,
                'player' => $player,
                'plus' => 0,
                            
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
                'type' =>  'b',
                'score' => 0,
                'player' => $player,
                'plus' => 1,
                            
                )
                );

        }

        if(($new > 12)&&($new<=24))
        {
        letsgotojapan::$instance->notifyAllPlayers('movetoken','', array(
            'type' =>  'b',
            'score' => $new-12,
            'player' => $player,
            'plus' => 1,
                        
            )
            );
        }
    }

    if($type == 'h1')
    {
        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name = 'agent'" );
        letsgotojapan::$instance->Smile(1,$player);
        
    }

    if($type == 'h2')
    {
        self::DbQuery( "UPDATE agent set happy2 = happy2 +1   WHERE name = 'agent'" );
        letsgotojapan::$instance->Smile(1,$player);
    }

    if($type == 'a1')
    {
        self::DbQuery( "UPDATE agent set angry1 = angry1 +1   WHERE name = 'agent'" );
        letsgotojapan::$instance->Smile(-1,$player);
    }

    if($type == 'a2')
    {
        self::DbQuery( "UPDATE agent set angry2 = angry2 +1   WHERE name = 'agent'" );
        letsgotojapan::$instance->Smile(-1,$player);
    }
    }

    
    
    
    
 
}



function EtatToken($player)
{
    $ret = array();

    if($player !=0)
    {
    $ret[] = self::getUniqueValueFromDB("SELECT r FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT g FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT p FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT y FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT b FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT happy1 FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT happy2 FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT angry1 FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT angry2 FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT walkday FROM player WHERE player_id = {$player}");
    $ret[] = self::getUniqueValueFromDB("SELECT trainday FROM player WHERE player_id = {$player}");
    }

    if($player ==0)
    {
    $ret[] = self::getUniqueValueFromDB("SELECT r FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT g FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT p FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT y FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT b FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT happy1 FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT happy2 FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT angry1 FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT angry2 FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT walkday FROM agent WHERE name = 'agent'");
    $ret[] = self::getUniqueValueFromDB("SELECT trainday FROM agent WHERE name = 'agent'");
    }
    
    

    return $ret;
 
}

function FirstAgent ()
{
    $count1 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_1%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_1%'", true )));
    $count2 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_2%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_2%'", true )));
    $count3 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_3%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_3%'", true )));
    $count4 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_4%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_4%'", true )));
    $count5 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_5%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_5%'", true )));
    $count6 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_6%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = 0 AND card_location LIKE 'cardposition_6%'", true )));
    $tableau = [$count1,$count2,$count3,$count4,$count5,$count6];

    $day = 0;
    $position =0;
    foreach ($tableau as $nombre)
    {
        $day = $day + 1;
        if ($nombre == 0)
        {
            $position = 1;
            break;
        }

        if ($nombre == 1)
        {
            $position = 2;
            break;
        }

        if ($nombre == 2)
        {
            $position = 3;
            break;
        }

    }

    return ($day.'_'.$position);
}


function tableExists($tableName) {
    $query = "SHOW TABLES LIKE '$tableName'";
    $result = self::getObjectListFromDB($query);
    return !empty($result);
}

function MajScorePassport ($card, $player)
{
    $newscore = self::getUniqueValueFromDB( "SELECT passportscore FROM player WHERE  player_id = {$player}");
    letsgotojapan::$instance->notifyAllPlayers('majscorepassport','', array(
                    
        'card' => $card,
        'score' => $newscore,
        
                                    
        )
        ); 

    if($newscore>=0)
    {
    $name = self::getUniqueValueFromDB( "SELECT player_name FROM player WHERE  player_id = {$player}");
    letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} will have a bonus of ${score} ${log} at the end of the game thanks to the passport card'), array(
            'player_name' => $name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'score' => $newscore,

        )
        );
    }

    if($newscore<0)
    {
    $name = self::getUniqueValueFromDB( "SELECT player_name FROM player WHERE  player_id = {$player}");
    letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} will have a penalty of ${score} ${log} at the end of the game because of the passport card'), array(
            'player_name' => $name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'score' => $newscore,

        )
        );
    }

}



///////////////////////////////////////////////////////////////////////////////// 
//     _____  _                                    _   _                 
//    |  __ \| |                                  | | (_)                
//    | |__) | | __ _ _   _  ___ _ __    __ _  ___| |_ _  ___  _ __  ___ 
//    |  ___/| |/ _` | | | |/ _ \ '__|  / _` |/ __| __| |/ _ \| '_ \/ __|
//    | |    | | (_| | |_| |  __/ |    | (_| | (__| |_| | (_) | | | \__ \
//    |_|    |_|\__,_|\__, |\___|_|     \__,_|\___|\__|_|\___/|_| |_|___/
//                     __/ |                                             
//                    |___/                                              
/////////////////////////////////////////////////////////////////////////////////    

    
function actSelect($arg1)
{

self::checkAction( 'actSelect' );     
self::checkArgs($arg1);  

$id = self::getCurrentPlayerId();
$pending =  self::getObjectFromDB( "SELECT* FROM pending WHERE player_id = {$id} order by id desc limit 1");
$this->callPending($pending, true, $arg1);
self::DbQuery("delete from pending where id=".$pending['id']);

/*$test = 0;
while ($test==0)
{
    $pending2 =  self::getObjectFromDB( "SELECT* FROM pending WHERE player_id = {$id} order by id desc limit 1");
    if ($pending2 != null)
    {
        $action = $this->callPending($pending2, false);


        if (($action['selectable']==null)&&($action['buttons']==null))
        {
            $this->callPending($pending2, true);
            self::DbQuery("delete from pending where id=".$pending2['id']);
        }

        else
        {
            $test =1;
        }

    }

    else
    {
        $test =1;
    }*/



    $this->gamestate->nextState( 'next');
//}

}

function actButton($arg1)
{

self::checkAction( 'actSelect' );  
self::checkArgs($arg1);       
  
$id = self::getCurrentPlayerId();
$pending =  self::getObjectFromDB( "SELECT* FROM pending WHERE player_id = {$id} order by id desc limit 1");
$this->callPending($pending, true, $arg1);
self::DbQuery("delete from pending where id=".$pending['id']);

/*$test = 0;
while ($test==0)
{
    $pending2 =  self::getObjectFromDB( "SELECT* FROM pending WHERE player_id = {$id} order by id desc limit 1");

    if ($pending2 != null)
    {
        $action = $this->callPending($pending2, false);

        if (($action['selectable']==null)&&($action['buttons']==null))
        {
            $this->callPending($pending2, true);
            self::DbQuery("delete from pending where id=".$pending2['id']);
        }

        else
        {
            $test =1;
        }

    }

    else
    {
        $test =1;
    }*/

    $this->gamestate->nextState( 'next');
//}

}

function actValidate3Discard( $arg1, $arg2, $arg3)
{
   
    self::checkAction( 'actSelect' );
    $id = self::getCurrentPlayerId();
    
    $explode1 = explode("_", $arg1);
    $explode2 = explode("_", $arg2);
    $explode3 = explode("_", $arg3);

    $nbrejoueurs = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

    if($explode1[1] == 1)
    {
        letsgotojapan::$instance->tokyo->moveCard( $explode1[2], 'discard' ); 
        letsgotojapan::$instance->notifyAllPlayers('discard','', array(
            'carddiscard' => $arg1,
            'playerid' => $id,
            
            )
            );
    }

    if($explode1[1] == 2)
    {
        letsgotojapan::$instance->kyoto->moveCard( $explode1[2], 'discard' ); 
        letsgotojapan::$instance->notifyAllPlayers('discard','', array(
            'carddiscard' => $arg1,
            'playerid' => $id,
            
            )
            );
    }

    if($explode2[1] == 1)
    {
        letsgotojapan::$instance->tokyo->moveCard( $explode2[2], 'discard' ); 
        letsgotojapan::$instance->notifyAllPlayers('discard','', array(
            'carddiscard' => $arg2,
            'playerid' => $id,
            
            )
            );
    }

    if($explode2[1] == 2)
    {
        letsgotojapan::$instance->kyoto->moveCard( $explode2[2], 'discard' ); 
        letsgotojapan::$instance->notifyAllPlayers('discard','', array(
            'carddiscard' => $arg2,
            'playerid' => $id,
            
            )
            );
    }
    

    if($explode3[1] == 1)
    {
        letsgotojapan::$instance->tokyo->moveCard( $explode3[2], 'discard' ); 
        letsgotojapan::$instance->notifyAllPlayers('discard','', array(
            'carddiscard' => $arg3,
            'playerid' => $id,
            
            )
            );
    }

    if($explode3[1] == 2)
    {
        letsgotojapan::$instance->kyoto->moveCard( $explode3[2], 'discard' ); 
        letsgotojapan::$instance->notifyAllPlayers('discard','', array(
            'carddiscard' => $arg3,
            'playerid' => $id,
            
            )
            );
    }
    
    self::DbQuery( "UPDATE player set recherche = recherche - 1  WHERE player_id = {$id}" );
    letsgotojapan::$instance->MajPannel($id);
    $name = self::getUniqueValueFromDB("SELECT player_name FROM player WHERE player_id = {$id}");
    if ($nbrejoueurs == 1)
    {
    letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses ${log}' ), array(
        'player_name' => $name,
        'log' => letsgotojapan::$instance->getLogsType(2),
        )
        );
    }

    if ($nbrejoueurs >= 2)
    {
        letsgotojapan::$instance->notifyPlayer($id,'message',clienttranslate( 'You use ${log}' ), array(
        'player_name' => $name,
        'log' => letsgotojapan::$instance->getLogsType(2),
        )
        );
    }

    self::DbQuery( "UPDATE player set select1 = '0'  WHERE player_id = {$id}" );
    self::DbQuery( "UPDATE player set select2 = '0'  WHERE player_id = {$id}" );
    self::DbQuery( "UPDATE player set select3 = '0'  WHERE player_id = {$id}" );
    
    
    
    $pending =  self::getObjectFromDB( "SELECT* FROM pending WHERE player_id = {$id} order by id desc limit 1");
    self::DbQuery("delete from pending where id=".$pending['id']);

    $counthandtokyocard = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$id}", true ));
    $counthandkyotocard = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$id}", true ));
    $playerhandcount = $counthandtokyocard + $counthandkyotocard;

    

    if ($nbrejoueurs >= 2)
    {
    if ($playerhandcount == 2)
    {
    letsgotojapan::$instance->addPending($id, "Phase1Step1");
    $this->gamestate->nextState( 'next');
    }

    if ($playerhandcount == 4)
    {
    letsgotojapan::$instance->addPending($id, "Phase2Step1");
    $this->gamestate->nextState( 'next');
    }

    if ($playerhandcount == 3)
    {
    letsgotojapan::$instance->addPending($id, "Phase2Step1");
    $this->gamestate->nextState( 'next');
    }
    }

    if ($nbrejoueurs == 1)
    {
    if ($playerhandcount == 2)
    {
    letsgotojapan::$instance->addPending($id, "SoloPhase1Step1");
    $this->gamestate->nextState( 'next');
    }

    if ($playerhandcount == 4)
    {
    letsgotojapan::$instance->addPending($id, "SoloPhase2Step1");
    $this->gamestate->nextState( 'next');
    }

    if ($playerhandcount == 3)
    {
    letsgotojapan::$instance->addPending($id, "SoloPhase2Step1");
    $this->gamestate->nextState( 'next');
    }
    }
    
        
    
}

function actConfirmPref($arg1, $arg2)
{
    if (letsgotojapan::$instance->tableExists('prefconfirm')) 
    {
        $etat = self::getUniqueValueFromDB("SELECT valeur FROM prefconfirm WHERE player_id={$arg1}");
        if($etat != $arg2)
        {
            self::DbQuery( "UPDATE prefconfirm set valeur = '{$arg2}' WHERE player_id = {$arg1}" );
        }

        
    }
    
}

/*
function repairBiggy()
    {
        $bPlayer1 = false;
        $bPlayer2 = false;
        $players = self::loadPlayersBasicInfos();
        foreach( $players as $player_id=>$player )
        {
           

           if( $player_id == '87143946' ) 
                $bPlayer1  = true;
                if( $player_id == '85247080' ) 
                $bPlayer2  = true;

        }
        if( $bPlayer1 && $bPlayer2 )
        {

            self::dbQuery( "UPDATE token SET token_type='wolf' WHERE ( token_type,token_player_id )=( 'werewolf','84189585' )" );

        }
    }*/





    
///////////////////////////////////////////////////////////////////////////////// 
//     _____                             _        _                                                    _       
//    / ____|                           | |      | |                                                  | |      
//    | |  __  __ _ _ __ ___   ___   ___| |_ __ _| |_ ___    __ _ _ __ __ _ _   _ _ __ ___   ___ _ __ | |_ ___ 
//    | | |_ |/ _` | '_ ` _ \ / _ \ / __| __/ _` | __/ _ \  / _` | '__/ _` | | | | '_ ` _ \ / _ \ '_ \| __/ __|
//    | |__| | (_| | | | | | |  __/ \__ \ || (_| | ||  __/ | (_| | | | (_| | |_| | | | | | |  __/ | | | |_\__ \
//     \_____|\__,_|_| |_| |_|\___| |___/\__\__,_|\__\___|  \__,_|_|  \__, |\__,_|_| |_| |_|\___|_| |_|\__|___/
//                                                                    __/ |                                   
//                                                                   |___/                                    
///////////////////////////////////////////////////////////////////////////////// 

   
function argPlayerTurn()
{
    $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );
    $ret =[];
    
    

    foreach ($listplayers as $player_id)
    {
        

    try {
        
        
        $pending =  self::getObjectFromDB( "SELECT* FROM pending WHERE player_id = {$player_id} order by id desc limit 1");
        if($pending != null)
        {
        $args = $this->callPending($pending, false);

        $ret[$player_id][]= $args;
        
        }
        
        
        
    }
        catch (Exception $e){}


    }
    
    
    return $ret;
}


    
 


///////////////////////////////////////////////////////////////////////////////// 
//      _____                            _        _                    _   _                 
//     / ____|                          | |      | |                  | | (_)                
//    | |  __  __ _ _ __ ___   ___   ___| |_ __ _| |_ ___    __ _  ___| |_ _  ___  _ __  ___ 
//    | | |_ |/ _` | '_ ` _ \ / _ \ / __| __/ _` | __/ _ \  / _` |/ __| __| |/ _ \| '_ \/ __|
//    | |__| | (_| | | | | | |  __/ \__ \ || (_| | ||  __/ | (_| | (__| |_| | (_) | | | \__ \
//     \_____|\__,_|_| |_| |_|\___| |___/\__\__,_|\__\___|  \__,_|\___|\__|_|\___/|_| |_|___/
//                                                                                       
/////////////////////////////////////////////////////////////////////////////////

function st_MultiPlayerActivation() 
{


    $actifmode = self::getUniqueValueFromDB("SELECT actif FROM mode WHERE name='mode'");


    if($actifmode == 1)
    {
        self::DbQuery( "UPDATE mode set actif = 0  WHERE name='mode'" );

        $countplayer = count(self::getObjectListFromDB( "SELECT player_id FROM player", true ));
        $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

        foreach ($listplayers as $player)
        {
            
            $type = self::getUniqueValueFromDB("SELECT passportcard FROM player WHERE player_id = {$player}");
            letsgotojapan::$instance->notifyAllPlayers('placepassortpannel','', array(
                'id' => $player,
                'type' => $type,
                                    
                )
                );


            if($type == 1)
            {
                self::DbQuery( "UPDATE player set train = 3  WHERE player_id = {$player}" );
            }

            if($type == 3)
            {
                
                self::DbQuery( "UPDATE player set angry1 = 2  WHERE player_id = {$player}" );
                letsgotojapan::$instance->Smile(-2,$player);


            }

            if($type == 4)
            {
                self::DbQuery( "UPDATE player set wild = 3  WHERE player_id = {$player}" );
            }

            if($type == 5)
            {
                self::DbQuery( "UPDATE player set recherche = 5  WHERE player_id = {$player}" );
                self::DbQuery( "UPDATE player set happy2 = 1  WHERE player_id = {$player}" );
                letsgotojapan::$instance->Smile(1,$player);


            }

            if($type == 6)
            {
                letsgotojapan::$instance->Gain("r",$player);
                letsgotojapan::$instance->Gain("g",$player);
                letsgotojapan::$instance->Gain("y",$player);
                letsgotojapan::$instance->Gain("p",$player);
                letsgotojapan::$instance->Gain("b",$player);

            }

            if($type == 10)
            {
                self::DbQuery( "UPDATE player set pass10 = 2  WHERE player_id = {$player}" );
            }



            //MAJ PANNEL

            $recherche = self::getUniqueValueFromDB("SELECT recherche FROM player WHERE player_id={$player}");
            $train = self::getUniqueValueFromDB("SELECT train FROM player WHERE player_id={$player}");
            $trainstart = self::getUniqueValueFromDB("SELECT trainstart FROM player WHERE player_id={$player}");
            $wild = self::getUniqueValueFromDB("SELECT wild FROM player WHERE player_id={$player}");
        
            letsgotojapan::$instance->notifyAllPlayers('majpannelall','', array(
                'id' =>  $player,
                'recherche' => $recherche,
                'train' => $train,
                'trainstart' => $trainstart,
                'wild' => $wild,
                
                )
                );
        }

        if($countplayer >1)
        {
                       

            foreach ($listplayers as $player_id)
            {
                                
                $this->addPendingFirst($player_id, "Phase1Step1");
                
                letsgotojapan::$instance->notifyAllPlayers('startpass','', array(
                                       
                    )
                    );
            }
        }

        if($countplayer ==1)
        {
            /*letsgotojapan::$instance->Gain("r",0);
            letsgotojapan::$instance->Gain("g",0);
            letsgotojapan::$instance->Gain("y",0);
            letsgotojapan::$instance->Gain("p",0);
            letsgotojapan::$instance->Gain("b",0);*/


            foreach ($listplayers as $player_id)
            {
                $this->addPendingFirst($player_id, "SoloLevel");

                letsgotojapan::$instance->notifyAllPlayers('startpass','', array(
                                       
                    )
                    );

            }
        }

        if ($countplayer>=2)
        {
            self::DbQuery("DELETE FROM `copybonus`;");
            $copybonus = self::getObjectListFromDB( "SELECT player_id id, smile smile, happy happy, angry angry, recherche recherche, train train, trainstart trainstart, wild wild FROM player");

            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {   
                foreach($copybonus as $bonus)
                {
                    if($player_id == $bonus['id'])
                    {
                    self::DbQuery("INSERT INTO copybonus (player_id, smile, happy, angry, recherche, train, trainstart, wild) VALUES ('{$bonus['id']}', '{$bonus['smile']}', '{$bonus['happy']}', '{$bonus['angry']}', '{$bonus['recherche']}', '{$bonus['train']}', '{$bonus['trainstart']}', '{$bonus['wild']}')");
                    }
                }

                //MAJ SMILE

            $smile = self::getUniqueValueFromDB("SELECT smile FROM copybonus WHERE player_id={$player_id}");
            $happy = self::getUniqueValueFromDB("SELECT happy FROM copybonus WHERE player_id={$player_id}");
            $angry = self::getUniqueValueFromDB("SELECT angry FROM copybonus WHERE player_id={$player_id}");

            letsgotojapan::$instance->notifyAllPlayers('majsmileall','', array(
                'id' =>  $player_id,
                'smile' => $smile,
                'happy' => $happy,
                'angry' => $angry,
                
                
                )
                );


            }

            


        } 

    }

    
    if($actifmode == 0)
    {
    $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
    $newturn = $turn+1;
    $countplayer = count(self::getObjectListFromDB( "SELECT player_id FROM player", true ));

    if ($countplayer>=2)
    {
        if($newturn <= 14)
        {
        // DESTROY CARD

        $destroytokyo = self::getObjectListFromDB( "SELECT card_id id, card_location_arg location_arg FROM copytokyo WHERE card_location != 'deck' and card_location != 'discard' and card_location != 'discardboardhidden' and card_location != 'discardboard' and card_location != 'playerhand'");
        $destroykyoto = self::getObjectListFromDB( "SELECT card_id id, card_location_arg location_arg FROM copykyoto WHERE card_location != 'deck' and card_location != 'discard' and card_location != 'discardboardhidden' and card_location != 'discardboard' and card_location != 'playerhand'");

        letsgotojapan::$instance->notifyAllPlayers('destroytokyo','', array(
            'tableau' => $destroytokyo,
            
            )
            );
            
        
        letsgotojapan::$instance->notifyAllPlayers('destroykyoto','', array(
            'tableau' => $destroykyoto,
            
            )
            );
        
        // END DESTROY CARD



        /// RESET AND SAVE COPY BASES MULTI PLAYER
       
            self::DbQuery("DELETE FROM `copytokyo`;");
            self::DbQuery("DELETE FROM `copykyoto`;");
            self::DbQuery("DELETE FROM `copybonus`;");

            $copydecktokyo = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk FROM tokyo WHERE card_location != 'deck' and card_location != 'discard' and card_location != 'discardboardhidden' and card_location != 'discardboard' and card_location != 'playerhand'");
            $copydeckkyoto = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk FROM kyoto WHERE card_location != 'deck' and card_location != 'discard' and card_location != 'discardboardhidden' and card_location != 'discardboard' and card_location != 'playerhand'");
            $copybonus = self::getObjectListFromDB( "SELECT player_id id, smile smile, happy happy, angry angry, recherche recherche, train train, trainstart trainstart, wild wild FROM player");

            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                if($copydecktokyo != NULL)
                {
                    foreach ($copydecktokyo as $tokyo)
                    {
                        if($player_id == $tokyo['location_arg'])
                        {
                            self::DbQuery("INSERT INTO copytokyo (card_id, card_type, card_type_arg, card_location, card_location_arg, walk, finallocation, finalwalk) VALUES ('{$tokyo['id']}', '{$tokyo['type']}', '{$tokyo['type_arg']}', '{$tokyo['location']}', '{$tokyo['location_arg']}', '{$tokyo['walk']}', '{$tokyo['finallocation']}', '{$tokyo['finalwalk']}')");
                        }
                    }
                }

                if($copydeckkyoto != NULL)
                {
                    foreach ($copydeckkyoto as $kyoto)
                    {
                        if($player_id == $kyoto['location_arg'])
                        {
                            self::DbQuery("INSERT INTO copykyoto (card_id, card_type, card_type_arg, card_location, card_location_arg, walk, finallocation, finalwalk) VALUES ('{$kyoto['id']}', '{$kyoto['type']}', '{$kyoto['type_arg']}', '{$kyoto['location']}', '{$kyoto['location_arg']}', '{$kyoto['walk']}', '{$kyoto['finallocation']}', '{$kyoto['finalwalk']}')");
                        }
                    }
                }

                foreach($copybonus as $bonus)
                {
                    if($player_id == $bonus['id'])
                    {
                    self::DbQuery("INSERT INTO copybonus (player_id, smile, happy, angry, recherche, train, trainstart, wild) VALUES ('{$bonus['id']}', '{$bonus['smile']}', '{$bonus['happy']}', '{$bonus['angry']}', '{$bonus['recherche']}', '{$bonus['train']}', '{$bonus['trainstart']}', '{$bonus['wild']}')");
                    }
                }


                //MAJ PANNEL

                $recherche = self::getUniqueValueFromDB("SELECT recherche FROM player WHERE player_id={$player_id}");
                $train = self::getUniqueValueFromDB("SELECT train FROM player WHERE player_id={$player_id}");
                $trainstart = self::getUniqueValueFromDB("SELECT trainstart FROM player WHERE player_id={$player_id}");
                $wild = self::getUniqueValueFromDB("SELECT wild FROM player WHERE player_id={$player_id}");
            
                letsgotojapan::$instance->notifyAllPlayers('majpannelall','', array(
                    'id' =>  $player_id,
                    'recherche' => $recherche,
                    'train' => $train,
                    'trainstart' => $trainstart,
                    'wild' => $wild,
                    
                    )
                    );

                //MAJ SMILE

                $smile = self::getUniqueValueFromDB("SELECT smile FROM copybonus WHERE player_id={$player_id}");
                $happy = self::getUniqueValueFromDB("SELECT happy FROM copybonus WHERE player_id={$player_id}");
                $angry = self::getUniqueValueFromDB("SELECT angry FROM copybonus WHERE player_id={$player_id}");

                letsgotojapan::$instance->notifyAllPlayers('majsmileall','', array(
                    'id' =>  $player_id,
                    'smile' => $smile,
                    'happy' => $happy,
                    'angry' => $angry,
                    
                    
                    )
                    );


                //// PASSPORT 18

                $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$player_id}");
                if($passportcard == 18)
                {
                    $scorepassport18 = 0;
                    $tokyopass = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );
                    $kyotopass = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );

                    if($tokyopass != null)
                    {
                        foreach ($tokyopass as $tokyotype)
                        {
                            if(($tokyotype == 45)||($tokyotype == 79)||($tokyotype == 1)||($tokyotype == 2))
                            {
                                $scorepassport18 = $scorepassport18 +1;
                            }

                        }

                    }

                    if($kyotopass != null)
                    {
                        foreach ($kyotopass as $kyototype)
                        {

                            if(($kyototype == 69)||($kyototype == 34)||($kyototype == 35)||($kyototype == 22)||($kyototype == 23)||($kyototype == 79)||($kyototype == 70)||($kyototype == 71)||($kyototype == 26)||($kyototype == 27))
                            {
                                $scorepassport18 = $scorepassport18 +1;
                            }
                            
                        }

                        
                    }

                    $newscore = $scorepassport18 * 4;
                    self::DbQuery( "UPDATE player set passportscore = $newscore  WHERE player_id = {$player_id}" );
                    letsgotojapan::$instance->MajScorePassport(18,$player_id);

                }
                

            }


       
        /// END RESET AND SAVE COPY BASES MULTI PLAYER


        


        // DISPLAY CARD

        $displaytokyo = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk FROM copytokyo WHERE card_location != 'deck' and card_location != 'discard' and card_location != 'discardboardhidden' and card_location != 'discardboard' and card_location != 'playerhand'");
        $displaykyoto = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk FROM copykyoto WHERE card_location != 'deck' and card_location != 'discard' and card_location != 'discardboardhidden' and card_location != 'discardboard' and card_location != 'playerhand'");

        letsgotojapan::$instance->notifyAllPlayers('displaytokyo','', array(
            'tableau' => $displaytokyo,
            
            )
            );
            
        
        letsgotojapan::$instance->notifyAllPlayers('displaykyoto','', array(
            'tableau' => $displaykyoto,
            
            )
            );


        // END DISPLAY CARD


        
        }   



        if (($newturn < 5)||($newturn == 11))  
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );

            

            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $this->tokyo->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->kyoto->pickCardForLocation( 'deck', 'playerhand', $player_id);

                $tokyocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$player_id}");
                $kyotocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$player_id}");
                
                
                foreach($tokyocard as $card1)
                {
                    

                letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                    'id' => $card1['id'],
                    'card' => $card1['type'],
                    'ville' => 1,
                    'playerid' => $player_id,
                    'location' => 'playerhand',

                    )
                    );
                    
                }
                

                foreach($kyotocard as $card2)
                {
                    

                letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                    'id' => $card2['id'],
                    'card' => $card2['type'],
                    'ville' => 2,
                    'playerid' => $player_id,
                    'location' => 'playerhand',
                    )
                    );
                    
                }

                //////////////// Compteur discard ///////////////

                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }

                $newtokyocarddiscardcount = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}", true));
                $newkyotocarddiscardcount = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}", true));

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => $newtokyocarddiscardcount,
                    'count2' => $newkyotocarddiscardcount,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "Phase1Step1");
            }
        }

        if (($newturn == 5)||($newturn == 7)||($newturn == 9)) 
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );

            
            
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }


                
                $tokyodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");
                $kyotodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");

                
                if($tokyodiscardboard != null)
                {
                
                    foreach($tokyodiscardboard as $card1)
                    {
                        
                    letsgotojapan::$instance->tokyo->moveCard( $card1['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card1['id'],
                        'card' => $card1['type'],
                        'ville' => 1,
                        'playerid' => $player_id,
                        'location' => 'playerhand',

                        )
                        );
                        
                    }

                }

                if($kyotodiscardboard != null)
                {
                

                    foreach($kyotodiscardboard as $card2)
                    {
                        
                    letsgotojapan::$instance->kyoto->moveCard( $card2['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card2['id'],
                        'card' => $card2['type'],
                        'ville' => 2,
                        'playerid' => $player_id,
                        'location' => 'playerhand',
                        )
                        );
                        
                    }

                }

                //////////////// Compteur discard ///////////////

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => 0,
                    'count2' => 0,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "Phase2Step1");
            }
        }

        if (($newturn == 6)||($newturn == 8))
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );


            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $this->tokyo->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->tokyo->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->kyoto->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->kyoto->pickCardForLocation( 'deck', 'playerhand', $player_id);

                $tokyocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$player_id}");
                $kyotocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$player_id}");
                
                
                foreach($tokyocard as $card1)
                {
                    

                letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                    'id' => $card1['id'],
                    'card' => $card1['type'],
                    'ville' => 1,
                    'playerid' => $player_id,
                    'location' => 'playerhand',

                    )
                    );
                    
                }
                

                foreach($kyotocard as $card2)
                {
                    

                letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                    'id' => $card2['id'],
                    'card' => $card2['type'],
                    'ville' => 2,
                    'playerid' => $player_id,
                    'location' => 'playerhand',
                    )
                    );
                    
                }

                //////////////// Compteur discard ///////////////

                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }

                $newtokyocarddiscardcount = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}", true));
                $newkyotocarddiscardcount = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}", true));

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => $newtokyocarddiscardcount,
                    'count2' => $newkyotocarddiscardcount,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "Phase2Step1");
            }
        }

        if (($newturn == 10)||($newturn == 12))  
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );

            
            
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }


                
                $tokyodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");
                $kyotodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");

                
                if($tokyodiscardboard != null)
                {
                
                    foreach($tokyodiscardboard as $card1)
                    {
                        
                    letsgotojapan::$instance->tokyo->moveCard( $card1['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card1['id'],
                        'card' => $card1['type'],
                        'ville' => 1,
                        'playerid' => $player_id,
                        'location' => 'playerhand',

                        )
                        );
                        
                    }

                }

                if($kyotodiscardboard != null)
                {
                

                    foreach($kyotodiscardboard as $card2)
                    {
                        
                    letsgotojapan::$instance->kyoto->moveCard( $card2['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card2['id'],
                        'card' => $card2['type'],
                        'ville' => 2,
                        'playerid' => $player_id,
                        'location' => 'playerhand',
                        )
                        );
                        
                    }

                }

                //////////////// Compteur discard ///////////////

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => 0,
                    'count2' => 0,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "Phase1Step1");
            }
        }

        if ($newturn == 13) 
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );

            
            
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }


                
                $tokyodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");
                $kyotodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");

                
                if($tokyodiscardboard != null)
                {
                
                    foreach($tokyodiscardboard as $card1)
                    {
                        
                    letsgotojapan::$instance->tokyo->moveCard( $card1['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card1['id'],
                        'card' => $card1['type'],
                        'ville' => 1,
                        'playerid' => $player_id,
                        'location' => 'playerhand',

                        )
                        );
                        
                    }

                }

                if($kyotodiscardboard != null)
                {
                

                    foreach($kyotodiscardboard as $card2)
                    {
                        
                    letsgotojapan::$instance->kyoto->moveCard( $card2['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card2['id'],
                        'card' => $card2['type'],
                        'ville' => 2,
                        'playerid' => $player_id,
                        'location' => 'playerhand',
                        )
                        );
                        
                    }

                }

                //////////////// Compteur discard ///////////////

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => 0,
                    'count2' => 0,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "LastTurn");
            }
        }


        if ($newturn == 14) 
        {
            letsgotojapan::$instance->notifyAllPlayers('masque','', array(
                
                
                )
                );

            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                
                $this->addPending($player_id, "FinalStep1");
            }
            
        }

        if ($newturn == 15) 
        {
            letsgotojapan::$instance->notifyAllPlayers('masque','', array(
                
                
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('scorepad','', array(
            
            
                )
                );

            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                
                $this->addPending($player_id, "FinalStepLundiWalk");
                //$this->addPending($player_id, "Gototrip");
            }
            
        }

        if ($newturn == 16) 
        {
            // tie breaker
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );
            foreach ($listplayers as $player_id)
            {
                $r = self::getUniqueValueFromDB( "SELECT r FROM player WHERE player_id = {$player_id}");
                $g = self::getUniqueValueFromDB( "SELECT g FROM player WHERE player_id = {$player_id}");
                $p = self::getUniqueValueFromDB( "SELECT p FROM player WHERE player_id = {$player_id}");
                $y = self::getUniqueValueFromDB( "SELECT y FROM player WHERE player_id = {$player_id}");
                $b = self::getUniqueValueFromDB( "SELECT b FROM player WHERE player_id = {$player_id}");
                $scoreaux = $r + $g + $p + $y + $b;
                self::DbQuery( "UPDATE player set player_score_aux = {$scoreaux} WHERE player_id = {$player_id}" );

            }
            $this->gamestate->nextState('end');
        }

        if ($newturn == 8) 
        {
        letsgotojapan::$instance->notifyAllPlayers('changesens',clienttranslate( '<b>Round 8: The direction of card passing is reversed</b>' ), array(
            
            
            )
            );
        }

    }




    if ($countplayer==1)
    {
        if($newturn <= 14) //// PASSPORT 18
        {
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {

                

                $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$player_id}");
                if($passportcard == 18)
                {
                    $scorepassport18 = 0;
                    $tokyopass = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );
                    $kyotopass = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );

                    if($tokyopass != null)
                    {
                        foreach ($tokyopass as $tokyotype)
                        {
                            if(($tokyotype == 45)||($tokyotype == 79)||($tokyotype == 1)||($tokyotype == 2))
                            {
                                $scorepassport18 = $scorepassport18 +1;
                            }

                        }

                    }

                    if($kyotopass != null)
                    {
                        foreach ($kyotopass as $kyototype)
                        {

                            if(($kyototype == 69)||($kyototype == 34)||($kyototype == 35)||($kyototype == 22)||($kyototype == 23)||($kyototype == 79)||($kyototype == 70)||($kyototype == 71)||($kyototype == 26)||($kyototype == 27))
                            {
                                $scorepassport18 = $scorepassport18 +1;
                            }
                            
                        }

                        
                    }

                    $newscore = $scorepassport18 * 4;
                    self::DbQuery( "UPDATE player set passportscore = $newscore  WHERE player_id = {$player_id}" );
                    letsgotojapan::$instance->MajScorePassport(18,$player_id);

                }


            }

        }

        if (($newturn < 5)||($newturn == 11))  
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );

            

            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $this->tokyo->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->kyoto->pickCardForLocation( 'deck', 'playerhand', $player_id);

                $tokyocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$player_id}");
                $kyotocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$player_id}");
                
                
                foreach($tokyocard as $card1)
                {
                    

                letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                    'id' => $card1['id'],
                    'card' => $card1['type'],
                    'ville' => 1,
                    'playerid' => $player_id,
                    'location' => 'playerhand',

                    )
                    );
                    
                }
                

                foreach($kyotocard as $card2)
                {
                    

                letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                    'id' => $card2['id'],
                    'card' => $card2['type'],
                    'ville' => 2,
                    'playerid' => $player_id,
                    'location' => 'playerhand',
                    )
                    );
                    
                }

                //////////////// Compteur discard ///////////////

                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }

                $newtokyocarddiscardcount = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}", true));
                $newkyotocarddiscardcount = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}", true));

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => $newtokyocarddiscardcount,
                    'count2' => $newkyotocarddiscardcount,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "SoloPhase1Step1");
            }
        }

        if (($newturn == 5)||($newturn == 7)||($newturn == 9)) 
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );

            
            
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }


                
                $tokyodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");
                $kyotodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");

                
                if($tokyodiscardboard != null)
                {
                
                    foreach($tokyodiscardboard as $card1)
                    {
                        
                    letsgotojapan::$instance->tokyo->moveCard( $card1['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card1['id'],
                        'card' => $card1['type'],
                        'ville' => 1,
                        'playerid' => $player_id,
                        'location' => 'playerhand',

                        )
                        );
                        
                    }

                }

                if($kyotodiscardboard != null)
                {
                

                    foreach($kyotodiscardboard as $card2)
                    {
                        
                    letsgotojapan::$instance->kyoto->moveCard( $card2['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card2['id'],
                        'card' => $card2['type'],
                        'ville' => 2,
                        'playerid' => $player_id,
                        'location' => 'playerhand',
                        )
                        );
                        
                    }

                }

                //////////////// Compteur discard ///////////////

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => 0,
                    'count2' => 0,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "SoloPhase2Step1");
            }
        }

        if (($newturn == 6)||($newturn == 8))
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );

            

            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $this->tokyo->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->tokyo->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->kyoto->pickCardForLocation( 'deck', 'playerhand', $player_id);
                $this->kyoto->pickCardForLocation( 'deck', 'playerhand', $player_id);

                $tokyocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$player_id}");
                $kyotocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$player_id}");
                
                
                foreach($tokyocard as $card1)
                {
                    

                letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                    'id' => $card1['id'],
                    'card' => $card1['type'],
                    'ville' => 1,
                    'playerid' => $player_id,
                    'location' => 'playerhand',

                    )
                    );
                    
                }
                

                foreach($kyotocard as $card2)
                {
                    

                letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                    'id' => $card2['id'],
                    'card' => $card2['type'],
                    'ville' => 2,
                    'playerid' => $player_id,
                    'location' => 'playerhand',
                    )
                    );
                    
                }

                //////////////// Compteur discard ///////////////

                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }

                $newtokyocarddiscardcount = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}", true));
                $newkyotocarddiscardcount = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}", true));

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => $newtokyocarddiscardcount,
                    'count2' => $newkyotocarddiscardcount,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "SoloPhase2Step1");
            }
        }

        if (($newturn == 10)||($newturn == 12))  
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );

           
            
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }


                
                $tokyodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");
                $kyotodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");

                
                if($tokyodiscardboard != null)
                {
                
                    foreach($tokyodiscardboard as $card1)
                    {
                        
                    letsgotojapan::$instance->tokyo->moveCard( $card1['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card1['id'],
                        'card' => $card1['type'],
                        'ville' => 1,
                        'playerid' => $player_id,
                        'location' => 'playerhand',

                        )
                        );
                        
                    }

                }

                if($kyotodiscardboard != null)
                {
                

                    foreach($kyotodiscardboard as $card2)
                    {
                        
                    letsgotojapan::$instance->kyoto->moveCard( $card2['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card2['id'],
                        'card' => $card2['type'],
                        'ville' => 2,
                        'playerid' => $player_id,
                        'location' => 'playerhand',
                        )
                        );
                        
                    }

                }

                //////////////// Compteur discard ///////////////

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => 0,
                    'count2' => 0,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "SoloPhase1Step1");
            }
        }

        if ($newturn == 13) 
        {
            /// changement de turn ////
            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            letsgotojapan::$instance->notifyAllPlayers('turn','', array(
            'turn' =>$newturn,
            )
            );

                        
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='discardboardhidden' AND card_location_arg = {$player_id}", true);
                $tokyocarddiscardcount = count($tokyocarddiscard);
                $kyotocarddiscardcount = count($kyotocarddiscard);

                if ($tokyocarddiscardcount != 0)
                {
                    foreach($tokyocarddiscard as $cardid1)
                    {
                        letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboard', $player_id );
                    }

                }

                if ($kyotocarddiscardcount != 0)
                {
                    foreach($kyotocarddiscard as $cardid2)
                    {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboard', $player_id );
                    }

                }


                
                $tokyodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");
                $kyotodiscardboard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='discardboard' AND card_location_arg = {$player_id}");

                
                if($tokyodiscardboard != null)
                {
                
                    foreach($tokyodiscardboard as $card1)
                    {
                        
                    letsgotojapan::$instance->tokyo->moveCard( $card1['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card1['id'],
                        'card' => $card1['type'],
                        'ville' => 1,
                        'playerid' => $player_id,
                        'location' => 'playerhand',

                        )
                        );
                        
                    }

                }

                if($kyotodiscardboard != null)
                {
                

                    foreach($kyotodiscardboard as $card2)
                    {
                        
                    letsgotojapan::$instance->kyoto->moveCard( $card2['id'], 'playerhand', $player_id );
                    letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                        'id' => $card2['id'],
                        'card' => $card2['type'],
                        'ville' => 2,
                        'playerid' => $player_id,
                        'location' => 'playerhand',
                        )
                        );
                        
                    }

                }

                //////////////// Compteur discard ///////////////

                letsgotojapan::$instance->notifyAllPlayers('majcompteurdiscard','', array(
                    'count1' => 0,
                    'count2' => 0,
                    'playerid' => $player_id,
                    
                    )
                    );
                    
                

                $this->addPending($player_id, "SoloLastTurn");
            }
        }


        if ($newturn == 14) 
        {
            letsgotojapan::$instance->notifyAllPlayers('masquesolo','', array(
                
                
                )
                );

            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                
                $this->addPending($player_id, "FinalStep1");
            }
            
        }

        if ($newturn == 15) 
        {
            letsgotojapan::$instance->notifyAllPlayers('masquesolo','', array(
                
                
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('scorepad','', array(
            
            
                )
                );

            self::DbQuery( "UPDATE tokens set level = level + 1  WHERE name ='turn'" );
            $listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                
                $this->addPending($player_id, "FinalStepLundiWalk");
                //$this->addPending($player_id, "Gototrip");
            }
            
        }

        if ($newturn == 16) 
        {
            
            $this->gamestate->nextState('end');
            
            /*$listplayers = self::getObjectListFromDB( "SELECT player_id id FROM player", true );

            foreach ($listplayers as $player_id)
            {
                
                $this->addPending($player_id, "Vide");
            }*/
        }


    }

}
    




    $this->gamestate->setAllPlayersMultiactive();
    $this->gamestate->nextState( 'next');
    
}



function callPending($pending, $execute, $arg1 = null, $arg2 = null)
{
   
    if(class_exists($pending['function'])){
        $obj = new $pending['function']();
        $obj->player_id = $this->getCurrentPlayerId();
        if($pending['player_id'] != null)
        {
            $obj->player_id = $pending['player_id'];
        }
        $obj->player = new Pending($obj->player_id);
        
        $method = "";
        if($pending['target'] != null)
        {
            $method = $pending['target'];
        }
        if(!$execute)
        {
            $name = "arg".$method;
        }
        else
        {
            $name = $method;
        }
        $ret = $obj->$name($pending['arg'], $pending['arg2'], $arg1, $arg2);
    }
    else
    {
        $obj = $this;
        if($pending['player_id'] != null)
        {
            $obj = new Pending($pending['player_id']);
        }
        
        $fname ="";
        if(!$execute)
        {
            $fname .= "arg";
        }
        $fname .= $pending['function'];
        
        $ret = null;
        if(method_exists($obj, $fname))
        {
            $ret = $obj->$fname($pending['arg'], $pending['arg2'], $arg1, $arg2);
        }
    }
    return $ret;
}


/////////////////////////////////////////////////////////////////////////////////
//    ______               _     _      
//   |___  /              | |   (_)     
//      / / ___  _ __ ___ | |__  _  ___ 
//     / / / _ \| '_ ` _ \| '_ \| |/ _ \
//    / /_| (_) | | | | | | |_) | |  __/
//   /_____\___/|_| |_| |_|_.__/|_|\___|
//                                   
/////////////////////////////////////////////////////////////////////////////////                                   


function zombieTurn( $state, $active_player )
{
    $statename = $state['name'];
    
    if ($state['type'] === "activeplayer") {
        switch ($statename) {
            default:
            $this->gamestate->nextState( "zombiePass" );
            break;
        }

        return;
    }

    if ($state['type'] === "multipleactiveplayer") {
        // Make sure player is in a non blocking status for role turn
        $this->gamestate->setPlayerNonMultiactive( $active_player, '' );
        $this->gamestate->nextState( 'end');
        
        return;
    }

    throw new feException( "Zombie mode not supported at this game state: ".$statename );
}

///////////////////////////////////////////////////////////////////////////////// 
//     _____  ____                                    _      
//    |  __ \|  _ \                                  | |     
//    | |  | | |_) |  _   _ _ __   __ _ _ __ __ _  __| | ___ 
//    | |  | |  _ <  | | | | '_ \ / _` | '__/ _` |/ _` |/ _ \
//    | |__| | |_) | | |_| | |_) | (_| | | | (_| | (_| |  __/
//    |_____/|____/   \__,_| .__/ \__, |_|  \__,_|\__,_|\___|
//                         | |     __/ |                     
//                         |_|    |___/                      
/////////////////////////////////////////////////////////////////////////////////    



function upgradeTableDb( $from_version )
{
    

}    
}
