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
        
        $this->initGameStateLabels( array( 
            //    "my_first_global_variable" => 10,
            //    "my_second_global_variable" => 11,
            //      ...
            //    "my_first_game_variant" => 100,
            //    "my_second_game_variant" => 101,
            //      ...
        ) );  

        self::$instance = $this;

        $this->tokyo = self::getNew( "module.common.deck" );
        $this->tokyo->init( "tokyo" );
        $this->tokyo->autoreshuffle = true;

        $this->kyoto = self::getNew( "module.common.deck" );
        $this->kyoto->init( "kyoto" );
        $this->kyoto->autoreshuffle = true;

        
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

        foreach( $players as $player_id => $player )
        {
            
            $this->tokyo->pickCardForLocation( 'deck', 'playerhand', $player_id);
            $this->kyoto->pickCardForLocation( 'deck', 'playerhand', $player_id);
            

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

        
        foreach( $players as $player_id => $player )
        {
            $this->addPendingFirst($player_id, "Phase1Step1");
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

        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!

        // Get information about players
        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
        $sql = "SELECT player_id id, player_score score FROM player ";
        $result['players'] = self::getCollectionFromDb( $sql );

        $result['listplayers'] = self::getObjectListFromDB( "SELECT player_id id FROM player", true );
        $result['countplayers'][] = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

        $result['tokyo'] = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk, train train FROM tokyo WHERE card_location != 'deck' and card_location != 'discard'");
        $result['kyoto'] = self::getObjectListFromDB( "SELECT card_id id, card_type type, card_type_arg type_arg, card_location location, card_location_arg location_arg, walk walk, finallocation finallocation, finalwalk finalwalk, train train FROM kyoto WHERE card_location != 'deck' and card_location != 'discard'");

        $result['turn'] = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");

        $result['tokenjour'] = self::getObjectListFromDB( "SELECT name name, level level FROM tokens WHERE type = 'general'");

        $listplayers = self::getObjectListFromDB("SELECT player_id id FROM player", true);
        foreach($listplayers as $player)
        {
            $result['smile'][$player] = self::getUniqueValueFromDB("SELECT smile FROM player WHERE player_id={$player}");
            $result['happy'][$player] = self::getUniqueValueFromDB("SELECT happy FROM player WHERE player_id={$player}");
            $result['angry'][$player] = self::getUniqueValueFromDB("SELECT angry FROM player WHERE player_id={$player}");
            $result['color'][$player] = self::getUniqueValueFromDB("SELECT player_color FROM player WHERE player_id={$player}");
            $result['nbrerecherche'][$player] = self::getUniqueValueFromDB("SELECT recherche FROM player WHERE player_id={$player}");
            $result['nbretrain'][$player] = self::getUniqueValueFromDB("SELECT train FROM player WHERE player_id={$player}");
            $result['nbrewild'][$player] = self::getUniqueValueFromDB("SELECT wild FROM player WHERE player_id={$player}");
            $result['compteurcardtokyodiscard'][$player] = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location = 'discardboard' and card_location_arg = {$player}", true));
            $result['compteurcardkyotodiscard'][$player] = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location = 'discardboard' and card_location_arg = {$player}", true));

        }
        

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
    // TODO: compute and return the game progression

    return 0;
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

            
        if(!in_array($arg1,$ret[$id][0]['selectable']) && !in_array($arg1,$ret[$id][0]['selectable2']) && !in_array($arg1,$ret[$id][0]['buttons']))
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
    $count1 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_1%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_1%'", true )));
    $count2 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_2%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_2%'", true )));
    $count3 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_3%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_3%'", true )));
    $count4 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_4%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_4%'", true )));
    $count5 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_5%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_5%'", true )));
    $count6 = count(array_merge(self::getObjectListFromDB( "SELECT card_location FROM tokyo WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_6%'", true ),self::getObjectListFromDB( "SELECT card_location FROM kyoto WHERE card_location_arg = {$id} AND card_location LIKE 'cardposition_6%'", true )));
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

            


            letsgotojapan::$instance->notifyAllPlayers('deployer','', array(
                'jour' =>  $jour,
                'count' => $count,
                'card1' => $card1,
                'card2' => $card2,
                'ville1' => $ville1,
                'ville2' => $ville2,
                'playerid' => $id,
                    
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

                

                letsgotojapan::$instance->notifyAllPlayers('condenseravecmodif','', array(
                    'jour' =>  $jour,
                    'count' => $count,
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


            if (($count>=1)&&($count <= 3)&&($jour==$jouradd))
            {   
                $card1 = null;
                $card2 = null;
                $card3 = null;
                $ville1 =1;
                $ville2 =1;
                $ville3 =1;

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

                        letsgotojapan::$instance->notifyAllPlayers('condenseravecmodif','', array(
                            'jour' =>  $jour,
                            'count' => $count,
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

                    

                        letsgotojapan::$instance->notifyAllPlayers('condenseravecmodif','', array(
                            'jour' =>  $jour,
                            'count' => $count,
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
    if ($gain>0)
    {
        for($i=1; $i<=$gain; $i++)
        {
            self::DbQuery( "UPDATE player set smile = smile + 1  WHERE player_id = {$player}" );
            $newsmile = self::getUniqueValueFromDB("SELECT smile FROM player WHERE player_id={$player}");
            letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                'position' => $newsmile,
                'player' => $player,
                )
                );
            //self::notifyAllPlayers( 'simplePause', '', [ 'time' => 500] );

            if ($newsmile == 3)
            {
                self::DbQuery( "UPDATE player set smile = 0  WHERE player_id = {$player}" );
                $newsmile = self::getUniqueValueFromDB("SELECT smile FROM player WHERE player_id={$player}");
                letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                    'position' => $newsmile,
                    'player' => $player,
                    )
                    );
                //self::notifyAllPlayers( 'simplePause', '', [ 'time' => 500] );
                
                $happy = self::getUniqueValueFromDB("SELECT happy FROM player WHERE player_id={$player}");
                if($happy < 3)
                {
                    self::DbQuery( "UPDATE player set happy = happy+1  WHERE player_id = {$player}" );
                    $newhappy = self::getUniqueValueFromDB("SELECT happy FROM player WHERE player_id={$player}");
                    letsgotojapan::$instance->notifyAllPlayers('happy','', array(
                        'position' => $newhappy,
                        'player' => $player,
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
                )
                );
            //self::notifyAllPlayers( 'simplePause', '', [ 'time' => 500] );

            if ($newsmile == -3)
            {
                self::DbQuery( "UPDATE player set smile = 0  WHERE player_id = {$player}" );
                $newsmile = self::getUniqueValueFromDB("SELECT smile FROM player WHERE player_id={$player}");
                letsgotojapan::$instance->notifyAllPlayers('smile','', array(
                    'position' => $newsmile,
                    'player' => $player,
                    )
                    );
                //self::notifyAllPlayers( 'simplePause', '', [ 'time' => 500] );

                $angry = self::getUniqueValueFromDB("SELECT angry FROM player WHERE player_id={$player}");
                if($angry < 3)
                {
                    self::DbQuery( "UPDATE player set angry = angry+1  WHERE player_id = {$player}" );
                    $newangry = self::getUniqueValueFromDB("SELECT angry FROM player WHERE player_id={$player}");
                    letsgotojapan::$instance->notifyAllPlayers('angry','', array(
                        'position' => $newangry,
                        'player' => $player,
                        )
                        );

                }

            }


        }

    }

}

function MajPannel ($id)
{

    $recherche = self::getUniqueValueFromDB("SELECT recherche FROM player WHERE player_id={$id}");
    $train = self::getUniqueValueFromDB("SELECT train FROM player WHERE player_id={$id}");
    $wild = self::getUniqueValueFromDB("SELECT wild FROM player WHERE player_id={$id}");

    letsgotojapan::$instance->notifyAllPlayers('majpannel','', array(
        'id' =>  $id,
        'recherche' => $recherche,
        'train' => $train,
        'wild' => $wild,
        
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
$this->gamestate->nextState( 'next');

}

function actButton($arg1)
{

self::checkAction( 'actSelect' );  
self::checkArgs($arg1);       
  
$id = self::getCurrentPlayerId();
$pending =  self::getObjectFromDB( "SELECT* FROM pending WHERE player_id = {$id} order by id desc limit 1");
$this->callPending($pending, true, $arg1);
self::DbQuery("delete from pending where id=".$pending['id']);
$this->gamestate->nextState( 'next');

}

function actValidate3Discard( $arg1, $arg2, $arg3)
{
   
    self::checkAction( 'actSelect' );
    $id = self::getCurrentPlayerId();
    
    $explode1 = explode("_", $arg1);
    $explode2 = explode("_", $arg2);
    $explode3 = explode("_", $arg3);

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
    letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses ${log}' ), array(
        'player_name' => $name,
        'log' => letsgotojapan::$instance->getLogsType(2),
        )
        );
    
    
    
    $pending =  self::getObjectFromDB( "SELECT* FROM pending WHERE player_id = {$id} order by id desc limit 1");
    self::DbQuery("delete from pending where id=".$pending['id']);

    $counthandtokyocard = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$id}", true ));
    $counthandkyotocard = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$id}", true ));
    $playerhandcount = $counthandtokyocard + $counthandkyotocard;

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
    $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
    $newturn = $turn+1;

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
