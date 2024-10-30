<?php

/*require('CardTokyo.php');
require('CardKyoto.php');*/

class Pending extends APP_GameClass
{
    public function __construct($player_id)
    {
        $this->player_id = $player_id;
        $p = self::getObjectFromDB("SELECT * FROM player WHERE player_id = {$player_id}");        
        $this->player_no = $p['player_no'];
        $this->player_id = $p['player_id'];
        $this->player_name = $p['player_name'];
        $this->player_score = $p['player_score'];
        $this->player_color = $p['player_color'];

        $this->player_recherche = $p['recherche'];
        $this->player_train = $p['train'];
        $this->player_wild = $p['wild'];

        $counthandtokyocard1 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $counthandkyotocard1 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));

        $this->playerhandcount = $counthandtokyocard1 + $counthandkyotocard1;
    }

    /////////////////////// PHASE 1 //////////////////////////
    
    function argPhase1Step1($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a card to place or');


        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            $ret["selectable"][] = 'card_1_'.$id1;
        }   

        foreach ($kyotocard as $id2)
        {
            $ret["selectable"][] = 'card_2_'.$id2;
        }

        $ret['buttons'][]='walk';

        if ($this->player_recherche >= 1)
        {
            $ret['buttons'][]='recherche';
        }
        

        
        
        return $ret;
    }

    function Phase1Step1($parg1, $parg2, $varg1, $varg2)
    {
        
        
        if($varg1 == "walk")
        {
            letsgotojapan::$instance->addPending($this->player_id, "Walk");
            
        }

        elseif($varg1 == "recherche")
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "Recherche");
        }

        else
        {
            letsgotojapan::$instance->Deployer($this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step2", $varg1);
        }
        
       
      
    }

    function argPhase1Step2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip (or change card)');

        $ret["selected"][] = $parg1;

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
        $jour = 0;

        foreach ($counttrip as $count)
        {
            $jour = $jour+1;
            if($count == 0)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
            }
            if($count == 1)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
            }
            if($count == 2)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_5_'.$this->player_id;
            }
        }


        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            if ('card_1_'.$id1 != $parg1)
            {
                
                $ret["selectableswitch"][]= 'card_1_'.$id1;

            }
        }   

        foreach ($kyotocard as $id2)
        {
            if ('card_2_'.$id2 != $parg1)
            {
                
                $ret["selectableswitch"][]= 'card_2_'.$id2;

            }
            
        }
       
       
        

        $ret['buttons'][]='cancel';
        


        
        return $ret;
    }

    function Phase1Step2($parg1, $parg2, $varg1, $varg2)
    {
        
        if($varg1 == "cancel")
        {
            
            letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
        }

        elseif (($varg1 != "cancel")&&(strpos($varg1, 'cardposition') !== 0))

        {
                        
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step2", $varg1);
        }
        
        else

        {

            if (letsgotojapan::$instance->tableExists('prefconfirm')) 
            {
                $prefconfirm = self::getUniqueValueFromDB("SELECT valeur FROM prefconfirm WHERE player_id={$this->player_id}");
            }
            else
            {
                $prefconfirm = 2;
            }

            if($prefconfirm ==2)
            {


            $explode = explode("_", $parg1);
            $explode2 = explode("_", $varg1);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->tokyocards[$card]['name']);
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->kyotocards[$card]['name']);
            }

            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You place <b>"${name}"</b> on <b>${day}</b>'), array(
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                'mobile' =>  $parg1,
                'parent' => $varg1,
                'player_name' => $this->player_name,
                'color' => $this->player_color,
                'id' => $explode[2],
                'ville' => $explode[1],
                'card' => $card,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
            $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
            $counttokyocard = count($tokyocard);
            $countkyotocard = count($kyotocard);

            if ($counttokyocard != 0)
            {
                $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                if ($turn<=6)
                {
                $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                }
                if ($turn>=7)
                {
                $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                }

                    foreach($tokyocard as $cardid)
                    {

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'discardboardhidden', $nextplayer );
                    letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                        'id' => $cardid,
                        'ville' => 1,
                        'playerid' => $this->player_id,

                        )
                        );
                    }

            }

            if ($countkyotocard != 0)
            {
                $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                if ($turn<=6)
                {
                $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                }
                if ($turn>=7)
                {
                $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                }
                    foreach($kyotocard as $cardid)
                    {
                    letsgotojapan::$instance->kyoto->moveCard( $cardid, 'discardboardhidden', $nextplayer );
                    letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                        'id' => $cardid,
                        'ville' => 2,
                        'playerid' => $this->player_id,

                        )
                        );
                    }

            }

             
            letsgotojapan::$instance->Condenser($this->player_id, $varg1);


            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
            
            $day = $explode2[1];

            if ($counttrip[$day-1] == 3)
            {
                $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                

                $scorecards = array();

                $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                if ($tokyo != null)
                {
                    foreach ($tokyo as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    }

                }

                if ($tokyowalk != null)
                {
                    foreach ($tokyowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }

                if ($kyoto != null)
                {

                    foreach ($kyoto as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    }
                    
                }

                if ($kyotowalk != null)
                {
                    foreach ($kyotowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }


                $result = array_map(function(...$numbers) {
                    return array_sum($numbers);
                }, ...$scorecards);

                
                if (($colorday>=1)&&($colorday<=5))
                {
                    if($result[$colorday-1]==0)
                    {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($result[$colorday-1]==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);
                        
                        letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );
                        
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($result[$colorday-1]>=2)
                    {
                       
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $result[$colorday-1], $day);
                    }

                }

                if ($colorday == 6)
                {
                    $calculhappy = $result[5]+$result[6];

                    if($calculhappy==0)
                    {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($calculhappy==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);

                        letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($calculhappy>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $calculhappy, $day);
                    }
                    
                }

               
            }

            else
            {
            letsgotojapan::$instance->giveExtraTime($this->player_id);
            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
            }

            }

            if($prefconfirm ==1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "Confirm", $parg1, $varg1);
            }
            
            
        }

    }

    function argConfirm($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();
        
        $ret['titleyou'] = clienttranslate('${you} must confirm');
        
        $ret["selected"][] = $parg1;
        $ret["selected"][] = $parg2;

        $ret['buttons'][]='yes';
        $ret['buttons'][]='no';

                
        return $ret;
    }

    function Confirm($parg1, $parg2, $varg1, $varg2)
    {

        if ($varg1 == 'no')
        {
            letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
        }

        if ($varg1 == 'yes')
        {

            $explode = explode("_", $parg1);
            $explode2 = explode("_", $parg2);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->tokyocards[$card]['name']);
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->kyotocards[$card]['name']);
            }

            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You place <b>"${name}"</b> on <b>${day}</b>'), array(
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                'mobile' =>  $parg1,
                'parent' => $parg2,
                'player_name' => $this->player_name,
                'color' => $this->player_color,
                'id' => $explode[2],
                'ville' => $explode[1],
                'card' => $card,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
            $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
            $counttokyocard = count($tokyocard);
            $countkyotocard = count($kyotocard);

            if ($counttokyocard != 0)
            {
                $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                if ($turn<=6)
                {
                $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                }
                if ($turn>=7)
                {
                $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                }

                    foreach($tokyocard as $cardid)
                    {

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'discardboardhidden', $nextplayer );
                    letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                        'id' => $cardid,
                        'ville' => 1,
                        'playerid' => $this->player_id,

                        )
                        );
                    }

            }

            if ($countkyotocard != 0)
            {
                $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                if ($turn<=6)
                {
                $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                }
                if ($turn>=7)
                {
                $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                }
                    foreach($kyotocard as $cardid)
                    {
                    letsgotojapan::$instance->kyoto->moveCard( $cardid, 'discardboardhidden', $nextplayer );
                    letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                        'id' => $cardid,
                        'ville' => 2,
                        'playerid' => $this->player_id,

                        )
                        );
                    }

            }

             
            letsgotojapan::$instance->Condenser($this->player_id, $parg2);


            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
            
            $day = $explode2[1];

            if ($counttrip[$day-1] == 3)
            {
                $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                

                $scorecards = array();

                $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                if ($tokyo != null)
                {
                    foreach ($tokyo as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    }

                }

                if ($tokyowalk != null)
                {
                    foreach ($tokyowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }

                if ($kyoto != null)
                {

                    foreach ($kyoto as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    }
                    
                }

                if ($kyotowalk != null)
                {
                    foreach ($kyotowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }


                $result = array_map(function(...$numbers) {
                    return array_sum($numbers);
                }, ...$scorecards);

                
                if (($colorday>=1)&&($colorday<=5))
                {
                    if($result[$colorday-1]==0)
                    {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($result[$colorday-1]==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);
                        
                        letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );
                        
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($result[$colorday-1]>=2)
                    {
                       
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $result[$colorday-1], $day);
                    }

                }

                if ($colorday == 6)
                {
                    $calculhappy = $result[5]+$result[6];

                    if($calculhappy==0)
                    {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($calculhappy==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);

                        letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($calculhappy>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $calculhappy, $day);
                    }
                    
                }

               
            }

            else
            {
            letsgotojapan::$instance->giveExtraTime($this->player_id);
            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
            }


        }


    }








   



    /////////////////////// BONUS JOURNEE //////////////////////////

    function argBonusChoose($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a bonus of the day');

        $ret["selectable"][] = 'bonusjournee_1_'.$this->player_id;
        $ret["selectable"][] = 'bonusjournee_2_'.$this->player_id;
        
        if($parg1 >= 3)
        {
            $ret["selectable"][] = 'bonusjournee_3_'.$this->player_id;
        }

        
        return $ret;
    }

    function BonusChoose($parg1, $parg2, $varg1, $varg2)
    {
        $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

        if ($varg1 === 'bonusjournee_1_' . $this->player_id) 
        {
            letsgotojapan::$instance->Smile(1,$this->player_id);

            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(1),
                )
                );
            
            if ($playerhandcount2 == 0)
            {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
            }
            else
            {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }

        }

        if ($varg1 === 'bonusjournee_2_' . $this->player_id) 
        {
            letsgotojapan::$instance->addPending($this->player_id, "BonusChoose2", $parg1, $parg2);

        }

        if ($varg1 === 'bonusjournee_3_' . $this->player_id) 
        {
            letsgotojapan::$instance->addPending($this->player_id, "BonusChoose3", $parg1, $parg2);

        }
        

    }

    function argBonusChoose2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a bonus of the day');

        $ret["selectable"][] = 'bonusjournee_2_1_'.$this->player_id;
        $ret["selectable"][] = 'bonusjournee_2_2_'.$this->player_id;

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function BonusChoose2($parg1, $parg2, $varg1, $varg2)
    {
        $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

        if($varg1 == "cancel")
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $parg1, $parg2);
        }
        
        if ($varg1 === 'bonusjournee_2_1_' . $this->player_id) 
        {
            self::DbQuery( "UPDATE player set recherche = recherche + 2  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajPannel($this->player_id);
            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log} ${log}' ), array(
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(2),
                )
                );

                if ($playerhandcount2 == 0)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }
                else
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                }

        }

        if ($varg1 === 'bonusjournee_2_2_' . $this->player_id) 
        {
            self::DbQuery( "UPDATE player set wild = wild + 1  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajPannel($this->player_id);
            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(3),
                )
                );

                if ($playerhandcount2 == 0)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }
                else
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                }

        }
        
        

    }

    function argBonusChoose3($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a bonus of the day');

        $ret["selectable"][] = 'bonusjournee_3_1_'.$this->player_id;
        $ret["selectable"][] = 'bonusjournee_3_2_'.$this->player_id;

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function BonusChoose3($parg1, $parg2, $varg1, $varg2)
    {
        $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

        if($varg1 == "cancel")
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $parg1, $parg2);
        } 

        if ($varg1 === 'bonusjournee_3_1_' . $this->player_id) 
        {
            self::DbQuery( "UPDATE player set train = train + 1  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajPannel($this->player_id);
            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(6),
                )
                );

                if ($playerhandcount2 == 0)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }
                else
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                }


        }

        if ($varg1 === 'bonusjournee_3_2_' . $this->player_id) 
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "ExtraWalk", $parg1, $parg2);

        }


       
        

    }

 /////////////////////// WALK ///////////////////


    function argWalk($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the card to discard permanently');

        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            $ret["selectable2"][] = 'card_1_'.$id1;
        }   

        foreach ($kyotocard as $id2)
        {
            $ret["selectable2"][] = 'card_2_'.$id2;
        }        

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function Walk($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            
            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
        }
        else
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "WalkStep2", $varg1);
        } 

              
        

    }

    function argWalkStep2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the location of the walk:');

        $ret["selected"][] = $parg1;

        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        
        $ret['buttons'][]='cancel';
        return $ret;
    }

    function WalkStep2($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            
            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
        }
        else
        {
            letsgotojapan::$instance->Deployer($this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "WalkStep3", $parg1, $varg1);
        } 

              
        

    }

    function argWalkStep3($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected2"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip');

        $ret["selected2"][] = $parg1;

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
        $jour = 0;

        foreach ($counttrip as $count)
        {
            $jour = $jour+1;
            if($count == 0)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
            }
            if($count == 1)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
            }
            if($count == 2)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_5_'.$this->player_id;
            }
        }
        
        $ret['buttons'][]='cancel';
        return $ret;
    }

    function WalkStep3($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            if($this->playerhandcount == 2)
            {
                letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
            }
            if($this->playerhandcount == 4)
            {
                letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
            if($this->playerhandcount == 3)
            {
                letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
            
        }
        else
        {
            
            $explode = explode("_", $parg1); /* la carte a defausser*/
            $explode2 = explode("_", $varg1); /* l'emplacement dans le trip*/

            if($explode[1] == 1)
            letsgotojapan::$instance->tokyo->moveCard( $explode[2], 'discard' ); 
            letsgotojapan::$instance->notifyAllPlayers('discard','', array(
                    'carddiscard' => $parg1,
                    'playerid' => $this->player_id,
                       
                    )
                    );

            if($explode[1] == 2)
            letsgotojapan::$instance->kyoto->moveCard( $explode[2], 'discard' ); 
            letsgotojapan::$instance->notifyAllPlayers('discard','', array(
                    'carddiscard' => $parg1,
                    'playerid' => $this->player_id,
                        
                    )
                    );

            $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

            if($parg2 == "tokyo") 
            {
                

                
                letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id);
                $newcardid= self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = '" . $explode2[0] . "_" . $explode2[1] . "_" . $explode2[2] . "'");
                self::DbQuery( "UPDATE tokyo set walk = 1  WHERE card_id ={$newcardid}" );
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id ={$newcardid}" );

                letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You place ${log} on <b>${day}</b>'), array(
                    'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                    'log' => letsgotojapan::$instance->getLogsType(4),
    
                    )
                    );

                letsgotojapan::$instance->notifyAllPlayers('addwalk','', array(
                    'parent' => $varg1,
                    'player_name' => $this->player_name,
                    'ville' => 1,
                    'cardid' => $newcardid,
                    'playerid' => $this->player_id,
                    'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                    'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                    'log' => letsgotojapan::$instance->getLogsType(4),
    
                    )
                    );

                    

                    if($playerhandcount2 <= 2)
                    {

                    $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                    $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                    $counttokyocard = count($tokyocard);
                    $countkyotocard = count($kyotocard);

                  
        
                    if ($counttokyocard != 0)
                    {
                        $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                            if ($turn<=6)
                            {
                            $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                            }
                            if ($turn>=7)
                            {
                            $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                            }

                            foreach($tokyocard as $cardid1)
                            {
        
                            letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboardhidden', $nextplayer );
                            letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                                'id' => $cardid1,
                                'ville' => 1,
                                'playerid' => $this->player_id,
        
                                )
                                );
                            }
        
                    }
        
                    if ($countkyotocard != 0)
                    {
                        $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                            if ($turn<=6)
                            {
                            $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                            }
                            if ($turn>=7)
                            {
                            $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                            }

                            foreach($kyotocard as $cardid2)
                            {
                            letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboardhidden', $nextplayer  );
                            letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                                'id' => $cardid2,
                                'ville' => 2,
                                'playerid' => $this->player_id,
        
                                )
                                );
                            }
        
                    }

                
                

                }

                letsgotojapan::$instance->Condenser($this->player_id, $varg1);

                
            } 



            if($parg2 == "kyoto") 
            {
               


                letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id);
                $newcardid= self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = '" . $explode2[0] . "_" . $explode2[1] . "_" . $explode2[2] . "'");
                self::DbQuery( "UPDATE kyoto set walk = 1  WHERE card_id ={$newcardid}" );
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id ={$newcardid}" );
                letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You place ${log} on <b>${day}</b>'), array(
                    'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                    'log' => letsgotojapan::$instance->getLogsType(4),
    
                    )
                    );
                letsgotojapan::$instance->notifyAllPlayers('addwalk','', array(
                    'parent' => $varg1,
                    'player_name' => $this->player_name,
                    'ville' => 2,
                    'cardid' => $newcardid,
                    'playerid' => $this->player_id,
                    'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                    'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                    'log' => letsgotojapan::$instance->getLogsType(4),
    
                    )
                    );

                    

                    if($playerhandcount2 <= 2)
                    {

                    $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                    $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                    $counttokyocard = count($tokyocard);
                    $countkyotocard = count($kyotocard);
        
                    if ($counttokyocard != 0)
                    {
                        $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                            if ($turn<=6)
                            {
                            $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                            }
                            if ($turn>=7)
                            {
                            $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                            }

                            foreach($tokyocard as $cardid1)
                            {
        
                            letsgotojapan::$instance->tokyo->moveCard( $cardid1, 'discardboardhidden', $nextplayer );
                            letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                                'id' => $cardid1,
                                'ville' => 1,
                                'playerid' => $this->player_id,
        
                                )
                                );
                            }
        
                    }
        
                    if ($countkyotocard != 0)
                    {
                        $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                            if ($turn<=6)
                            {
                            $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                            }
                            if ($turn>=7)
                            {
                            $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                            }

                            foreach($kyotocard as $cardid2)
                            {
                            letsgotojapan::$instance->kyoto->moveCard( $cardid2, 'discardboardhidden', $nextplayer );
                            letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                                'id' => $cardid2,
                                'ville' => 2,
                                'playerid' => $this->player_id,
        
                                )
                                );
                            }
        
                    }

                    }

                
                letsgotojapan::$instance->Condenser($this->player_id, $varg1);

                                

            } 

                
                self::DbQuery( "UPDATE player set recherche = recherche + 1  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajPannel($this->player_id);
                letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                    'player_name' => $this->player_name,
                    'log' => letsgotojapan::$instance->getLogsType(2),
                    )
                    );


                $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
                $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
                $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;


                
                $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
                $day = $explode2[1];

                if ($counttrip[$day-1] == 3)
                {
                    $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                    

                    $scorecards = array();

                    $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                    $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                    $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                    $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                    if ($tokyo != null)
                    {
                        foreach ($tokyo as $type)
                        {
                            $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                        }

                    }

                    if ($tokyowalk != null)
                    {
                        foreach ($tokyowalk as $type)
                        {
                            $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                        }

                    }


                    if ($kyoto != null)
                    {

                        foreach ($kyoto as $type)
                        {
                            $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        }
                        
                    }

                    if ($kyotowalk != null)
                    {
                        foreach ($kyotowalk as $type)
                        {
                            $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                        }

                    }

                    $result = array_map(function(...$numbers) {
                        return array_sum($numbers);
                    }, ...$scorecards);

                    
                    if (($colorday>=1)&&($colorday<=5))
                    {
                        if($result[$colorday-1]==0)
                        {
                            if ($playerhandcount2 == 0)
                            {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                            else
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");

                            }
                        }

                        if($result[$colorday-1]==1)
                        {
                            letsgotojapan::$instance->Smile(1,$this->player_id);
                            
                            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                                'player_name' => $this->player_name,
                                'log' => letsgotojapan::$instance->getLogsType(1),
                                )
                                );
                            
                                if ($playerhandcount2 == 0)
                                {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                                }
                                else
                                {
                                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                                    letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
    
                                }
                        }

                        if($result[$colorday-1]>=2)
                        {
                        
                            letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $result[$colorday-1], $day);
                        }

                    }

                    if ($colorday == 6)
                    {
                        $calculhappy = $result[5]+$result[6];

                        if($calculhappy==0)
                        {
                            if ($playerhandcount2 == 0)
                            {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                            else
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");

                            }
                        }

                        if($calculhappy==1)
                        {
                            letsgotojapan::$instance->Smile(1,$this->player_id);

                            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                                'player_name' => $this->player_name,
                                'log' => letsgotojapan::$instance->getLogsType(1),
                                )
                                );

                            if ($playerhandcount2 == 0)
                            {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                            else
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");

                            }
                        }

                        if($calculhappy>=2)
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $calculhappy, $day);
                        }
                        
                    }

                
                }

                else
                {
                    if ($playerhandcount2 == 0)
                    {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }
                    else
                    {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");

                    }
                }


            

        }

              
        

    }

    ///////////////////// EXTRA WALK /////////////////////

function argExtraWalk($parg1, $parg2)
{
    $ret = array();
    $ret["selectable"] = array();
    $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
    $ret["selected"] = array();
    $ret['buttons'] = array();
    $ret['titleyou'] = clienttranslate('${you} must choose the location of the extra walk');


    $ret['buttons'][]='tokyo';
    $ret['buttons'][]='kyoto';
    

    $ret['buttons'][]='cancel';
    return $ret;
}

function ExtraWalk($parg1, $parg2, $varg1, $varg2)
{

    if($varg1 == "cancel")
    {
        
        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", 3, $parg2);
    } 

    if($varg1 == "tokyo")
    {
        letsgotojapan::$instance->DeployerExtraWalk($this->player_id, $parg2);
        
        letsgotojapan::$instance->addPending($this->player_id, "ExtraWalkStep2", 1, $parg2);
    } 

    if($varg1 == "kyoto")
    {
        letsgotojapan::$instance->DeployerExtraWalk($this->player_id, $parg2);
        
        letsgotojapan::$instance->addPending($this->player_id, "ExtraWalkStep2", 2, $parg2);
    } 
   

}

function argExtraWalkStep2($parg1, $parg2)
{
    $ret = array();
    $ret["selectable"] = array();
    $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
    $ret["selected"] = array();
    $ret['buttons'] = array();
    $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip for the extra walk');

    $ret["selectable"][] = 'cardposition_'.$parg2.'_1_'.$this->player_id;
    $ret["selectable"][] = 'cardposition_'.$parg2.'_3_'.$this->player_id;
    $ret["selectable"][] = 'cardposition_'.$parg2.'_5_'.$this->player_id;
    $ret["selectable"][] = 'cardposition_'.$parg2.'_7_'.$this->player_id;

    $ret['buttons'][]='cancel';
    return $ret;
}

function ExtraWalkStep2($parg1, $parg2, $varg1, $varg2)
{
    $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
    $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
    $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

    if($varg1 == "cancel")
    {
        letsgotojapan::$instance->CondenserExtraWalk($this->player_id, $parg2, 0);
        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", 3, $parg2);
    } 

    else
    {
        
        $explode2 = explode("_", $varg1); /* l'emplacement dans le trip*/


        if($parg1 == 1) 
        {
            

            letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id);
            $newcardid= self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = '" . $explode2[0] . "_" . $explode2[1] . "_" . $explode2[2] . "'");
            self::DbQuery( "UPDATE tokyo set walk = 1  WHERE card_id ={$newcardid}" );
            self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id ={$newcardid}" );
            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You place an Extra ${log} on <b>${day}</b>'), array(
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'log' => letsgotojapan::$instance->getLogsType(4),

                )
                );

            letsgotojapan::$instance->notifyAllPlayers('addwalk','', array(
                'parent' => $varg1,
                'player_name' => $this->player_name,
                'ville' => 1,
                'cardid' => $newcardid,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'log' => letsgotojapan::$instance->getLogsType(4),

                )
                );


        letsgotojapan::$instance->CondenserExtraWalk($this->player_id, $parg2, $varg1);
        }

        if($parg1 == 2) 
        {

            letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id);
            $newcardid= self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = '" . $explode2[0] . "_" . $explode2[1] . "_" . $explode2[2] . "'");
            self::DbQuery( "UPDATE kyoto set walk = 1  WHERE card_id ={$newcardid}" );
            self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id ={$newcardid}" );
            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You place an Extra ${log} on <b>${day}</b>'), array(
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'log' => letsgotojapan::$instance->getLogsType(4),

                )
                );
            letsgotojapan::$instance->notifyAllPlayers('addwalk','', array(
                'parent' => $varg1,
                'player_name' => $this->player_name,
                'ville' => 2,
                'cardid' => $newcardid,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'log' => letsgotojapan::$instance->getLogsType(4),

                )
                );

            
        letsgotojapan::$instance->CondenserExtraWalk($this->player_id, $parg2, $varg1);
        }

        if ($playerhandcount2 == 0)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }
                else
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                }




    } 

    
   

}





    /////////////////////// RECHERCHE ///////////////////




    function argRecherche($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose your 1st card to draw:');


        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function Recherche($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
        
        } 

        if($varg1 == "tokyo")
        {
            letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);

            
            letsgotojapan::$instance->addPending($this->player_id, "RechercheStep2");
        } 

        if($varg1 == "kyoto")
        {
            letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "RechercheStep2");
        } 


              
        

    }

    function argRechercheStep2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose your 2nd card to draw:');


        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function RechercheStep2($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}", true );
            $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}", true );
            $counttokyocarddiscard = count($tokyocarddiscard);
            $countkyotocarddiscard = count($kyotocarddiscard);

            if ($counttokyocarddiscard != 0)
                {
                    foreach($tokyocarddiscard as $cardid)
                    {

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'discard');
                    }
                        
                }

            if ($countkyotocarddiscard != 0)
                {
                    foreach($kyotocarddiscard as $cardid)
                    {

                    letsgotojapan::$instance->kyoto->moveCard( $cardid, 'discard');
                    }
                        
                }


            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
        } 

        if($varg1 == "tokyo")
        {
            letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "RechercheStep3");
        } 

        if($varg1 == "kyoto")
        {
            letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "RechercheStep3");
        } 


              
        

    }

    function argRechercheStep3($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose your 3rd card to draw:');


        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function RechercheStep3($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}", true );
            $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}", true );
            $counttokyocarddiscard = count($tokyocarddiscard);
            $countkyotocarddiscard = count($kyotocarddiscard);

            if ($counttokyocarddiscard != 0)
                {
                    foreach($tokyocarddiscard as $cardid)
                    {

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'discard');
                    }
                        
                }

            if ($countkyotocarddiscard != 0)
                {
                    foreach($kyotocarddiscard as $cardid)
                    {

                    letsgotojapan::$instance->kyoto->moveCard( $cardid, 'discard');
                    }
                        
                }


            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
            }
        } 

        if($varg1 == "tokyo")
        {
            letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);

            $tokyonewcard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}");
            $kyotonewcard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}");
            $counttokyonewcard = count($tokyonewcard);
            $countkyotonewcard = count($kyotonewcard);

            
            if ($counttokyonewcard != 0)
                {
                    foreach($tokyonewcard as $card)
                    {
                        letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                            'id' => $card['id'],
                            'card' => $card['type'],
                            'ville' => 1,
                            'playerid' => $this->player_id,
                            'location' => 'playerhand',
            
                            )
                            );
                            
                        self::DbQuery( "UPDATE tokyo set card_location = 'playerhand'  WHERE card_id = {$card['id']}" );
                    }
                        
                }

            if ($countkyotonewcard != 0)
                {
                    foreach($kyotonewcard as $card)
                    {
                        letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                            'id' => $card['id'],
                            'card' => $card['type'],
                            'ville' => 2,
                            'playerid' => $this->player_id,
                            'location' => 'playerhand',
            
                            )
                            );

                        self::DbQuery( "UPDATE kyoto set card_location = 'playerhand'  WHERE card_id = {$card['id']}" );

                    
                    }
                        
                }




            letsgotojapan::$instance->addPending($this->player_id, "RechercheStep4");
        } 

        if($varg1 == "kyoto")
        {
            letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);

            $tokyonewcard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}");
            $kyotonewcard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}");
            $counttokyonewcard = count($tokyonewcard);
            $countkyotonewcard = count($kyotonewcard);

            
            if ($counttokyonewcard != 0)
                {
                    foreach($tokyonewcard as $card)
                    {
                        letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                            'id' => $card['id'],
                            'card' => $card['type'],
                            'ville' => 1,
                            'playerid' => $this->player_id,
                            'location' => 'playerhand',
            
                            )
                            );
                            
                        self::DbQuery( "UPDATE tokyo set card_location = 'playerhand'  WHERE card_id = {$card['id']}" );
                    }
                        
                }

            if ($countkyotonewcard != 0)
                {
                    foreach($kyotonewcard as $card)
                    {
                        letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                            'id' => $card['id'],
                            'card' => $card['type'],
                            'ville' => 2,
                            'playerid' => $this->player_id,
                            'location' => 'playerhand',
            
                            )
                            );

                        self::DbQuery( "UPDATE kyoto set card_location = 'playerhand'  WHERE card_id = {$card['id']}" );

                    
                    }
                        
                }

            letsgotojapan::$instance->addPending($this->player_id, "RechercheStep4");
        } 

    }


    function argRechercheStep4($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the 3 cards to discard');

        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        $select1 = self::getUniqueValueFromDB( "SELECT select1 FROM player WHERE player_id = {$this->player_id}");
        $select2 = self::getUniqueValueFromDB( "SELECT select2 FROM player WHERE player_id = {$this->player_id}");
        $select3 = self::getUniqueValueFromDB( "SELECT select3 FROM player WHERE player_id = {$this->player_id}");
        $selected= [$select1, $select2, $select3];

        $count =0; 

        foreach ($selected as $s)
        {
            if($s != '0')
            {
                $ret["selectable2"][] = $s;
                $count++;
            }


        }

        if($count < 3)
        {
            foreach ($tokyocard as $id1)
            {
                if (!in_array('card_1_'.$id1, $selected))
                {
                $ret["selectableswitch"][] = 'card_1_'.$id1;
                }
            }   

        foreach ($kyotocard as $id2)
            {
                if (!in_array('card_2_'.$id2, $selected))
                {
                $ret["selectableswitch"][] = 'card_2_'.$id2;
                }
            }



        }

        

        $ret['buttons'][]='validate3discard'; 
     

        return $ret;
    }

    function RechercheStep4($parg1, $parg2, $varg1, $varg2)
    {
        
        $select1 = self::getUniqueValueFromDB( "SELECT select1 FROM player WHERE player_id = {$this->player_id}");
        $select2 = self::getUniqueValueFromDB( "SELECT select2 FROM player WHERE player_id = {$this->player_id}");
        $select3 = self::getUniqueValueFromDB( "SELECT select3 FROM player WHERE player_id = {$this->player_id}");
        $selected= [$select1, $select2, $select3];

        if (in_array($varg1, $selected))
        {
            $index = array_search($varg1, $selected);
            $index++;
            self::DbQuery( "UPDATE player set `select{$index}` = '0'  WHERE player_id = {$this->player_id}" );
        }

        else
        {
            
            $index = array_search('0', $selected);
            $index++;
            
            self::DbQuery( "UPDATE player set `select{$index}` = '{$varg1}'  WHERE player_id = {$this->player_id}" );
        }

        letsgotojapan::$instance->addPending($this->player_id, "RechercheStep4");
    }




     /////////////////////// PHASE 2 //////////////////////////
              
        

    function argPhase2Step1($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a card to place or');


        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            $ret["selectable"][] = 'card_1_'.$id1;
        }   

        foreach ($kyotocard as $id2)
        {
            $ret["selectable"][] = 'card_2_'.$id2;
        }

        $ret['buttons'][]='walk';

        if ($this->player_recherche >= 1)
        {
            $ret['buttons'][]='recherche';
        }
        

        
        
        return $ret;
    }

    function Phase2Step1($parg1, $parg2, $varg1, $varg2)
    {
                
        if($varg1 == "walk")
        {
            letsgotojapan::$instance->addPending($this->player_id, "Walk");
            
        }

        elseif($varg1 == "recherche")
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "Recherche");
        }

        else
        {
            letsgotojapan::$instance->Deployer($this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step2", $varg1);
        }
        
       
      
    }

    function argPhase2Step2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip (or change card)');

        $ret["selected"][] = $parg1;

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
        $jour = 0;

        foreach ($counttrip as $count)
        {
            $jour = $jour+1;
            if($count == 0)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
            }
            if($count == 1)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
            }
            if($count == 2)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_5_'.$this->player_id;
            }
        }
        
       
        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            if ('card_1_'.$id1 != $parg1)
            {
                
                $ret["selectableswitch"][]= 'card_1_'.$id1;

            }
        }   

        foreach ($kyotocard as $id2)
        {
            if ('card_2_'.$id2 != $parg1)
            {
                
                $ret["selectableswitch"][]= 'card_2_'.$id2;

            }
            
        }
        

        $ret['buttons'][]='cancel';
        


        
        return $ret;
    }

    function Phase2Step2($parg1, $parg2, $varg1, $varg2)
    {
        
        if($varg1 == "cancel")
        {
            
            letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
        }

        elseif (($varg1 != "cancel")&&(strpos($varg1, 'cardposition') !== 0))

        {
                        
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step2", $varg1);
        }
        
        else

        {
            if (letsgotojapan::$instance->tableExists('prefconfirm')) 
            {
                $prefconfirm = self::getUniqueValueFromDB("SELECT valeur FROM prefconfirm WHERE player_id={$this->player_id}");
            }
            else
            {
                $prefconfirm = 2;
            }

            if($prefconfirm ==2)
            {

            $explode = explode("_", $parg1);
            $explode2 = explode("_", $varg1);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->tokyocards[$card]['name']);
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->kyotocards[$card]['name']);
            }

            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You place <b>"${name}"</b> on <b>${day}</b>'), array(
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                'mobile' =>  $parg1,
                'parent' => $varg1,
                'player_name' => $this->player_name,
                'color' => $this->player_color,
                'id' => $explode[2],
                'ville' => $explode[1],
                'card' => $card,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

                if($playerhandcount2 == 2)
                {
            
                $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                $counttokyocard = count($tokyocard);
                $countkyotocard = count($kyotocard);

                if ($counttokyocard != 0)
                {
                    $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                        if ($turn<=6)
                        {
                        $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                        }
                        if ($turn>=7)
                        {
                        $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                        }

                        foreach($tokyocard as $cardid)
                        {

                        letsgotojapan::$instance->tokyo->moveCard( $cardid, 'discardboardhidden', $nextplayer );
                        letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                            'id' => $cardid,
                            'ville' => 1,
                            'playerid' => $this->player_id,

                            )
                            );
                        }

                }

                if ($countkyotocard != 0)
                {
                    $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                        if ($turn<=6)
                        {
                        $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                        }
                        if ($turn>=7)
                        {
                        $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                        }

                        foreach($kyotocard as $cardid)
                        {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid, 'discardboardhidden', $nextplayer );
                        letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                            'id' => $cardid,
                            'ville' => 2,
                            'playerid' => $this->player_id,

                            )
                            );
                        }

                }
                
                }

            


            letsgotojapan::$instance->Condenser($this->player_id, $varg1);
            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
            
            $day = $explode2[1];

            

            

            if ($counttrip[$day-1] == 3)
            {
                $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                
                
                $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                if ($tokyo != null)
                {
                    foreach ($tokyo as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    }

                }

                if ($tokyowalk != null)
                {
                    foreach ($tokyowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }

                if ($kyoto != null)
                {

                    foreach ($kyoto as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    }
                    
                }

                if ($kyotowalk != null)
                {
                    foreach ($kyotowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }


                $result = array_map(function(...$numbers) {
                    return array_sum($numbers);
                }, ...$scorecards);

                
                if (($colorday>=1)&&($colorday<=5))
                {
                    if($result[$colorday-1]==0)
                    {
                        if($playerhandcount2 != 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                        }
                        if($playerhandcount2 == 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                    }

                    if($result[$colorday-1]==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);
                        
                        letsgotojapan::$instance->notifyPlayer($this->player_id,'message',clienttranslate( 'You gain ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );
                        
                            if($playerhandcount2 != 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                            }
                            if($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                    }

                    if($result[$colorday-1]>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $result[$colorday-1], $day);
                    }

                }

                if ($colorday == 6)
                {
                    $calculhappy = $result[5]+$result[6];

                    if($calculhappy==0)
                    {
                        if($playerhandcount2 != 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                        }
                        if($playerhandcount2 == 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                    }

                    if($calculhappy==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);

                        letsgotojapan::$instance->notifyPlayer($this->player_id,'message',clienttranslate( 'You gain ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                            if($playerhandcount2 != 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                            }
                            if($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                    }

                    if($calculhappy>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $calculhappy, $day);
                    }
                    
                }

               
            }

            else
            {
                if($playerhandcount2 != 2)
                    {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                    }
                if($playerhandcount2 == 2)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }


            }
        }

        if($prefconfirm ==1)
        {
            letsgotojapan::$instance->addPending($this->player_id, "Confirm2", $parg1, $varg1);
        }
        
            
        }

    }

    function argConfirm2($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();
        
        $ret['titleyou'] = clienttranslate('${you} must confirm');
        
        $ret["selected"][] = $parg1;
        $ret["selected"][] = $parg2;

        $ret['buttons'][]='yes';
        $ret['buttons'][]='no';

                
        return $ret;
    }

    function Confirm2($parg1, $parg2, $varg1, $varg2)
    {

        if ($varg1 == 'no')
        {
            letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
        }

        if ($varg1 == 'yes')
        {

            $explode = explode("_", $parg1);
            $explode2 = explode("_", $parg2);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->tokyocards[$card]['name']);
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->kyotocards[$card]['name']);
            }

            letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You place <b>"${name}"</b> on <b>${day}</b>'), array(
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                'mobile' =>  $parg1,
                'parent' => $parg2,
                'player_name' => $this->player_name,
                'color' => $this->player_color,
                'id' => $explode[2],
                'ville' => $explode[1],
                'card' => $card,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

                if($playerhandcount2 == 2)
                {
            
                $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                $counttokyocard = count($tokyocard);
                $countkyotocard = count($kyotocard);

                if ($counttokyocard != 0)
                {
                    $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                        if ($turn<=6)
                        {
                        $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                        }
                        if ($turn>=7)
                        {
                        $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                        }

                        foreach($tokyocard as $cardid)
                        {

                        letsgotojapan::$instance->tokyo->moveCard( $cardid, 'discardboardhidden', $nextplayer );
                        letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                            'id' => $cardid,
                            'ville' => 1,
                            'playerid' => $this->player_id,

                            )
                            );
                        }

                }

                if ($countkyotocard != 0)
                {
                    $turn = self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name = 'turn'");
                        if ($turn<=6)
                        {
                        $nextplayer = letsgotojapan::$instance->getPlayerAfter( $this->player_id );
                        }
                        if ($turn>=7)
                        {
                        $nextplayer = letsgotojapan::$instance->getPlayerBefore( $this->player_id );
                        }

                        foreach($kyotocard as $cardid)
                        {
                        letsgotojapan::$instance->kyoto->moveCard( $cardid, 'discardboardhidden', $nextplayer );
                        letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                            'id' => $cardid,
                            'ville' => 2,
                            'playerid' => $this->player_id,

                            )
                            );
                        }

                }
                
                }

            


            letsgotojapan::$instance->Condenser($this->player_id, $parg2);
            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
            
            $day = $explode2[1];

            

            

            if ($counttrip[$day-1] == 3)
            {
                $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                
                
                $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                if ($tokyo != null)
                {
                    foreach ($tokyo as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    }

                }

                if ($tokyowalk != null)
                {
                    foreach ($tokyowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }

                if ($kyoto != null)
                {

                    foreach ($kyoto as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    }
                    
                }

                if ($kyotowalk != null)
                {
                    foreach ($kyotowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }


                $result = array_map(function(...$numbers) {
                    return array_sum($numbers);
                }, ...$scorecards);

                
                if (($colorday>=1)&&($colorday<=5))
                {
                    if($result[$colorday-1]==0)
                    {
                        if($playerhandcount2 != 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                        }
                        if($playerhandcount2 == 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                    }

                    if($result[$colorday-1]==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);
                        
                        letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );
                        
                            if($playerhandcount2 != 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                            }
                            if($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                    }

                    if($result[$colorday-1]>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $result[$colorday-1], $day);
                    }

                }

                if ($colorday == 6)
                {
                    $calculhappy = $result[5]+$result[6];

                    if($calculhappy==0)
                    {
                        if($playerhandcount2 != 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                        }
                        if($playerhandcount2 == 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                    }

                    if($calculhappy==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);

                        letsgotojapan::$instance->notifyPlayer($this->player_id, 'message',clienttranslate( 'You gain ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                            if($playerhandcount2 != 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                            }
                            if($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                    }

                    if($calculhappy>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $calculhappy, $day);
                    }
                    
                }

               
            }

            else
            {
                if($playerhandcount2 != 2)
                    {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");
                    }
                if($playerhandcount2 == 2)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }


            } 


        }


    }



    function argLastTurn($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the card to draw:');

        
        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        
        
        return $ret;
    }

    function LastTurn($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "tokyo")
        {
            
            $newcard = letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'playerhand', $this->player_id);

            letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                'id' =>$newcard['id'],
                'card' => $newcard['type'],
                'ville' => 1,
                'playerid' => $this->player_id,
                'location' => 'playerhand',

                )
                );
                 
            
  
            
            
            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
            
        }
        if($varg1 == "kyoto")
        {
            
            $newcard = letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'playerhand', $this->player_id);

            letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                'id' =>$newcard['id'],
                'card' => $newcard['type'],
                'ville' => 2,
                'playerid' => $this->player_id,
                'location' => 'playerhand',

                )
                );
                 
            


            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step1");
            
        }
        

              
        

    }


/////////////////////// FINAL PHASE ///////////////////


function argFinalStep1($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        

        
        $found = 0;
        
            for ($day=1; $day <=6 && $found == 0; $day++)

            {
                for ($position= 1; $position <=4; $position++)
                {
                    $tokyocardjaune = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=0 AND finallocation =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardjaune!=null)
                    {
                        $ret["selected3"][] = "card_1_".$tokyocardjaune;
                        $found = 1;
                        break;
                    }

                    else
                    {
                        $kyotocardjaune = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=0 AND finallocation =0 AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardjaune!=null)
                        {
                            $ret["selected3"][] = "card_2_".$kyotocardjaune;
                            $found = 1;
                            break;
                        }

                    }

                }
            }




        if ($ret["selected3"] != null)
        {

        $ret['titleyou'] = clienttranslate('${you} must choose the location for this generic activity');

        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        }

        else{

            $ret['titleyou'] = clienttranslate('${you} do not have a generic activity');
            $ret['buttons'][]='continue';
        }

        
        return $ret;
    }

    function FinalStep1($parg1, $parg2, $varg1, $varg2)
    {
        $found = 0;
        $result = array();
        
            for ($day=1; $day <=6 && $found == 0; $day++)

            {
                for ($position= 1; $position <=4; $position++)
                {
                    $tokyocardjaune = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=0 AND finallocation =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardjaune!=null)
                    {
                        $result[] = "card_1_".$tokyocardjaune;
                        $found = 1;
                        break;
                    }

                    else
                    {
                        $kyotocardjaune = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=0 AND finallocation =0 AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardjaune!=null)
                        {
                            $result[] = "card_2_".$kyotocardjaune;
                            $found = 1;
                            break;
                        }

                    }

                }
            }


        if($varg1 == "continue")
        {
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the <b>generic activities</b>' ), array(
                'player_name' => $this->player_name,
                
                )
                );
            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStep3");
            
        }

        if($varg1 == "tokyo")
        {
            $explode = explode('_',$result[0]);
            if($explode[1] == 1)
            {
            self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id = {$explode[2]}" );
            }

            if($explode[1] == 2)
            {
            self::DbQuery( "UPDATE kyoto set finallocation = 1  WHERE card_id = {$explode[2]}" );
            }

            letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                
                'card' => $result[0],
                'ville' => 1,
                )
                );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStep1");
            
            
            
            
        }
        if($varg1 == "kyoto")
        {
            $explode = explode('_',$result[0]);
            if($explode[1] == 1)
            {
            self::DbQuery( "UPDATE tokyo set finallocation = 2 WHERE card_id = {$explode[2]}" );
            }

            if($explode[1] == 2)
            {
            self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id = {$explode[2]}" );
            }

            letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                
                'card' => $result[0],
                'ville' => 2,
                )
                );
            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStep1");
            
            
        }

              

              
        

    }

    /*function argFinalStep2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        

        
        $found = 0;
        
            for ($day=1; $day <=6 && $found == 0; $day++)

            {
                for ($position= 1; $position <=4; $position++)
                {
                    $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardwalk!=null)
                    {
                        $ret["selected3"][] = "card_1_".$tokyocardwalk;
                        $found = 1;
                        break;
                    }

                    else
                    {
                        $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardwalk!=null)
                        {
                            $ret["selected3"][] = "card_2_".$kyotocardwalk;
                            $found = 1;
                            break;
                        }

                    }

                }
            }




        if ($ret["selected3"] != null)
        {

            $ret['titleyou'] = clienttranslate('${you} must choose a side of the card for this walk <br>');

            $explode = explode('_',$ret["selected3"][0]);
            
            
            if ($explode[1]==1)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_1_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardtokyoverso';
            }

            if ($explode[1]==2)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_2_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardkyotoverso';
            }

            
            
        }

        else{

            $ret['titleyou'] = clienttranslate('${you} do not have a walk');
            $ret['buttons'][]='continue';
        }

        
        return $ret;
    }

    function FinalStep2($parg1, $parg2, $varg1, $varg2)
    {
        $found = 0;
        $result = array();
        
        for ($day=1; $day <=6 && $found == 0; $day++)

        {
            for ($position= 1; $position <=4; $position++)
            {
                $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                if ($tokyocardwalk!=null)
                {
                    $result[] = "card_1_".$tokyocardwalk;
                    $found = 1;
                    break;
                }

                else
                {
                    $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($kyotocardwalk!=null)
                    {
                        $result[] = "card_2_".$kyotocardwalk;
                        $found = 1;
                        break;
                    }

                }

            }
        }


        if($varg1 == "continue")
        {
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the <b>walks</b>' ), array(
                'player_name' => $this->player_name,
                
                )
                );
            letsgotojapan::$instance->addPending($this->player_id, "FinalStep3");
            
        }

        elseif($varg1 == "cardtokyoverso")
        {
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStep2");
            
            
            
            
        }
        elseif($varg1 == "cardkyotoverso")
        {
            
            
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStep2");
            
            
        }

        else
        {
            $explode = explode('_',$result[0]);

            if ($explode[1]==1)
            {

                self::DbQuery( "UPDATE tokyo set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM tokyo WHERE card_id ={$explode[2]}");

                
                letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                    'cardid' => $result[0],
                    'id' => $explode[2],
                    'ville' => 1,
                    'type' => $type,
                    'location' => $location,
                    'playerid' => $this->player_id,

                    )
                    );

                letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
            
                    'card' => $result[0],
                    
                    )
                    );

               

                

            }

            if ($explode[1]==2)
            {

                self::DbQuery( "UPDATE kyoto set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM kyoto WHERE card_id ={$explode[2]}");

                
                    letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                        'cardid' => $result[0],
                        'id' => $explode[2],
                        'ville' => 2,
                        'type' => $type,
                        'location' => $location,
                        'playerid' => $this->player_id,

                        )
                        );
                    
                    letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
        
                        'card' => $result[0],
                        
                        )
                        );





            }

            letsgotojapan::$instance->addPending($this->player_id, "FinalStep2");

        }

              

              
        

    }*/


    function argFinalStep3($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected2"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        

        
        
        $card = array();
        
            for ($day=1; $day <=6; $day++)

            {
                for ($position= 1; $position <=4; $position++)
                {
                    $tokyocardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                    $villefinal = self::getUniqueValueFromDB( "SELECT finallocation finallocation FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardid!=null)
                    {
                        $card[]= [$villefinal,$tokyocardid,1,$train];
                        
                    }

                    else
                    {
                        $kyotocardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                        $villefinal = self::getUniqueValueFromDB( "SELECT finallocation finallocation FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                        $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardid!=null)
                        {
                            $card[]= [$villefinal,$kyotocardid,2,$train];
                        }

                    }

                }
            }

          

        $nombre = count ($card);

                
        for($index=0; $index<$nombre-1 ;$index++)
        {
            if(($card[$index][0] != $card[$index+1][0])&&($card[$index+1][3]==0))
            {
                $ret["selected2"][] = 'card_'.$card[$index+1][2].'_'.$card[$index+1][1];
            }
            

        }
        
        



        if ($ret["selected2"] != null)
        {
            

            $ret['titleyou'] = clienttranslate('${you} must choose a train to get to this location');
            
            $ret["selected3"][]=$ret["selected2"][0];

            $trainstart = self::getUniqueValueFromDB( "SELECT trainstart FROM player WHERE player_id = {$this->player_id}");
            $train = self::getUniqueValueFromDB( "SELECT train FROM player WHERE player_id = {$this->player_id}");

            if($trainstart >=1)
            {
                $ret['buttons'][]='trainstart';
            }

            if($train >=1)
            {
                $ret['buttons'][]='train';
            }

            $ret['buttons'][]='normaltrain';
            
        }

        else{

            $ret['titleyou'] = clienttranslate('${you} do not need to place trains anymore');
            $ret['buttons'][]='continue';
        }

        
        return $ret;
    }

    function FinalStep3($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "continue")
        {
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the <b>trains</b>' ), array(
                'player_name' => $this->player_name,
                
                )
                );


            $countplayer= count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

            /////////////////////////////// PLACE TRAIN AGENT LVL 3 ///////////////////
            if($countplayer == 1)
            {
            $sololvl= self::getUniqueValueFromDB( "SELECT sololvl FROM agent WHERE name='agent'");
            if($sololvl == 3)
            {

            $carda = array();
            $resulta = array();
        
            for ($day=1; $day <=6; $day++)

            {
                for ($position= 1; $position <=3; $position++)
                {
                    $tokyocardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$position}'");
                    $ville = self::getUniqueValueFromDB( "SELECT finallocation finallocation FROM tokyo WHERE card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$position}'");
                    
                    if ($tokyocardid!=null)
                    {
                        $carda[]= [$ville,$tokyocardid];
                        
                    }

                    else
                    {
                        $kyotocardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$position}'");
                        $ville = self::getUniqueValueFromDB( "SELECT finallocation finallocation FROM kyoto WHERE card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$position}'");
                        
                        if ($kyotocardid!=null)
                        {
                            $carda[]= [$ville,$kyotocardid];
                        }

                    }

                }
            }

           

            for($index=0; $index<17 ;$index++)
            {
                if($carda[$index][0] != $carda[$index+1][0])
                {
                    $resulta[] = 'card_'.$carda[$index+1][0].'_'.$carda[$index+1][1];
                }
                

            }

            $counta = count($resulta);

            for ($a=1; $a<=$counta; $a++)
            {
                $explodea = explode('_', $resulta[$a-1]);

                letsgotojapan::$instance->notifyAllPlayers('train','', array(
        
                    'id' => $explodea[2],
                    'ville' => $explodea[1],
                    'train' => 2,
                    
                    )
                    );

                
                self::DbQuery( "UPDATE agent set scoretrain = scoretrain +2  WHERE name='agent'" );

                if($explodea[1] == 1)
                {
                    self::DbQuery( "UPDATE tokyo set train = 2  WHERE card_id = {$explodea[2]}" );
                }

                if($explodea[1] == 2)
                {
                    self::DbQuery( "UPDATE kyoto set train = 2  WHERE card_id = {$explodea[2]}" );
                }




            }



            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '<b>The Travel Agent</b> managed the <b>trains</b>' ), array(
                                
                )
                );

            }

        }

            ///////////////////////////////////////////////////////////////////////////




            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} has finished planning the <b>trip</b>' ), array(
                'player_name' => $this->player_name,
                
                )
                );


            
            
            letsgotojapan::$instance->giveExtraTime($this->player_id);
            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
            
        }

        else
        {
            $card = array();
            $result = array();
        
            for ($day=1; $day <=6; $day++)

            {
                for ($position= 1; $position <=4; $position++)
                {
                    $tokyocardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                    $villefinal = self::getUniqueValueFromDB( "SELECT finallocation finallocation FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardid!=null)
                    {
                        $card[]= [$villefinal,$tokyocardid,1,$train];
                        
                    }

                    else
                    {
                        $kyotocardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                        $villefinal = self::getUniqueValueFromDB( "SELECT finallocation finallocation FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                        $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardid!=null)
                        {
                            $card[]= [$villefinal,$kyotocardid,2,$train];
                        }

                    }

                }
            }

        

            $nombre = count ($card);
            
            for($index=0; $index<$nombre-1 ;$index++)
            {
                if(($card[$index][0] != $card[$index+1][0])&&($card[$index+1][3]==0))
                {
                    $result[] = 'card_'.$card[$index+1][2].'_'.$card[$index+1][1];
                }
                

            }

            $cardselect=$result[0];
            $explode = explode('_', $cardselect);


            if($varg1 == "trainstart")
            {
                self::DbQuery( "UPDATE player set trainstart = 0  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajPannel($this->player_id);


                if($explode[1]==1)
                {
                    self::DbQuery( "UPDATE tokyo set train = 1  WHERE card_id = {$explode[2]}" );
                    

                }

                if($explode[1]==2)
                {
                    self::DbQuery( "UPDATE kyoto set train = 1  WHERE card_id = {$explode[2]}" );
                }

                letsgotojapan::$instance->notifyAllPlayers('train','', array(
        
                    'id' => $explode[2],
                    'ville' => $explode[1],
                    'train' => 1,
                    
                    )
                    );


                

            }

            if($varg1 == "train")
            {
                self::DbQuery( "UPDATE player set train = train -1  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajPannel($this->player_id);

                if($explode[1]==1)
                {
                    self::DbQuery( "UPDATE tokyo set train = 2  WHERE card_id = {$explode[2]}" );
                    

                }

                if($explode[1]==2)
                {
                    self::DbQuery( "UPDATE kyoto set train = 2  WHERE card_id = {$explode[2]}" );
                }

                letsgotojapan::$instance->notifyAllPlayers('train','', array(
        
                    'id' => $explode[2],
                    'ville' => $explode[1],
                    'train' => 2,
                    
                    )
                    );
                
            }

            if($varg1 == "normaltrain")
            {
                if($explode[1]==1)
                {
                    self::DbQuery( "UPDATE tokyo set train = 3  WHERE card_id = {$explode[2]}" );
                    

                }

                if($explode[1]==2)
                {
                    self::DbQuery( "UPDATE kyoto set train = 3  WHERE card_id = {$explode[2]}" );
                }

                letsgotojapan::$instance->notifyAllPlayers('train','', array(
        
                    'id' => $explode[2],
                    'ville' => $explode[1],
                    'train' => 3,
                    
                    )
                    );
                
            }

            $countcard = count($result);
            $newtrainstart = self::getUniqueValueFromDB( "SELECT trainstart FROM player WHERE player_id = {$this->player_id}");
            $newtrain = self::getUniqueValueFromDB( "SELECT train FROM player WHERE player_id = {$this->player_id}");
            
            if(($newtrainstart==0)&&($newtrain==0))
            {
                for($j=1; $j<=$countcard-1; $j++)
                {
                    $explode2 = explode('_', $result[$j]);

                    if($explode2[1]==1)
                    {
                        self::DbQuery( "UPDATE tokyo set train = 3  WHERE card_id = {$explode2[2]}" );
                        

                    }

                    if($explode2[1]==2)
                    {
                        self::DbQuery( "UPDATE kyoto set train = 3  WHERE card_id = {$explode2[2]}" );
                    }

                    letsgotojapan::$instance->notifyAllPlayers('train','', array(
        
                        'id' => $explode2[2],
                        'ville' => $explode2[1],
                        'train' => 3,
                        
                        )
                        );

                }

            }
            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStep3");
            
            
            
            
        }
       

    }

    ////////////////// GO TO TRIP/////////////////

    function argGototrip($parg1, $parg2)      
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();

        $ret['titleyou'] = clienttranslate('Go to trip');   
        $ret['buttons'][]='continue';


        return $ret;
    }

    function Gototrip($parg1, $parg2, $varg1, $varg2)
    {

        letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundiWalk");

    }




    //////////////////////// LUNDI ////////////////////////////

    function argFinalStepLundiWalk($parg1, $parg2)      //changer jour
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        

        
        $found = 0;
        $day = 1; ////////// A CHANGER JOUR
        
            
                for ($position= 1; $position <=4 && $found == 0; $position++)
                {
                    $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardwalk!=null)
                    {
                        $ret["selected3"][] = "card_1_".$tokyocardwalk;
                        $found = 1;
                        break;
                    }

                    else
                    {
                        $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardwalk!=null)
                        {
                            $ret["selected3"][] = "card_2_".$kyotocardwalk;
                            $found = 1;
                            break;
                        }

                    }

                }
            




        if ($ret["selected3"] != null)
        {

            $ret['titleyou'] = clienttranslate('Monday: ${you} must choose a side of the card for this walk <br>');  //changer jour

            $explode = explode('_',$ret["selected3"][0]);
            
            
            if ($explode[1]==1)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_1_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardtokyoverso';
            }

            if ($explode[1]==2)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_2_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardkyotoverso';
            }

            
            
        }

        /*else{

            $ret['titleyou'] = clienttranslate('Monday: ${you} do not have a walk');   ///changer jour
            $ret['buttons'][]='continue';
        }*/

        
        return $ret;
    }

    function FinalStepLundiWalk($parg1, $parg2, $varg1, $varg2) //changer jour
    {
        $found = 0;
        $day = 1; /// changer numero du jour
        $result = array();
        
        for ($position= 1; $position <=4 && $found == 0; $position++)
            {
                $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                if ($tokyocardwalk!=null)
                {
                    $result[] = "card_1_".$tokyocardwalk;
                    $found = 1;
                    break;
                }

                else
                {
                    $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($kyotocardwalk!=null)
                    {
                        $result[] = "card_2_".$kyotocardwalk;
                        $found = 1;
                        break;
                    }

                }

            }
        


        if(($varg1 == "continue")||($varg1==null))
        {
            /*letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the <b>walks</b> for <b>${day}</b>'), array(
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[1]['name'], // changer numero du jour
                
                )
                );*/
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi");   ///changer jour
            
        }

        elseif($varg1 == "cardtokyoverso")
        {
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundiWalk"); ///changer jour
            
            
            
            
        }
        elseif($varg1 == "cardkyotoverso")
        {
            
            
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundiWalk"); ///changer jour
            
            
        }

        else
        {
            $explode = explode('_',$result[0]);

            if ($explode[1]==1)
            {

                self::DbQuery( "UPDATE tokyo set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM tokyo WHERE card_id ={$explode[2]}");


                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM tokyo WHERE card_id ={$explode[2]}");
                

                
                letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                    'cardid' => $result[0],
                    'id' => $explode[2],
                    'ville' => 1,
                    'type' => $type,
                    'location' => $location,
                    'playerid' => $this->player_id,
                    'train' => $typetrain,

                    )
                    );

                letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
            
                    'card' => $result[0],
                    
                    )
                    );

               

                

            }

            if ($explode[1]==2)
            {

                self::DbQuery( "UPDATE kyoto set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM kyoto WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM kyoto WHERE card_id ={$explode[2]}");
                
                    letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                        'cardid' => $result[0],
                        'id' => $explode[2],
                        'ville' => 2,
                        'type' => $type,
                        'location' => $location,
                        'playerid' => $this->player_id,
                        'train' => $typetrain,

                        )
                        );
                    
                    letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
        
                        'card' => $result[0],
                        
                        )
                        );





            }


            //// PASSPORT 18

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 18)
            {
                $scorepassport18 = 0;
                $tokyopass = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );
                $kyotopass = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );

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
                self::DbQuery( "UPDATE player set passportscore = $newscore  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajScorePassport(18,$this->player_id);

            }

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundiWalk");   ///changer jour

        }

       

    }

    function argFinalStepLundi($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        

        $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");

        if(($wild >=1)&&($parg1 == 1))
        {
            $ret['titleyou'] = clienttranslate('Monday! Let\'s go! ${you} can use one (or more) <span class="wild"></span>');
            $ret['buttons'][]='yes';
            $ret['buttons'][]='no';
        }
        /*else
        {
            $ret['titleyou'] = clienttranslate('Monday! Let\'s go!');
            $ret['buttons'][]='continue';
        }*/
       
        
     

        return $ret;
    }

    function FinalStepLundi($parg1, $parg2, $varg1, $varg2)
    {
        $testwild = 0;

        if($parg1 == 2)
        {
            $testwild = 1;
        }

        if($varg1 == "yes")
        {
            letsgotojapan::$instance->addPending($this->player_id, "FinalWild", 1);  // A MODIFIER: dernier chiffre est egal au jour

        }

        if($varg1 == "no")
        {
            $testwild = 1;
        }


        if(($varg1 == "no")||($varg1 == "continue")||($varg1==null))
        {
            letsgotojapan::$instance->notifyAllPlayers('disabled','', array(
        
                               
                )
                );

            
            $day = 1;  //// A MODIFIER

            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;


            if(($parg1 != 1)&&($parg1 !=2))
            {

                $tableaupassport14 = [0,0,0,0,0];

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($type != null)
                {
                    $ville = 1;
                    $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if($walk==0)
                    {
                        $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    }
                    if($walk==1)
                    {
                        $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                        $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                    }

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                    }
                    if ($train == 2)
                    {
                        letsgotojapan::$instance->Gain("h1",$this->player_id);

                        
                    }

                    $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($finalwalk != 0)
                    {
                        self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                    }
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if($walk==0)
                    {
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    }
                    if($walk==1)
                    {
                        $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                        $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                    }
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                    }
                    if ($train == 2)
                    {
                        letsgotojapan::$instance->Gain("h1",$this->player_id);
                    }

                    $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($finalwalk != 0)
                    {
                        self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                    }

                }

                self::DbQuery( "UPDATE player set lundi = lundi + {$pvcard}   WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                

                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',$this->player_id);
                    }

                    $tableaupassport14[0]=1;

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',$this->player_id);
                    }

                    $tableaupassport14[1]=1;

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',$this->player_id);
                    }

                    $tableaupassport14[2]=1;

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',$this->player_id);
                    }

                    $tableaupassport14[3]=1;

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',$this->player_id);
                    }

                    $tableaupassport14[4]=1;

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',$this->player_id);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',$this->player_id);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',$this->player_id);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',$this->player_id);
                    }

                }

                
                
                

            }

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 14)
            {
                
                // Compter les occurrences de chaque valeur
                $comptage = array_count_values($tableaupassport14);

                // Vérifier combien de fois la valeur 0 apparaît
                $nombreDeZeros = isset($comptage[0]) ? $comptage[0] : 0;

                if($nombreDeZeros <=1)
                {
                    self::DbQuery( "UPDATE player set passportscore = passportscore + 6  WHERE player_id = {$this->player_id}" );
                    letsgotojapan::$instance->MajScorePassport(14,$this->player_id);

                }

            }

            if($testwild == 0)
            {
            $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");
            if($wild >= 1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi", 1); //Changer le jour
            }
            else
            {
                $testwild = 1;
            }
            }



        }

        if($testwild == 1)
        {
            $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            if ($lastville != null)
            {
                $ville = 1;
            }
            else
            {
                $ville = 2;
            }

            $savescore = self::getUniqueValueFromDB( "SELECT lundi FROM player WHERE  player_id = {$this->player_id}"); //passport3
            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            $savetoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" ); //passport12
            $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");
            $checkforce = 0;

            if($ville == 1)
                {
                    $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                    $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                    $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                    if ($walklastday == 0)
                    {
                    $method = "Tokyo_" . $lastday;
                    $check = CardTokyo::$method($this->player_id, 'lundi'); // A MODIFIER JOUR

                    if($check == 1)
                    {
                        if($passportcard == 3)
                        {
                        $newscore = self::getUniqueValueFromDB( "SELECT lundi FROM player WHERE  player_id = {$this->player_id}");
                        $scorepassport = $newscore - $savescore;
                        self::DbQuery( "UPDATE player set passportscore = passportscore +$scorepassport   WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->MajScorePassport(3,$this->player_id);
                        }

                        if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }

                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE player set lundicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }

                    if($check == 2)
                    {
                        if(($passportcard == 10)&&($pass10 >=1))
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "ForceLundi"); //JOUR
                            $checkforce=1;

                        }
                        else
                        {
                        self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE player set lundicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            );
                        } 
                    }
                    }

                    if($walklastday == 1)
                    {
                        if($passportcard == 3)
                        {
                            self::DbQuery( "UPDATE player set passportscore = passportscore +2   WHERE player_id = {$this->player_id}" );
                            letsgotojapan::$instance->MajScorePassport(3,$this->player_id);
                        }

                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set lundicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set lundi = lundi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }

                    if($checkforce == 0)
                    {
                    letsgotojapan::$instance->notifyAllPlayers('check','', array(
                    
                        'id' => $cardid,
                        'ville' => 1,
                        'check' => $check,
                        
                        )
                        ); 
                    }

                }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                
                $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                if ($walklastday == 0)
                {
                $method = "Kyoto_" . $lastday;
                $check = CardKyoto::$method($this->player_id, 'lundi'); // A MODIFIER JOUR

                if($check == 1)
                    {
                        if($passportcard == 3)
                        {
                        $newscore = self::getUniqueValueFromDB( "SELECT lundi FROM player WHERE  player_id = {$this->player_id}");
                        $scorepassport = $newscore - $savescore;
                        self::DbQuery( "UPDATE player set passportscore = passportscore +$scorepassport   WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->MajScorePassport(3,$this->player_id);
                        }

                        if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }

                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE player set lundicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            );
                        
                    }

                    if($check == 2)
                    {
                        if(($passportcard == 10)&&($pass10 >=1))
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "ForceLundi"); //JOUR
                            $checkforce=1;

                        }
                        else
                        {
                        self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE player set lundicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            );
                        }
                    }
                }

                if($walklastday == 1)
                    {
                        if($passportcard == 3)
                        {
                            self::DbQuery( "UPDATE player set passportscore = passportscore +2   WHERE player_id = {$this->player_id}" );
                            letsgotojapan::$instance->MajScorePassport(3,$this->player_id);
                        }

                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set lundicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set lundi = lundi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }

                if($checkforce == 0)
                {
                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 2,
                    'check' => $check,
                    
                    
                    )
                    );
                } 
                
            }

            if($checkforce == 0)
            {

            $finalscore = self::getUniqueValueFromDB( "SELECT lundi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => $this->player_no,
                'score' => $finalscore,
                'position' => $day,
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[1]['name'],   // changer jour
                
                )
                );     
                
            //////////////////////////////////////////////////////////////////////////////   
            ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

            if($countplayer == 1)

            {


            $counttrip = letsgotojapan::$instance->CountTrip(0);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

                if ($type != null)
                {
                    $ville = 1;
                
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                self::DbQuery( "UPDATE agent set lundi = lundi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',0);
                    }

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',0);
                    }

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',0);
                    }

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',0);
                    }

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',0);
                    }

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',0);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',0);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',0);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',0);
                    }

                }

                
                
                

            }

            if($ville == 1)
                {
                    $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                    $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                    
                    
                    $method = "AgentTokyo_" . $lastday;
                    $check = AgentCardTokyo::$method(0, 'lundi'); // A MODIFIER JOUR

                    if($check == 1)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set lundicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set lundicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                    

                    

                    letsgotojapan::$instance->notifyAllPlayers('check','', array(
                    
                        'id' => $cardid,
                        'ville' => 1,
                        'check' => $check,
                        
                        )
                        ); 

                }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                
                
                $method = "AgentKyoto_" . $lastday;
                $check = AgentCardKyoto::$method(0, 'lundi'); // A MODIFIER JOUR

                if($check == 1)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set lundicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                        
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set lundicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 2,
                    'check' => $check,
                    
                    
                    )
                    ); 
                
            }


            $finalscore = self::getUniqueValueFromDB( "SELECT lundi FROM agent WHERE name='agent'");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => 2,
                'score' => $finalscore,
                'position' => $day,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[1]['name'],   // changer jour
                
                )
                ); 


            
            }

            ////////////////////////////////////////////////////////////////////////////// 
            ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 
            

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardiWalk"); // à modifier pour aller sur le mardi


        }


        }  



        }




    }


    //////////////////////// MARDI ////////////////////////////

    function argFinalStepMardiWalk($parg1, $parg2)      //changer jour
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        

        
        $found = 0;
        $day = 2; ////////// A CHANGER JOUR
        
            
                for ($position= 1; $position <=4 && $found == 0; $position++)
                {
                    $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardwalk!=null)
                    {
                        $ret["selected3"][] = "card_1_".$tokyocardwalk;
                        $found = 1;
                        break;
                    }

                    else
                    {
                        $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardwalk!=null)
                        {
                            $ret["selected3"][] = "card_2_".$kyotocardwalk;
                            $found = 1;
                            break;
                        }

                    }

                }
            




        if ($ret["selected3"] != null)
        {

            $ret['titleyou'] = clienttranslate('Tuesday: ${you} must choose a side of the card for this walk <br>');  //changer jour

            $explode = explode('_',$ret["selected3"][0]);
            
            
            if ($explode[1]==1)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_1_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardtokyoverso';
            }

            if ($explode[1]==2)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_2_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardkyotoverso';
            }

            
            
        }

        /*else{

            $ret['titleyou'] = clienttranslate('Tuesday: ${you} do not have a walk');   ///changer jour
            $ret['buttons'][]='continue';
        }*/

        
        return $ret;
    }

    function FinalStepMardiWalk($parg1, $parg2, $varg1, $varg2) //changer jour
    {
        $found = 0;
        $day = 2; /// changer numero du jour
        $result = array();
        
        for ($position= 1; $position <=4 && $found == 0; $position++)
            {
                $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                if ($tokyocardwalk!=null)
                {
                    $result[] = "card_1_".$tokyocardwalk;
                    $found = 1;
                    break;
                }

                else
                {
                    $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($kyotocardwalk!=null)
                    {
                        $result[] = "card_2_".$kyotocardwalk;
                        $found = 1;
                        break;
                    }

                }

            }
        


        if(($varg1 == "continue")||($varg1==null))
        {
            /*letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the <b>walks</b> for <b>${day}</b>'), array(
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[2]['name'], // changer numero du jour
                
                )
                );*/
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardi");   ///changer jour
            
        }

        elseif($varg1 == "cardtokyoverso")
        {
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardiWalk"); ///changer jour
            
            
            
            
        }
        elseif($varg1 == "cardkyotoverso")
        {
            
            
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardiWalk"); ///changer jour
            
            
        }

        else
        {
            $explode = explode('_',$result[0]);

            if ($explode[1]==1)
            {

                self::DbQuery( "UPDATE tokyo set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM tokyo WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM tokyo WHERE card_id ={$explode[2]}");
                
                letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                    'cardid' => $result[0],
                    'id' => $explode[2],
                    'ville' => 1,
                    'type' => $type,
                    'location' => $location,
                    'playerid' => $this->player_id,
                    'train' => $typetrain,

                    )
                    );

                letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
            
                    'card' => $result[0],
                    
                    )
                    );

               

                

            }

            if ($explode[1]==2)
            {

                self::DbQuery( "UPDATE kyoto set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM kyoto WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM kyoto WHERE card_id ={$explode[2]}");

                    letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                        'cardid' => $result[0],
                        'id' => $explode[2],
                        'ville' => 2,
                        'type' => $type,
                        'location' => $location,
                        'playerid' => $this->player_id,
                        'train' => $typetrain,

                        )
                        );
                    
                    letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
        
                        'card' => $result[0],
                        
                        )
                        );





            }

            //// PASSPORT 18

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 18)
            {
                $scorepassport18 = 0;
                $tokyopass = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );
                $kyotopass = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );

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
                self::DbQuery( "UPDATE player set passportscore = $newscore  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajScorePassport(18,$this->player_id);

            }

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardiWalk");   ///changer jour

        }

       

    }

    function argFinalStepMardi($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        

        $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");

        if(($wild >=1)&&($parg1 == 1))
        {
            $ret['titleyou'] = clienttranslate('Tuesday! Let\'s go! ${you} can use one (or more) <span class="wild"></span>');
            $ret['buttons'][]='yes';
            $ret['buttons'][]='no';
        }
        /*else
        {
            $ret['titleyou'] = clienttranslate('Tuesday! Let\'s go!');
            $ret['buttons'][]='continue';
        }*/
       
        
     

        return $ret;
    }

    function FinalStepMardi($parg1, $parg2, $varg1, $varg2)
    {
        $testwild = 0;

        if($parg1 == 2)
        {
            $testwild = 1;
        }
        
        if($varg1 == "yes")
        {
            letsgotojapan::$instance->addPending($this->player_id, "FinalWild", 2);  // A MODIFIER: dernier chiffre est egal au jour

        }

        if($varg1 == "no")
        {
            $testwild = 1;
        }

        if(($varg1 == "no")||($varg1 == "continue")||($varg1 == null))
        {
            letsgotojapan::$instance->notifyAllPlayers('disabled','', array(
        
                               
                )
                );

            $day = 2;  //// A MODIFIER

            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            if(($parg1 != 1)&&($parg1 !=2))
            {
                $tableaupassport14 = [0,0,0,0,0];

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($type != null)
                {
                    $ville = 1;
                    $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if($walk==0)
                    {
                        $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    }
                    if($walk==1)
                    {
                        $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                        $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                    }

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                    }
                    if ($train == 2)
                    {
                        letsgotojapan::$instance->Gain("h1",$this->player_id);
                    }

                    $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($finalwalk != 0)
                    {
                        self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                    }
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if($walk==0)
                    {
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    }
                    if($walk==1)
                    {
                        $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                        $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                    }
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                    }
                    if ($train == 2)
                    {
                        letsgotojapan::$instance->Gain("h1",$this->player_id);
                    }

                    $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($finalwalk != 0)
                    {
                        self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                    }

                }

                self::DbQuery( "UPDATE player set mardi = mardi + {$pvcard}   WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',$this->player_id);
                    }

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',$this->player_id);
                    }
                    $tableaupassport14[0]=1;

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',$this->player_id);
                    }
                    $tableaupassport14[1]=1;

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',$this->player_id);
                    }
                    $tableaupassport14[2]=1;

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',$this->player_id);
                    }
                    $tableaupassport14[3]=1;

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',$this->player_id);
                    }
                    $tableaupassport14[4]=1;

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',$this->player_id);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',$this->player_id);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',$this->player_id);
                    }

                }


            }

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 14)
            {
                
                // Compter les occurrences de chaque valeur
                $comptage = array_count_values($tableaupassport14);

                // Vérifier combien de fois la valeur 0 apparaît
                $nombreDeZeros = isset($comptage[0]) ? $comptage[0] : 0;

                if($nombreDeZeros <=1)
                {
                    self::DbQuery( "UPDATE player set passportscore = passportscore + 6  WHERE player_id = {$this->player_id}" );
                    letsgotojapan::$instance->MajScorePassport(14,$this->player_id);

                }

            }

            if($testwild == 0)
            {
            $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");
            if($wild >= 1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardi", 1); //Changer le jour
            }
            else
            {
                $testwild = 1;
            }
            }



        }

        if($testwild == 1)
        {
            $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            if ($lastville != null)
            {
                $ville = 1;
            }
            else
            {
                $ville = 2;
            }

            $savescore = self::getUniqueValueFromDB( "SELECT mardi FROM player WHERE  player_id = {$this->player_id}");
            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            $savetoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" ); //passport12
            $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");
            $checkforce = 0;

            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                
                $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                if ($walklastday == 0)
                {
                $method = "Tokyo_" . $lastday;
                $check = CardTokyo::$method($this->player_id, 'mardi'); // A MODIFIER JOUR

                if($check == 1)
                {
                    if($passportcard == 3)
                        {
                        $newscore = self::getUniqueValueFromDB( "SELECT mardi FROM player WHERE  player_id = {$this->player_id}");
                        $scorepassport = $newscore - $savescore;
                        self::DbQuery( "UPDATE player set passportscore = passportscore +$scorepassport   WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->MajScorePassport(3,$this->player_id);
                        }

                        if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }

                    self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE player set mardicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                }

                if($check == 2)
                {
                    if(($passportcard == 10)&&($pass10 >=1))
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "ForceMardi"); //JOUR
                        $checkforce=1;

                    }
                    else
                    {
                    self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE player set mardicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            );
                    } 
                }
            }

            if($walklastday == 1)
                    {
                        if($passportcard == 3)
                        {
                            self::DbQuery( "UPDATE player set passportscore = passportscore +2   WHERE player_id = {$this->player_id}" );
                            letsgotojapan::$instance->MajScorePassport(3,$this->player_id);
                        }

                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set mardicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set mardi = mardi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }


                    if($checkforce == 0)
                    {
                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 1,
                    'check' => $check,
                    
                    )
                    ); 
                }

            }

        if($ville == 2)
        {
            $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                if ($walklastday == 0)
                {
            $method = "Kyoto_" . $lastday;
            $check = CardKyoto::$method($this->player_id, 'mardi'); // A MODIFIER JOUR

            if($check == 1)
                {
                    if($passportcard == 3)
                        {
                        $newscore = self::getUniqueValueFromDB( "SELECT mardi FROM player WHERE  player_id = {$this->player_id}");
                        $scorepassport = $newscore - $savescore;
                        self::DbQuery( "UPDATE player set passportscore = passportscore +$scorepassport   WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->MajScorePassport(3,$this->player_id);
                        }

                        if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }

                    self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE player set mardicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                }

                if($check == 2)
                {
                    if(($passportcard == 10)&&($pass10 >=1))
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "ForceMardi"); //JOUR
                            $checkforce=1;

                        }
                        else
                        {
                    self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE player set mardicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            );
                        }
                }
            }

            if($walklastday == 1)
                    {

                        if($passportcard == 3)
                        {
                            self::DbQuery( "UPDATE player set passportscore = passportscore +2   WHERE player_id = {$this->player_id}" );
                            letsgotojapan::$instance->MajScorePassport(3,$this->player_id);
                        }

                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set mardicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set mardi = mardi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }

                    if($checkforce == 0)
                    {
            letsgotojapan::$instance->notifyAllPlayers('check','', array(
            
                'id' => $cardid,
                'ville' => 2,
                'check' => $check,
                
                )
                ); 
            }
            
        }   
        if($checkforce == 0)
            {           
            

            $finalscore = self::getUniqueValueFromDB( "SELECT mardi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => $this->player_no,
                'score' => $finalscore,
                'position' => $day,
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[2]['name'],
                
                )
                ); 



            //////////////////////////////////////////////////////////////////////////////   
            ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

            if($countplayer == 1)

            {

            $counttrip = letsgotojapan::$instance->CountTrip(0);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

                if ($type != null)
                {
                    $ville = 1;
                
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                self::DbQuery( "UPDATE agent set mardi = mardi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',0);
                    }

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',0);
                    }

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',0);
                    }

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',0);
                    }

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',0);
                    }

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',0);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',0);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',0);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',0);
                    }

                }

                
                
                

            }

            if($ville == 1)
                {
                    $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                    $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                    
                    
                    $method = "AgentTokyo_" . $lastday;
                    $check = AgentCardTokyo::$method(0, 'mardi'); // A MODIFIER JOUR

                    if($check == 1)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mardicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mardicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                    

                    

                    letsgotojapan::$instance->notifyAllPlayers('check','', array(
                    
                        'id' => $cardid,
                        'ville' => 1,
                        'check' => $check,
                        
                        )
                        ); 

                }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                
                
                $method = "AgentKyoto_" . $lastday;
                $check = AgentCardKyoto::$method(0, 'mardi'); // A MODIFIER JOUR

                if($check == 1)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mardicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                        
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mardicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 2,
                    'check' => $check,
                    
                    
                    )
                    ); 
                
            }


            $finalscore = self::getUniqueValueFromDB( "SELECT mardi FROM agent WHERE name='agent'");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => 2,
                'score' => $finalscore,
                'position' => $day,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[2]['name'],   // changer jour
                
                )
                ); 


            
            }

            ////////////////////////////////////////////////////////////////////////////// 
            ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercrediWalk"); // à modifier pour aller sur le mardi


        }   
    }



        }




    }

    //////////////////////// MERCREDI ////////////////////////////

    function argFinalStepMercrediWalk($parg1, $parg2)      //changer jour
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        

        
        $found = 0;
        $day = 3; ////////// A CHANGER JOUR
        
            
                for ($position= 1; $position <=4 && $found == 0; $position++)
                {
                    $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardwalk!=null)
                    {
                        $ret["selected3"][] = "card_1_".$tokyocardwalk;
                        $found = 1;
                        break;
                    }

                    else
                    {
                        $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardwalk!=null)
                        {
                            $ret["selected3"][] = "card_2_".$kyotocardwalk;
                            $found = 1;
                            break;
                        }

                    }

                }
            




        if ($ret["selected3"] != null)
        {

            $ret['titleyou'] = clienttranslate('Wednesday: ${you} must choose a side of the card for this walk <br>');  //changer jour

            $explode = explode('_',$ret["selected3"][0]);
            
            
            if ($explode[1]==1)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_1_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardtokyoverso';
            }

            if ($explode[1]==2)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_2_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardkyotoverso';
            }

            
            
        }

        /*else{

            $ret['titleyou'] = clienttranslate('Wednesday: ${you} do not have a walk');   ///changer jour
            $ret['buttons'][]='continue';
        }*/

        
        return $ret;
    }

    function FinalStepMercrediWalk($parg1, $parg2, $varg1, $varg2) //changer jour
    {
        $found = 0;
        $day = 3; /// changer numero du jour
        $result = array();
        
        for ($position= 1; $position <=4 && $found == 0; $position++)
            {
                $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                if ($tokyocardwalk!=null)
                {
                    $result[] = "card_1_".$tokyocardwalk;
                    $found = 1;
                    break;
                }

                else
                {
                    $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($kyotocardwalk!=null)
                    {
                        $result[] = "card_2_".$kyotocardwalk;
                        $found = 1;
                        break;
                    }

                }

            }
        


        if(($varg1 == "continue")||($varg1==null))
        {
            /*letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the <b>walks</b> for <b>${day}</b>'), array(
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[3]['name'], // changer numero du jour
                
                )
                );*/
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercredi");   ///changer jour
            
        }

        elseif($varg1 == "cardtokyoverso")
        {
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercrediWalk"); ///changer jour
            
            
            
            
        }
        elseif($varg1 == "cardkyotoverso")
        {
            
            
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercrediWalk"); ///changer jour
            
            
        }

        else
        {
            $explode = explode('_',$result[0]);

            if ($explode[1]==1)
            {

                self::DbQuery( "UPDATE tokyo set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM tokyo WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM tokyo WHERE card_id ={$explode[2]}");

                letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                    'cardid' => $result[0],
                    'id' => $explode[2],
                    'ville' => 1,
                    'type' => $type,
                    'location' => $location,
                    'playerid' => $this->player_id,
                    'train' => $typetrain,


                    )
                    );

                letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
            
                    'card' => $result[0],
                    
                    )
                    );

               

                

            }

            if ($explode[1]==2)
            {

                self::DbQuery( "UPDATE kyoto set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM kyoto WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM kyoto WHERE card_id ={$explode[2]}");
                
                    letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                        'cardid' => $result[0],
                        'id' => $explode[2],
                        'ville' => 2,
                        'type' => $type,
                        'location' => $location,
                        'playerid' => $this->player_id,
                        'train' => $typetrain,

                        )
                        );
                    
                    letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
        
                        'card' => $result[0],
                        
                        )
                        );





            }

            //// PASSPORT 18

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 18)
            {
                $scorepassport18 = 0;
                $tokyopass = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );
                $kyotopass = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );

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
                self::DbQuery( "UPDATE player set passportscore = $newscore  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajScorePassport(18,$this->player_id);

            }

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercrediWalk");   ///changer jour

        }

       

    }

    function argFinalStepMercredi($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        

        $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");

        if(($wild >=1)&&($parg1 == 1))
        {
            $ret['titleyou'] = clienttranslate('Wednesday! Let\'s go! ${you} can use one (or more) <span class="wild"></span>');
            $ret['buttons'][]='yes';
            $ret['buttons'][]='no';
        }
        /*else
        {
            $ret['titleyou'] = clienttranslate('Wednesday! Let\'s go!');
            $ret['buttons'][]='continue';
        }*/
       
        
     

        return $ret;
    }

    function FinalStepMercredi($parg1, $parg2, $varg1, $varg2)
    {
        $testwild = 0;

        if($parg1 == 2)
        {
            $testwild = 1;
        }

        if($varg1 == "yes")
        {
            letsgotojapan::$instance->addPending($this->player_id, "FinalWild", 3);  // A MODIFIER: dernier chiffre est egal au jour

        }

        
        if($varg1 == "no")
        {
            $testwild = 1;
        }

        if(($varg1 == "no")||($varg1 == "continue")||($varg1==null))
        {
            letsgotojapan::$instance->notifyAllPlayers('disabled','', array(
        
                               
                )
                );

            $day = 3;  //// A MODIFIER

            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            if(($parg1 != 1)&&($parg1 !=2))
            {

                $tableaupassport14 = [0,0,0,0,0];

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($type != null)
                {
                    $ville = 1;
                    $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if($walk==0)
                    {
                        $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    }
                    if($walk==1)
                    {
                        $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                        $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                    }

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                    }
                    if ($train == 2)
                    {
                        letsgotojapan::$instance->Gain("h1",$this->player_id);
                    }

                    $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($finalwalk != 0)
                    {
                        self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                    }
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if($walk==0)
                    {
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    }
                    if($walk==1)
                    {
                        $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                        $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                    }
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                    }
                    if ($train == 2)
                    {
                        letsgotojapan::$instance->Gain("h1",$this->player_id);
                    }

                    $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($finalwalk != 0)
                    {
                        self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                    }

                }

                self::DbQuery( "UPDATE player set mercredi = mercredi + {$pvcard}   WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',$this->player_id);
                    }
                    $tableaupassport14[0]=1;

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',$this->player_id);
                    }
                    $tableaupassport14[1]=1;

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',$this->player_id);
                    }
                    $tableaupassport14[2]=1;

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',$this->player_id);
                    }
                    $tableaupassport14[3]=1;

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',$this->player_id);
                    }
                    $tableaupassport14[4]=1;

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',$this->player_id);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',$this->player_id);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',$this->player_id);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',$this->player_id);
                    }

                }


            }

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 14)
            {
                
                // Compter les occurrences de chaque valeur
                $comptage = array_count_values($tableaupassport14);

                // Vérifier combien de fois la valeur 0 apparaît
                $nombreDeZeros = isset($comptage[0]) ? $comptage[0] : 0;

                if($nombreDeZeros <=1)
                {
                    self::DbQuery( "UPDATE player set passportscore = passportscore + 6  WHERE player_id = {$this->player_id}" );
                    letsgotojapan::$instance->MajScorePassport(14,$this->player_id);

                }

            }

            if($testwild == 0)
            {
            $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");
            if($wild >= 1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercredi", 1); //Changer le jour
            }
            else
            {
                $testwild = 1;
            }
            }



        }

        if($testwild == 1)
        {
            $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            if ($lastville != null)
            {
                $ville = 1;
            }
            else
            {
                $ville = 2;
            }

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            $savetoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" ); //passport12
            $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");
            $checkforce = 0;

            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                
                $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                if ($walklastday == 0)
                {
                $method = "Tokyo_" . $lastday;
                $check = CardTokyo::$method($this->player_id, 'mercredi'); // A MODIFIER JOUR

                if($check == 1)
                {
                    if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }
                    self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE player set mercredicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                }

                if($check == 2)
                {
                    if(($passportcard == 10)&&($pass10 >=1))
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "ForceMercredi"); //JOUR
                            $checkforce=1;

                        }
                        else
                        {
                    self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE player set mercredicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                        }
                }
            }

            if($walklastday == 1)
                    {

                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set mercredicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set mercredi = mercredi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }

                    if($checkforce == 0)
                    {
                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 1,
                    'check' => $check,
                    
                    )
                    ); 
                }

            }

        if($ville == 2)
        {
            $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            
            $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            if ($walklastday == 0)
            {
            $method = "Kyoto_" . $lastday;
            $check = CardKyoto::$method($this->player_id, 'mercredi'); // A MODIFIER JOUR

            if($check == 1)
                {
                    if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }

                    self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE player set mercredicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            );
                }

                if($check == 2)
                {
                    if(($passportcard == 10)&&($pass10 >=1))
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "ForceMercredi"); //JOUR
                            $checkforce=1;

                        }
                        else
                        {
                    self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE player set mercredicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            );
                        }
                }

            }

            if($walklastday == 1)
                    {

                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set mercredicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set mercredi = mercredi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }


                    if($checkforce == 0)
                    {
            letsgotojapan::$instance->notifyAllPlayers('check','', array(
            
                'id' => $cardid,
                'ville' => 2,
                'check' => $check,
                
                )
                ); 
            }
            
        }                 
            
        if($checkforce == 0)
        {
            $finalscore = self::getUniqueValueFromDB( "SELECT mercredi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => $this->player_no,
                'score' => $finalscore,
                'position' => $day,
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[3]['name'],
                
                )
                );

            //////////////////////////////////////////////////////////////////////////////   
            ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

            if($countplayer == 1)

            {

            $counttrip = letsgotojapan::$instance->CountTrip(0);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

                if ($type != null)
                {
                    $ville = 1;
                
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                self::DbQuery( "UPDATE agent set mercredi = mercredi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',0);
                    }

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',0);
                    }

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',0);
                    }

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',0);
                    }

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',0);
                    }

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',0);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',0);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',0);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',0);
                    }

                }

                
                
                

            }

            if($ville == 1)
                {
                    $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                    $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                    
                    
                    $method = "AgentTokyo_" . $lastday;
                    $check = AgentCardTokyo::$method(0, 'mercredi'); // A MODIFIER JOUR

                    if($check == 1)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mercredicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mercredicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                    

                    

                    letsgotojapan::$instance->notifyAllPlayers('check','', array(
                    
                        'id' => $cardid,
                        'ville' => 1,
                        'check' => $check,
                        
                        )
                        ); 

                }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                
                
                $method = "AgentKyoto_" . $lastday;
                $check = AgentCardKyoto::$method(0, 'mercredi'); // A MODIFIER JOUR

                if($check == 1)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mercredicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                        
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mercredicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 2,
                    'check' => $check,
                    
                    
                    )
                    ); 
                
            }


            $finalscore = self::getUniqueValueFromDB( "SELECT mercredi FROM agent WHERE name='agent'");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => 2,
                'score' => $finalscore,
                'position' => $day,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[3]['name'],   // changer jour
                
                )
                ); 


            
            }

            ////////////////////////////////////////////////////////////////////////////// 
            ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudiWalk"); // à modifier pour aller sur le mardi


        }  
    } 



        }




    }




//////////////////////// JEUDI ////////////////////////////

function argFinalStepJeudiWalk($parg1, $parg2)      //changer jour
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        

        
        $found = 0;
        $day = 4; ////////// A CHANGER JOUR
        
            
                for ($position= 1; $position <=4 && $found == 0; $position++)
                {
                    $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardwalk!=null)
                    {
                        $ret["selected3"][] = "card_1_".$tokyocardwalk;
                        $found = 1;
                        break;
                    }

                    else
                    {
                        $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardwalk!=null)
                        {
                            $ret["selected3"][] = "card_2_".$kyotocardwalk;
                            $found = 1;
                            break;
                        }

                    }

                }
            




        if ($ret["selected3"] != null)
        {

            $ret['titleyou'] = clienttranslate('Thursday: ${you} must choose a side of the card for this walk <br>');  //changer jour

            $explode = explode('_',$ret["selected3"][0]);
            
            
            if ($explode[1]==1)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_1_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardtokyoverso';
            }

            if ($explode[1]==2)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_2_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardkyotoverso';
            }

            
            
        }

        /*else{

            $ret['titleyou'] = clienttranslate('Thursday: ${you} do not have a walk');   ///changer jour
            $ret['buttons'][]='continue';
        }*/

        
        return $ret;
    }

    function FinalStepJeudiWalk($parg1, $parg2, $varg1, $varg2) //changer jour
    {
        $found = 0;
        $day = 4; /// changer numero du jour
        $result = array();
        
        for ($position= 1; $position <=4 && $found == 0; $position++)
            {
                $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                if ($tokyocardwalk!=null)
                {
                    $result[] = "card_1_".$tokyocardwalk;
                    $found = 1;
                    break;
                }

                else
                {
                    $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($kyotocardwalk!=null)
                    {
                        $result[] = "card_2_".$kyotocardwalk;
                        $found = 1;
                        break;
                    }

                }

            }
        


        if(($varg1 == "continue")||($varg1==null))
        {
            /*letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the <b>walks</b> for <b>${day}</b>'), array(
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[4]['name'], // changer numero du jour
                
                )
                );*/
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudi");   ///changer jour
            
        }

        elseif($varg1 == "cardtokyoverso")
        {
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudiWalk"); ///changer jour
            
            
            
            
        }
        elseif($varg1 == "cardkyotoverso")
        {
            
            
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudiWalk"); ///changer jour
            
            
        }

        else
        {
            $explode = explode('_',$result[0]);

            if ($explode[1]==1)
            {

                self::DbQuery( "UPDATE tokyo set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM tokyo WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM tokyo WHERE card_id ={$explode[2]}");
                
                letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                    'cardid' => $result[0],
                    'id' => $explode[2],
                    'ville' => 1,
                    'type' => $type,
                    'location' => $location,
                    'playerid' => $this->player_id,
                    'train' => $typetrain,

                    )
                    );

                letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
            
                    'card' => $result[0],
                    
                    )
                    );

               

                

            }

            if ($explode[1]==2)
            {

                self::DbQuery( "UPDATE kyoto set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM kyoto WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM kyoto WHERE card_id ={$explode[2]}");
                
                    letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                        'cardid' => $result[0],
                        'id' => $explode[2],
                        'ville' => 2,
                        'type' => $type,
                        'location' => $location,
                        'playerid' => $this->player_id,
                        'train' => $typetrain,

                        )
                        );
                    
                    letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
        
                        'card' => $result[0],
                        
                        )
                        );





            }

            //// PASSPORT 18

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 18)
            {
                $scorepassport18 = 0;
                $tokyopass = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );
                $kyotopass = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );

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
                self::DbQuery( "UPDATE player set passportscore = $newscore  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajScorePassport(18,$this->player_id);

            }

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudiWalk");   ///changer jour

        }

       

    }

function argFinalStepJeudi($parg1, $parg2)
{
    $ret = array();
    $ret["selectable"] = array();
    $ret["selectable2"] = array();
    $ret["selectableswitch"] = array();
    $ret["selected"] = array();
    $ret['buttons'] = array();
    

    $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");

    if(($wild >=1)&&($parg1 == 1))
    {
        $ret['titleyou'] = clienttranslate('Thursday! Let\'s go! ${you} can use one (or more) <span class="wild"></span>');
        $ret['buttons'][]='yes';
        $ret['buttons'][]='no';
    }
    /*else
    {
        $ret['titleyou'] = clienttranslate('Thursday! Let\'s go!');
        $ret['buttons'][]='continue';
    }*/
   
    
 

    return $ret;
}

function FinalStepJeudi($parg1, $parg2, $varg1, $varg2)
{
    $testwild = 0;

        if($parg1 == 2)
        {
            $testwild = 1;
        }

    if($varg1 == "yes")
    {
        letsgotojapan::$instance->addPending($this->player_id, "FinalWild", 4);  // A MODIFIER: dernier chiffre est egal au jour

    }

    if($varg1 == "no")
    {
        $testwild = 1;
    }

    if(($varg1 == "no")||($varg1 == "continue")||($varg1==null))
    {

        letsgotojapan::$instance->notifyAllPlayers('disabled','', array(
        
                               
            )
            );

        $day = 4;  //// A MODIFIER

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
        $countday = $counttrip[$day-1];
        $bonuscard = array();
        $pvcard =0;
        $ville = 0;

        if(($parg1 != 1)&&($parg1 !=2))
        {
            $tableaupassport14 = [0,0,0,0,0];

        for ($i=1; $i<=$countday; $i++)
        {
            $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
            if ($type != null)
            {
                $ville = 1;
                $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if($walk==0)
                {
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                }
                if($walk==1)
                {
                    $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                    $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                }

                $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                }
                if ($train == 2)
                {
                    letsgotojapan::$instance->Gain("h1",$this->player_id);
                }

                $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($finalwalk != 0)
                {
                    self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                }
            }

            else
            {
                $ville = 2;
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if($walk==0)
                {
                    $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                }
                if($walk==1)
                {
                    $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                    $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                }
                $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                }
                if ($train == 2)
                {
                    letsgotojapan::$instance->Gain("h1",$this->player_id);
                }

                $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($finalwalk != 0)
                {
                    self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                }

            }

            self::DbQuery( "UPDATE player set jeudi = jeudi + {$pvcard}   WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR


            if($bonuscard[0]>=1)
            {
                for($token=1; $token<=$bonuscard[0]; $token++)
                {
                    letsgotojapan::$instance->Gain('r',$this->player_id);
                }
                $tableaupassport14[0]=1;

            }

            if($bonuscard[1]>=1)
            {
                for($token=1; $token<=$bonuscard[1]; $token++)
                {
                    letsgotojapan::$instance->Gain('g',$this->player_id);
                }
                $tableaupassport14[1]=1;

            }

            if($bonuscard[2]>=1)
            {
                for($token=1; $token<=$bonuscard[2]; $token++)
                {
                    letsgotojapan::$instance->Gain('p',$this->player_id);
                }
                $tableaupassport14[2]=1;

            }

            if($bonuscard[3]>=1)
            {
                for($token=1; $token<=$bonuscard[3]; $token++)
                {
                    letsgotojapan::$instance->Gain('y',$this->player_id);
                }
                $tableaupassport14[3]=1;

            }

            if($bonuscard[4]>=1)
            {
                for($token=1; $token<=$bonuscard[4]; $token++)
                {
                    letsgotojapan::$instance->Gain('b',$this->player_id);
                }
                $tableaupassport14[4]=1;

            }

            if($bonuscard[5]>=1)
            {
                for($token=1; $token<=$bonuscard[5]; $token++)
                {
                    letsgotojapan::$instance->Gain('h1',$this->player_id);
                }

            }

            if($bonuscard[6]>=1)
            {
                for($token=1; $token<=$bonuscard[6]; $token++)
                {
                    letsgotojapan::$instance->Gain('h2',$this->player_id);
                }

            }

            if($bonuscard[7]>=1)
            {
                for($token=1; $token<=$bonuscard[7]; $token++)
                {
                    letsgotojapan::$instance->Gain('a1',$this->player_id);
                }

            }

            if($bonuscard[8]>=1)
            {
                for($token=1; $token<=$bonuscard[8]; $token++)
                {
                    letsgotojapan::$instance->Gain('a2',$this->player_id);
                }

            }


        }

        $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 14)
            {
                
                // Compter les occurrences de chaque valeur
                $comptage = array_count_values($tableaupassport14);

                // Vérifier combien de fois la valeur 0 apparaît
                $nombreDeZeros = isset($comptage[0]) ? $comptage[0] : 0;

                if($nombreDeZeros <=1)
                {
                    self::DbQuery( "UPDATE player set passportscore = passportscore + 6  WHERE player_id = {$this->player_id}" );
                    letsgotojapan::$instance->MajScorePassport(14,$this->player_id);

                }

            }

        if($testwild == 0)
        {
        $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");
        if($wild >= 1)
        {
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudi", 1); //Changer le jour
        }
        else
        {
            $testwild = 1;
        }
        }



    }

    if($testwild == 1)
    {
        $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($lastville != null)
        {
            $ville = 1;
        }
        else
        {
            $ville = 2;
        }

        $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
        $savetoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" ); //passport12
        $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");
        $checkforce = 0;   

        if($ville == 1)
        {
            $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            
            $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            if ($walklastday == 0)
            {
            $method = "Tokyo_" . $lastday;
            $check = CardTokyo::$method($this->player_id, 'jeudi'); // A MODIFIER JOUR

            if($check == 1)
            {
                if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }
                self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set jeudicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
            }

            if($check == 2)
            {
                if(($passportcard == 10)&&($pass10 >=1))
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "ForceJeudi"); //JOUR
                            $checkforce=1;

                        }
                        else
                        {
                self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set jeudicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                        }
            }
        }

        if($walklastday == 1)
                    {

                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set jeudicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set jeudi = jeudi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }

                    if($checkforce == 0)
                    {
            letsgotojapan::$instance->notifyAllPlayers('check','', array(
            
                'id' => $cardid,
                'ville' => 1,
                'check' => $check,
                
                )
                ); 
            }

        }

    if($ville == 2)
    {
        $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        
        $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($walklastday == 0)
        {
        $method = "Kyoto_" . $lastday;
        $check = CardKyoto::$method($this->player_id, 'jeudi'); // A MODIFIER JOUR

        if($check == 1)
            {
                if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }
                self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set jeudicheck = 1  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    ); 
            }

            if($check == 2)
            {
                if(($passportcard == 10)&&($pass10 >=1))
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "ForceJeudi"); //JOUR
                            $checkforce=1;

                        }
                        else
                        {
                self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set jeudicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                        }
            }

        }

        if($walklastday == 1)
                    {

                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set jeudicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set jeudi = jeudi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }
                    if($checkforce == 0)
                    {
        letsgotojapan::$instance->notifyAllPlayers('check','', array(
        
            'id' => $cardid,
            'ville' => 2,
            'check' => $check,
            
            )
            ); 
        }
        
    }     
                
    if($checkforce == 0)
    {

        $finalscore = self::getUniqueValueFromDB( "SELECT jeudi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
            'numero' => $this->player_no,
            'score' => $finalscore,
            'position' => $day,
            'player_name' => $this->player_name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[4]['name'],
            
            )
            );


        //////////////////////////////////////////////////////////////////////////////   
        ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

        if($countplayer == 1)

        {

            $counttrip = letsgotojapan::$instance->CountTrip(0);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

                if ($type != null)
                {
                    $ville = 1;
                
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                self::DbQuery( "UPDATE agent set jeudi = jeudi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',0);
                    }

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',0);
                    }

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',0);
                    }

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',0);
                    }

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',0);
                    }

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',0);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',0);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',0);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',0);
                    }

                }

                
                
                

            }

            if($ville == 1)
                {
                    $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                    $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                    
                    
                    $method = "AgentTokyo_" . $lastday;
                    $check = AgentCardTokyo::$method(0, 'jeudi'); // A MODIFIER JOUR

                    if($check == 1)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set jeudicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set jeudicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                    

                    

                    letsgotojapan::$instance->notifyAllPlayers('check','', array(
                    
                        'id' => $cardid,
                        'ville' => 1,
                        'check' => $check,
                        
                        )
                        ); 

                }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                
                
                $method = "AgentKyoto_" . $lastday;
                $check = AgentCardKyoto::$method(0, 'jeudi'); // A MODIFIER JOUR

                if($check == 1)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set jeudicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                        
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set jeudicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 2,
                    'check' => $check,
                    
                    
                    )
                    ); 
                
            }


            $finalscore = self::getUniqueValueFromDB( "SELECT jeudi FROM agent WHERE name='agent'");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => 2,
                'score' => $finalscore,
                'position' => $day,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[4]['name'],   // changer jour
                
                )
                ); 


            
            }

            ////////////////////////////////////////////////////////////////////////////// 
            ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

        letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendrediWalk"); // à modifier pour aller sur le mardi


        }  
    }



    }




}



//////////////////////// VENDREDI ////////////////////////////

function argFinalStepVendrediWalk($parg1, $parg2)      //changer jour
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        

        
        $found = 0;
        $day = 5; ////////// A CHANGER JOUR
        
            
                for ($position= 1; $position <=4 && $found == 0; $position++)
                {
                    $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardwalk!=null)
                    {
                        $ret["selected3"][] = "card_1_".$tokyocardwalk;
                        $found = 1;
                        break;
                    }

                    else
                    {
                        $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardwalk!=null)
                        {
                            $ret["selected3"][] = "card_2_".$kyotocardwalk;
                            $found = 1;
                            break;
                        }

                    }

                }
            




        if ($ret["selected3"] != null)
        {

            $ret['titleyou'] = clienttranslate('Friday: ${you} must choose a side of the card for this walk <br>');  //changer jour

            $explode = explode('_',$ret["selected3"][0]);
            
            
            if ($explode[1]==1)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_1_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardtokyoverso';
            }

            if ($explode[1]==2)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_2_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardkyotoverso';
            }

            
            
        }

        /*else{

            $ret['titleyou'] = clienttranslate('Friday: ${you} do not have a walk');   ///changer jour
            $ret['buttons'][]='continue';
        }*/

        
        return $ret;
    }

    function FinalStepVendrediWalk($parg1, $parg2, $varg1, $varg2) //changer jour
    {
        $found = 0;
        $day = 5; /// changer numero du jour
        $result = array();
        
        for ($position= 1; $position <=4 && $found == 0; $position++)
            {
                $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                if ($tokyocardwalk!=null)
                {
                    $result[] = "card_1_".$tokyocardwalk;
                    $found = 1;
                    break;
                }

                else
                {
                    $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($kyotocardwalk!=null)
                    {
                        $result[] = "card_2_".$kyotocardwalk;
                        $found = 1;
                        break;
                    }

                }

            }
        


        if(($varg1 == "continue")||($varg1==null))
        {
            /*letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the <b>walks</b> for <b>${day}</b>'), array(
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[5]['name'], // changer numero du jour
                
                )
                );*/
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendredi");   ///changer jour
            
        }

        elseif($varg1 == "cardtokyoverso")
        {
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendrediWalk"); ///changer jour
            
            
            
            
        }
        elseif($varg1 == "cardkyotoverso")
        {
            
            
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendrediWalk"); ///changer jour
            
            
        }

        else
        {
            $explode = explode('_',$result[0]);

            if ($explode[1]==1)
            {

                self::DbQuery( "UPDATE tokyo set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM tokyo WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM tokyo WHERE card_id ={$explode[2]}");
                
                letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                    'cardid' => $result[0],
                    'id' => $explode[2],
                    'ville' => 1,
                    'type' => $type,
                    'location' => $location,
                    'playerid' => $this->player_id,
                    'train' => $typetrain,

                    )
                    );

                letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
            
                    'card' => $result[0],
                    
                    )
                    );

               

                

            }

            if ($explode[1]==2)
            {

                self::DbQuery( "UPDATE kyoto set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM kyoto WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM kyoto WHERE card_id ={$explode[2]}");
                
                    letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                        'cardid' => $result[0],
                        'id' => $explode[2],
                        'ville' => 2,
                        'type' => $type,
                        'location' => $location,
                        'playerid' => $this->player_id,
                        'train' => $typetrain,

                        )
                        );
                    
                    letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
        
                        'card' => $result[0],
                        
                        )
                        );





            }

            //// PASSPORT 18

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 18)
            {
                $scorepassport18 = 0;
                $tokyopass = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );
                $kyotopass = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );

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
                self::DbQuery( "UPDATE player set passportscore = $newscore  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajScorePassport(18,$this->player_id);

            }

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendrediWalk");   ///changer jour

        }

       

    }

function argFinalStepVendredi($parg1, $parg2)
{
    $ret = array();
    $ret["selectable"] = array();
    $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
    $ret["selected"] = array();
    $ret['buttons'] = array();
    

    $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");

    if(($wild >=1)&&($parg1 == 1))
    {
        $ret['titleyou'] = clienttranslate('Friday! Let\'s go! ${you} can use one (or more) <span class="wild"></span>');
        $ret['buttons'][]='yes';
        $ret['buttons'][]='no';
    }
    /*else
    {
        $ret['titleyou'] = clienttranslate('Friday! Let\'s go!');
        $ret['buttons'][]='continue';
    }*/
   
    
 

    return $ret;
}

function FinalStepVendredi($parg1, $parg2, $varg1, $varg2)
{
    $testwild = 0;

        if($parg1 == 2)
        {
            $testwild = 1;
        }

    if($varg1 == "yes")
    {
        letsgotojapan::$instance->addPending($this->player_id, "FinalWild", 5);  // A MODIFIER: dernier chiffre est egal au jour

    }

    if($varg1 == "no")
        {
            $testwild = 1;
        }

    if(($varg1 == "no")||($varg1 == "continue")||($varg1==null))
    {

        letsgotojapan::$instance->notifyAllPlayers('disabled','', array(
        
                               
            )
            );

        $day = 5;  //// A MODIFIER

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
        $countday = $counttrip[$day-1];
        $bonuscard = array();
        $pvcard =0;
        $ville = 0;

        if(($parg1 != 1)&&($parg1 !=2))
        {
            $tableaupassport14 = [0,0,0,0,0];

        for ($i=1; $i<=$countday; $i++)
        {
            $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
            if ($type != null)
            {
                $ville = 1;
                $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if($walk==0)
                {
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                }
                if($walk==1)
                {
                    $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                    $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                }

                $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                }
                if ($train == 2)
                {
                    letsgotojapan::$instance->Gain("h1",$this->player_id);
                }

                $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($finalwalk != 0)
                {
                    self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                }
            }

            else
            {
                $ville = 2;
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if($walk==0)
                {
                    $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                }
                if($walk==1)
                {
                    $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                    $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                }
                $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                }
                if ($train == 2)
                {
                    letsgotojapan::$instance->Gain("h1",$this->player_id);
                }

                $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($finalwalk != 0)
                {
                    self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                }

            }

            self::DbQuery( "UPDATE player set vendredi = vendredi + {$pvcard}   WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR


            if($bonuscard[0]>=1)
            {
                for($token=1; $token<=$bonuscard[0]; $token++)
                {
                    letsgotojapan::$instance->Gain('r',$this->player_id);
                }
                $tableaupassport14[0]=1;

            }

            if($bonuscard[1]>=1)
            {
                for($token=1; $token<=$bonuscard[1]; $token++)
                {
                    letsgotojapan::$instance->Gain('g',$this->player_id);
                }
                $tableaupassport14[1]=1;

            }

            if($bonuscard[2]>=1)
            {
                for($token=1; $token<=$bonuscard[2]; $token++)
                {
                    letsgotojapan::$instance->Gain('p',$this->player_id);
                }
                $tableaupassport14[2]=1;

            }

            if($bonuscard[3]>=1)
            {
                for($token=1; $token<=$bonuscard[3]; $token++)
                {
                    letsgotojapan::$instance->Gain('y',$this->player_id);
                }
                $tableaupassport14[3]=1;

            }

            if($bonuscard[4]>=1)
            {
                for($token=1; $token<=$bonuscard[4]; $token++)
                {
                    letsgotojapan::$instance->Gain('b',$this->player_id);
                }
                $tableaupassport14[4]=1;

            }

            if($bonuscard[5]>=1)
            {
                for($token=1; $token<=$bonuscard[5]; $token++)
                {
                    letsgotojapan::$instance->Gain('h1',$this->player_id);
                }

            }

            if($bonuscard[6]>=1)
            {
                for($token=1; $token<=$bonuscard[6]; $token++)
                {
                    letsgotojapan::$instance->Gain('h2',$this->player_id);
                }

            }

            if($bonuscard[7]>=1)
            {
                for($token=1; $token<=$bonuscard[7]; $token++)
                {
                    letsgotojapan::$instance->Gain('a1',$this->player_id);
                }

            }

            if($bonuscard[8]>=1)
            {
                for($token=1; $token<=$bonuscard[8]; $token++)
                {
                    letsgotojapan::$instance->Gain('a2',$this->player_id);
                }

            }


        }

        $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 14)
            {
                
                // Compter les occurrences de chaque valeur
                $comptage = array_count_values($tableaupassport14);

                // Vérifier combien de fois la valeur 0 apparaît
                $nombreDeZeros = isset($comptage[0]) ? $comptage[0] : 0;

                if($nombreDeZeros <=1)
                {
                    self::DbQuery( "UPDATE player set passportscore = passportscore + 6  WHERE player_id = {$this->player_id}" );
                    letsgotojapan::$instance->MajScorePassport(14,$this->player_id);

                }

            }

        if($testwild == 0)
        {
        $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");
        if($wild >= 1)
        {
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendredi", 1); //Changer le jour
        }
        else
        {
            $testwild = 1;
        }
        }



    }

    if($testwild == 1)
    {
        $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($lastville != null)
        {
            $ville = 1;
        }
        else
        {
            $ville = 2;
        }

        $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
        $savetoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" ); //passport12
        $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");
        $checkforce = 0;  

        if($ville == 1)
        {
            $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            
            $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            if ($walklastday == 0)
            {
            $method = "Tokyo_" . $lastday;
            $check = CardTokyo::$method($this->player_id, 'vendredi'); // A MODIFIER JOUR

            if($check == 1)
            {
                if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }
                self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set vendredicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
            }

            if($check == 2)
            {
                if(($passportcard == 10)&&($pass10 >=1))
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "ForceVendredi"); //JOUR
                            $checkforce=1;

                        }
                        else
                        {
                self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set vendredicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                        }
            }

        }

        if($walklastday == 1)
                    {

                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set vendredicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set vendredi = vendredi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }

                    if($checkforce == 0)
                    {
            letsgotojapan::$instance->notifyAllPlayers('check','', array(
            
                'id' => $cardid,
                'ville' => 1,
                'check' => $check,
                
                )
                ); 
            }

        }

    if($ville == 2)
    {
        $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        
        $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($walklastday == 0)
        {
        $method = "Kyoto_" . $lastday;
        $check = CardKyoto::$method($this->player_id, 'vendredi'); // A MODIFIER JOUR

        if($check == 1)
            {
                if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }
                self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set vendredicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
            }

            if($check == 2)
            {
                if(($passportcard == 10)&&($pass10 >=1))
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "ForceVendredi"); //JOUR
                            $checkforce=1;

                        }
                        else
                        {
                self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set vendredicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                        }
            }

        }

        if($walklastday == 1)
                    {

                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set vendredicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set vendredi = vendredi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }


                    if($checkforce == 0)
                    {
        letsgotojapan::$instance->notifyAllPlayers('check','', array(
        
            'id' => $cardid,
            'ville' => 2,
            'check' => $check,
            
            )
            ); 
        }
        
    }                   
        
    if($checkforce == 0)
    {
        $finalscore = self::getUniqueValueFromDB( "SELECT vendredi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
            'numero' => $this->player_no,
            'score' => $finalscore,
            'position' => $day,
            'player_name' => $this->player_name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[5]['name'],
            
            )
            );


        //////////////////////////////////////////////////////////////////////////////   
        ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

        if($countplayer == 1)

        {

        $counttrip = letsgotojapan::$instance->CountTrip(0);  
        $countday = $counttrip[$day-1];
        $bonuscard = array();
        $pvcard =0;
        $ville = 0;

        for ($i=1; $i<=$countday; $i++)
        {
            $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

            if ($type != null)
            {
                $ville = 1;
            
                $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                

                $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                }
                if ($train == 2)
                {
                    self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                    letsgotojapan::$instance->Smile(1,0);
                }

                
            }

            else
            {
                $ville = 2;
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                
                    $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                
                $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                }
                if ($train == 2)
                {
                    self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                    letsgotojapan::$instance->Smile(1,0);
                }

                
            }

            self::DbQuery( "UPDATE agent set vendredi = vendredi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


            if($bonuscard[0]>=1)
            {
                for($token=1; $token<=$bonuscard[0]; $token++)
                {
                    letsgotojapan::$instance->Gain('r',0);
                }

            }

            if($bonuscard[1]>=1)
            {
                for($token=1; $token<=$bonuscard[1]; $token++)
                {
                    letsgotojapan::$instance->Gain('g',0);
                }

            }

            if($bonuscard[2]>=1)
            {
                for($token=1; $token<=$bonuscard[2]; $token++)
                {
                    letsgotojapan::$instance->Gain('p',0);
                }

            }

            if($bonuscard[3]>=1)
            {
                for($token=1; $token<=$bonuscard[3]; $token++)
                {
                    letsgotojapan::$instance->Gain('y',0);
                }

            }

            if($bonuscard[4]>=1)
            {
                for($token=1; $token<=$bonuscard[4]; $token++)
                {
                    letsgotojapan::$instance->Gain('b',0);
                }

            }

            if($bonuscard[5]>=1)
            {
                for($token=1; $token<=$bonuscard[5]; $token++)
                {
                    letsgotojapan::$instance->Gain('h1',0);
                }

            }

            if($bonuscard[6]>=1)
            {
                for($token=1; $token<=$bonuscard[6]; $token++)
                {
                    letsgotojapan::$instance->Gain('h2',0);
                }

            }

            if($bonuscard[7]>=1)
            {
                for($token=1; $token<=$bonuscard[7]; $token++)
                {
                    letsgotojapan::$instance->Gain('a1',0);
                }

            }

            if($bonuscard[8]>=1)
            {
                for($token=1; $token<=$bonuscard[8]; $token++)
                {
                    letsgotojapan::$instance->Gain('a2',0);
                }

            }

            
            
            

        }

        if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                
                
                $method = "AgentTokyo_" . $lastday;
                $check = AgentCardTokyo::$method(0, 'vendredi'); // A MODIFIER JOUR

                if($check == 1)
                {
                    self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set vendredicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 1,
                        'position' => $day,
                                                    
                        )
                        ); 
                }

                if($check == 2)
                {
                    self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set vendredicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 2,
                        'position' => $day,
                                                    
                        )
                        ); 
                }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 1,
                    'check' => $check,
                    
                    )
                    ); 

            }

        if($ville == 2)
        {
            $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
            $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
            
            
            $method = "AgentKyoto_" . $lastday;
            $check = AgentCardKyoto::$method(0, 'vendredi'); // A MODIFIER JOUR

            if($check == 1)
                {
                    self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set vendredicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 1,
                        'position' => $day,
                                                    
                        )
                        ); 
                    
                }

                if($check == 2)
                {
                    self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set vendredicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 2,
                        'position' => $day,
                                                    
                        )
                        ); 
                }
            

            

            letsgotojapan::$instance->notifyAllPlayers('check','', array(
            
                'id' => $cardid,
                'ville' => 2,
                'check' => $check,
                
                
                )
                ); 
            
        }


        $finalscore = self::getUniqueValueFromDB( "SELECT vendredi FROM agent WHERE name='agent'");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                
            'numero' => 2,
            'score' => $finalscore,
            'position' => $day,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[5]['name'],   // changer jour
            
            )
            ); 


        
        }

        ////////////////////////////////////////////////////////////////////////////// 
        ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamediWalk"); // à modifier pour aller sur le mardi

    }
        
    }


    }




}

//////////////////////// SAMEDI ////////////////////////////

function argFinalStepSamediWalk($parg1, $parg2)      //changer jour
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        

        
        $found = 0;
        $day = 6; ////////// A CHANGER JOUR
        
            
                for ($position= 1; $position <=4 && $found == 0; $position++)
                {
                    $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($tokyocardwalk!=null)
                    {
                        $ret["selected3"][] = "card_1_".$tokyocardwalk;
                        $found = 1;
                        break;
                    }

                    else
                    {
                        $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                        if ($kyotocardwalk!=null)
                        {
                            $ret["selected3"][] = "card_2_".$kyotocardwalk;
                            $found = 1;
                            break;
                        }

                    }

                }
            




        if ($ret["selected3"] != null)
        {

            $ret['titleyou'] = clienttranslate('Saturday: ${you} must choose a side of the card for this walk <br>');  //changer jour

            $explode = explode('_',$ret["selected3"][0]);
            
            
            if ($explode[1]==1)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_1_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardtokyoverso';
            }

            if ($explode[1]==2)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $ret['buttons'][]='cardbouton_2_'.$explode[2].'_'.$type;
                $ret['buttons'][]='cardkyotoverso';
            }

            
            
        }

        /*else{

            $ret['titleyou'] = clienttranslate('Saturday: ${you} do not have a walk');   ///changer jour
            $ret['buttons'][]='continue';
        }*/

        
        return $ret;
    }

    function FinalStepSamediWalk($parg1, $parg2, $varg1, $varg2) //changer jour
    {
        $found = 0;
        $day = 6; /// changer numero du jour
        $result = array();
        
        for ($position= 1; $position <=4 && $found == 0; $position++)
            {
                $tokyocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                if ($tokyocardwalk!=null)
                {
                    $result[] = "card_1_".$tokyocardwalk;
                    $found = 1;
                    break;
                }

                else
                {
                    $kyotocardwalk = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND walk=1 AND finalwalk =0 AND card_location = 'cardposition_{$day}_{$position}'");
                    if ($kyotocardwalk!=null)
                    {
                        $result[] = "card_2_".$kyotocardwalk;
                        $found = 1;
                        break;
                    }

                }

            }
        


        if(($varg1 == "continue")||($varg1==null))
        {
            /*letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the <b>walks</b> for <b>${day}</b>'), array(
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[6]['name'], // changer numero du jour
                
                )
                );*/
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamedi");   ///changer jour
            
        }

        elseif($varg1 == "cardtokyoverso")
        {
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamediWalk"); ///changer jour
            
            
            
            
        }
        elseif($varg1 == "cardkyotoverso")
        {
            
            
            $explode = explode('_',$result[0]);
            self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );

            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamediWalk"); ///changer jour
            
            
        }

        else
        {
            $explode = explode('_',$result[0]);

            if ($explode[1]==1)
            {

                self::DbQuery( "UPDATE tokyo set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM tokyo WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM tokyo WHERE card_id ={$explode[2]}");
                
                letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                    'cardid' => $result[0],
                    'id' => $explode[2],
                    'ville' => 1,
                    'type' => $type,
                    'location' => $location,
                    'playerid' => $this->player_id,
                    'train' => $typetrain,

                    )
                    );

                letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
            
                    'card' => $result[0],
                    
                    )
                    );

               

                

            }

            if ($explode[1]==2)
            {

                self::DbQuery( "UPDATE kyoto set walk = 0  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finalwalk = 1  WHERE card_id = {$explode[2]}" );
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id = {$explode[2]}" );

                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE card_id ={$explode[2]}");
                $location = self::getUniqueValueFromDB( "SELECT card_location location FROM kyoto WHERE card_id ={$explode[2]}");

                $typetrain = self::getUniqueValueFromDB( "SELECT train FROM kyoto WHERE card_id ={$explode[2]}");
                
                    letsgotojapan::$instance->notifyAllPlayers('changecard','', array(
                
                        'cardid' => $result[0],
                        'id' => $explode[2],
                        'ville' => 2,
                        'type' => $type,
                        'location' => $location,
                        'playerid' => $this->player_id,
                        'train' => $typetrain,

                        )
                        );
                    
                    letsgotojapan::$instance->notifyAllPlayers('finalwalk','', array(
        
                        'card' => $result[0],
                        
                        )
                        );





            }

            //// PASSPORT 18

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 18)
            {
                $scorepassport18 = 0;
                $tokyopass = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );
                $kyotopass = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition%'", true );

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
                self::DbQuery( "UPDATE player set passportscore = $newscore  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajScorePassport(18,$this->player_id);

            }

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamediWalk");   ///changer jour

        }

       

    }

function argFinalStepSamedi($parg1, $parg2)
{
    $ret = array();
    $ret["selectable"] = array();
    $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
    $ret["selected"] = array();
    $ret['buttons'] = array();
    

    $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");

    if(($wild >=1)&&($parg1 == 1))
    {
        $ret['titleyou'] = clienttranslate('Saturday! Let\'s go! ${you} can use, <span style="color: red; text-decoration: underline;">for the last time in the game</span>, one (or more) <span class="wild"></span>');
        $ret['buttons'][]='yes';
        $ret['buttons'][]='no';
    }
    /*else
    {
        $ret['titleyou'] = clienttranslate('Saturday! Let\'s go!');
        $ret['buttons'][]='continue';
    }*/
   
    
 

    return $ret;
}

function FinalStepSamedi($parg1, $parg2, $varg1, $varg2)
{
    $testwild = 0;

        if($parg1 == 2)
        {
            $testwild = 1;
        }

    if($varg1 == "yes")
    {
        letsgotojapan::$instance->addPending($this->player_id, "FinalWild", 6);  // A MODIFIER: dernier chiffre est egal au jour

    }

    if($varg1 == "no")
        {
            $testwild = 1;
        }

    if(($varg1 == "no")||($varg1 == "continue")||($varg1==null))
    {
        letsgotojapan::$instance->notifyAllPlayers('disabled','', array(
        
                               
            )
            );

        $day = 6;  //// A MODIFIER

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
        $countday = $counttrip[$day-1];
        $bonuscard = array();
        $pvcard =0;
        $ville = 0;

        if(($parg1 != 1)&&($parg1 !=2))
        {
            $tableaupassport14 = [0,0,0,0,0];

        for ($i=1; $i<=$countday; $i++)
        {
            $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
            if ($type != null)
            {
                $ville = 1;
                $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if($walk==0)
                {
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                }
                if($walk==1)
                {
                    $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                    $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                }

                $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                }
                if ($train == 2)
                {
                    letsgotojapan::$instance->Gain("h1",$this->player_id);
                }

                $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($finalwalk != 0)
                {
                    self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                }
            }

            else
            {
                $ville = 2;
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                $walk = self::getUniqueValueFromDB( "SELECT walk walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if($walk==0)
                {
                    $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                }
                if($walk==1)
                {
                    $bonuscard = letsgotojapan::$instance->walk[0]['bonus'];
                    $pvcard = letsgotojapan::$instance->walk[0]['pv'];
                }
                $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE player set trainday = trainday +1   WHERE player_id = {$this->player_id}" );
                }
                if ($train == 2)
                {
                    letsgotojapan::$instance->Gain("h1",$this->player_id);
                }

                $finalwalk = self::getUniqueValueFromDB( "SELECT finalwalk finalwalk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$i}'");
                if ($finalwalk != 0)
                {
                    self::DbQuery( "UPDATE player set walkday = walkday +1   WHERE player_id = {$this->player_id}" );
                }

            }

            self::DbQuery( "UPDATE player set samedi = samedi + {$pvcard}   WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR


            if($bonuscard[0]>=1)
            {
                for($token=1; $token<=$bonuscard[0]; $token++)
                {
                    letsgotojapan::$instance->Gain('r',$this->player_id);
                }
                $tableaupassport14[0]=1;

            }

            if($bonuscard[1]>=1)
            {
                for($token=1; $token<=$bonuscard[1]; $token++)
                {
                    letsgotojapan::$instance->Gain('g',$this->player_id);
                }
                $tableaupassport14[1]=1;

            }

            if($bonuscard[2]>=1)
            {
                for($token=1; $token<=$bonuscard[2]; $token++)
                {
                    letsgotojapan::$instance->Gain('p',$this->player_id);
                }
                $tableaupassport14[2]=1;

            }

            if($bonuscard[3]>=1)
            {
                for($token=1; $token<=$bonuscard[3]; $token++)
                {
                    letsgotojapan::$instance->Gain('y',$this->player_id);
                }
                $tableaupassport14[3]=1;

            }

            if($bonuscard[4]>=1)
            {
                for($token=1; $token<=$bonuscard[4]; $token++)
                {
                    letsgotojapan::$instance->Gain('b',$this->player_id);
                }
                $tableaupassport14[4]=1;

            }

            if($bonuscard[5]>=1)
            {
                for($token=1; $token<=$bonuscard[5]; $token++)
                {
                    letsgotojapan::$instance->Gain('h1',$this->player_id);
                }

            }

            if($bonuscard[6]>=1)
            {
                for($token=1; $token<=$bonuscard[6]; $token++)
                {
                    letsgotojapan::$instance->Gain('h2',$this->player_id);
                }

            }

            if($bonuscard[7]>=1)
            {
                for($token=1; $token<=$bonuscard[7]; $token++)
                {
                    letsgotojapan::$instance->Gain('a1',$this->player_id);
                }

            }

            if($bonuscard[8]>=1)
            {
                for($token=1; $token<=$bonuscard[8]; $token++)
                {
                    letsgotojapan::$instance->Gain('a2',$this->player_id);
                }

            }


        }

        $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard == 14)
            {
                
                // Compter les occurrences de chaque valeur
                $comptage = array_count_values($tableaupassport14);

                // Vérifier combien de fois la valeur 0 apparaît
                $nombreDeZeros = isset($comptage[0]) ? $comptage[0] : 0;

                if($nombreDeZeros <=1)
                {
                    self::DbQuery( "UPDATE player set passportscore = passportscore + 6  WHERE player_id = {$this->player_id}" );
                    letsgotojapan::$instance->MajScorePassport(14,$this->player_id);

                }

            }


        if($testwild == 0)
        {
        $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");
        if($wild >= 1)
        {
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamedi", 1); //Changer le jour
        }
        else
        {
            $testwild = 1;
        }
        }



    }

    if($testwild == 1)
    {
        $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($lastville != null)
        {
            $ville = 1;
        }
        else
        {
            $ville = 2;
        }

        $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
        $savetoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" ); //passport12
        $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");
        $checkforce = 0;   

        if($ville == 1)
        {
            $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            
            $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
            if ($walklastday == 0)
            {
            $method = "Tokyo_" . $lastday;
            $check = CardTokyo::$method($this->player_id, 'samedi'); // A MODIFIER JOUR

            if($check == 1)
            {
                if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }
                self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set samedicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
            }

            if($check == 2)
            {
                if(($passportcard == 10)&&($pass10 >=1))
                {
                    letsgotojapan::$instance->addPending($this->player_id, "ForceSamedi"); //JOUR
                    $checkforce=1;

                }
                else
                {
                self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set samedicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                        }
            }

        }

        if($walklastday == 1)
        {

            self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
            self::DbQuery( "UPDATE player set samedicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
            letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
        
                'numero' => $this->player_no,
                'check' => 1,
                'position' => $day,
                                            
                )
                ); 

            self::DbQuery( "UPDATE player set samedi = samedi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

            $check = 1;

        }

        if($checkforce == 0)
        {
            letsgotojapan::$instance->notifyAllPlayers('check','', array(
            
                'id' => $cardid,
                'ville' => 1,
                'check' => $check,
                
                )
                ); 
            }

        }

    if($ville == 2)
    {
        $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        
        $walklastday = self::getUniqueValueFromDB( "SELECT walk FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($walklastday == 0)
        {
        
        $method = "Kyoto_" . $lastday;
        $check = CardKyoto::$method($this->player_id, 'samedi'); // A MODIFIER JOUR

        if($check == 1)
            {
                if($passportcard == 12)
                        {
                            $newtoken = self::getObjectListFromDB( "SELECT r r, g g, p p, y y, b b, happy1 happy1, happy2 happy2, angry1 angry1, angry2 angry2, wild wild FROM player WHERE player_id = {$this->player_id}" );
                            $bonusr = $newtoken[0]['r']-$savetoken[0]['r'];
                            for ($i =1; $i <= $bonusr; $i++)
                            {
                                letsgotojapan::$instance->Gain('r',$this->player_id);
                            }
                            $bonusg = $newtoken[0]['g']-$savetoken[0]['g'];
                            for ($i =1; $i <= $bonusg; $i++)
                            {
                                letsgotojapan::$instance->Gain('g',$this->player_id);
                            }
                            $bonusp = $newtoken[0]['p']-$savetoken[0]['p'];
                            for ($i =1; $i <= $bonusp; $i++)
                            {
                                letsgotojapan::$instance->Gain('p',$this->player_id);
                            }
                            $bonusy= $newtoken[0]['y']-$savetoken[0]['y'];
                            for ($i =1; $i <= $bonusy; $i++)
                            {
                                letsgotojapan::$instance->Gain('y',$this->player_id);
                            }
                            $bonusb = $newtoken[0]['b']-$savetoken[0]['b'];
                            for ($i =1; $i <= $bonusb; $i++)
                            {
                                letsgotojapan::$instance->Gain('b',$this->player_id);
                            }
                            $bonushappy1 = $newtoken[0]['happy1']-$savetoken[0]['happy1'];
                            for ($i =1; $i <= $bonushappy1; $i++)
                            {
                                letsgotojapan::$instance->Gain('h1',$this->player_id);
                            }
                            $bonushappy2 = $newtoken[0]['happy2']-$savetoken[0]['happy2'];
                            for ($i =1; $i <= $bonushappy2; $i++)
                            {
                                letsgotojapan::$instance->Gain('h2',$this->player_id);
                            }
                            $bonusangry1 = $newtoken[0]['angry1']-$savetoken[0]['angry1'];
                            for ($i =1; $i <= $bonusangry1; $i++)
                            {
                                letsgotojapan::$instance->Gain('a1',$this->player_id);
                            }
                            $bonusangry2 = $newtoken[0]['angry2']-$savetoken[0]['angry2'];
                            for ($i =1; $i <= $bonusangry2; $i++)
                            {
                                letsgotojapan::$instance->Gain('a2',$this->player_id);
                            }
                            $bonuswild = $newtoken[0]['wild']-$savetoken[0]['wild'];
                            for ($i =1; $i <= $bonuswild; $i++)
                            {
                                self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$this->player_id}" );
                                letsgotojapan::$instance->MajPannel($this->player_id);
                            }
                            
                        }
                self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set samedicheck = 1  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
            }

            if($check == 2)
            {
                if(($passportcard == 10)&&($pass10 >=1))
                {
                    letsgotojapan::$instance->addPending($this->player_id, "ForceSamedi"); //JOUR
                    $checkforce=1;

                }
                else
                {
                self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set samedicheck = 2  WHERE player_id = {$this->player_id}" );
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                        }
            }

        }

        if($walklastday == 1)
                    {

                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );  //// CHANGER LA VILLE
                        self::DbQuery( "UPDATE player set samedicheck = 1  WHERE player_id = {$this->player_id}" );  //// CHANGER LE JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => $this->player_no,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 

                        self::DbQuery( "UPDATE player set samedi = samedi + 2 WHERE player_id = {$this->player_id}" );   //// CHANGER LE JOUR

                        $check = 1;

                    }

                    if($checkforce == 0)
                    {
        letsgotojapan::$instance->notifyAllPlayers('check','', array(
        
            'id' => $cardid,
            'ville' => 2,
            'check' => $check,
            
            )
            ); 
        }
        
    }                    
        
    if($checkforce == 0)
    {
        $finalscore = self::getUniqueValueFromDB( "SELECT samedi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
            'numero' => $this->player_no,
            'score' => $finalscore,
            'position' => $day,
            'player_name' => $this->player_name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[6]['name'],
            
            )
            );


        //////////////////////////////////////////////////////////////////////////////   
        ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

            if($countplayer == 1)

            {

        $counttrip = letsgotojapan::$instance->CountTrip(0);  
        $countday = $counttrip[$day-1];
        $bonuscard = array();
        $pvcard =0;
        $ville = 0;

        for ($i=1; $i<=$countday; $i++)
        {
            $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

            if ($type != null)
            {
                $ville = 1;
            
                $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                

                $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                }
                if ($train == 2)
                {
                    self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                    letsgotojapan::$instance->Smile(1,0);
                }

                
            }

            else
            {
                $ville = 2;
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                
                    $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                
                $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                }
                if ($train == 2)
                {
                    self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                    letsgotojapan::$instance->Smile(1,0);
                }

                
            }

            self::DbQuery( "UPDATE agent set samedi = samedi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


            if($bonuscard[0]>=1)
            {
                for($token=1; $token<=$bonuscard[0]; $token++)
                {
                    letsgotojapan::$instance->Gain('r',0);
                }

            }

            if($bonuscard[1]>=1)
            {
                for($token=1; $token<=$bonuscard[1]; $token++)
                {
                    letsgotojapan::$instance->Gain('g',0);
                }

            }

            if($bonuscard[2]>=1)
            {
                for($token=1; $token<=$bonuscard[2]; $token++)
                {
                    letsgotojapan::$instance->Gain('p',0);
                }

            }

            if($bonuscard[3]>=1)
            {
                for($token=1; $token<=$bonuscard[3]; $token++)
                {
                    letsgotojapan::$instance->Gain('y',0);
                }

            }

            if($bonuscard[4]>=1)
            {
                for($token=1; $token<=$bonuscard[4]; $token++)
                {
                    letsgotojapan::$instance->Gain('b',0);
                }

            }

            if($bonuscard[5]>=1)
            {
                for($token=1; $token<=$bonuscard[5]; $token++)
                {
                    letsgotojapan::$instance->Gain('h1',0);
                }

            }

            if($bonuscard[6]>=1)
            {
                for($token=1; $token<=$bonuscard[6]; $token++)
                {
                    letsgotojapan::$instance->Gain('h2',0);
                }

            }

            if($bonuscard[7]>=1)
            {
                for($token=1; $token<=$bonuscard[7]; $token++)
                {
                    letsgotojapan::$instance->Gain('a1',0);
                }

            }

            if($bonuscard[8]>=1)
            {
                for($token=1; $token<=$bonuscard[8]; $token++)
                {
                    letsgotojapan::$instance->Gain('a2',0);
                }

            }

            
            
            

        }

        if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                
                
                $method = "AgentTokyo_" . $lastday;
                $check = AgentCardTokyo::$method(0, 'samedi'); // A MODIFIER JOUR

                if($check == 1)
                {
                    self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set samedicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 1,
                        'position' => $day,
                                                    
                        )
                        ); 
                }

                if($check == 2)
                {
                    self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set samedicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 2,
                        'position' => $day,
                                                    
                        )
                        ); 
                }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 1,
                    'check' => $check,
                    
                    )
                    ); 

            }

        if($ville == 2)
        {
            $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
            $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
            
            
            $method = "AgentKyoto_" . $lastday;
            $check = AgentCardKyoto::$method(0, 'samedi'); // A MODIFIER JOUR

            if($check == 1)
                {
                    self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set samedicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 1,
                        'position' => $day,
                                                    
                        )
                        ); 
                    
                }

                if($check == 2)
                {
                    self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set samedicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 2,
                        'position' => $day,
                                                    
                        )
                        ); 
                }
            

            

            letsgotojapan::$instance->notifyAllPlayers('check','', array(
            
                'id' => $cardid,
                'ville' => 2,
                'check' => $check,
                
                
                )
                ); 
            
        }


        $finalscore = self::getUniqueValueFromDB( "SELECT samedi FROM agent WHERE name='agent'");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                
            'numero' => 2,
            'score' => $finalscore,
            'position' => $day,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[6]['name'],   // changer jour
            
            )
            ); 


        
         }

        ////////////////////////////////////////////////////////////////////////////// 
        ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        
        


        ///////////////////////// FIN DE SCORING ///////////////////

        $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");


        $scorehumeur =0;
        $lvlhappy = self::getUniqueValueFromDB( "SELECT happy FROM player WHERE player_id = {$this->player_id}");
        if($lvlhappy == 1)
        {
            $scorehumeur = $scorehumeur + 5;
        }

        if($lvlhappy == 2)
        {
            $scorehumeur = $scorehumeur + 12;
        }

        if($lvlhappy == 3)
        {
            $scorehumeur = $scorehumeur + 20;
        }

        $lvlangry = self::getUniqueValueFromDB( "SELECT angry FROM player WHERE player_id = {$this->player_id}");
        
        if($lvlangry == 1)
        {
            $scorehumeur = $scorehumeur - 3;
        }

        if($lvlangry == 2)
        {
            $scorehumeur = $scorehumeur - 8;
        }

        if($lvlangry == 3)
        {
            $scorehumeur = $scorehumeur - 15;
        }

        self::DbQuery( "UPDATE player set scorehumeur = {$scorehumeur} WHERE player_id = {$this->player_id}" );

        if($passportcard == 11)
        {
            self::DbQuery( "UPDATE player set passportscore = $scorehumeur   WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajScorePassport(11,$this->player_id);
        }


        $scoretoken = 0;
        $tableau = array();
        $tableau[] = self::getUniqueValueFromDB( "SELECT r FROM player WHERE player_id = {$this->player_id}");
        $tableau[] = self::getUniqueValueFromDB( "SELECT g FROM player WHERE player_id = {$this->player_id}");
        $tableau[] = self::getUniqueValueFromDB( "SELECT p FROM player WHERE player_id = {$this->player_id}");
        $tableau[] = self::getUniqueValueFromDB( "SELECT y FROM player WHERE player_id = {$this->player_id}");
        $tableau[] = self::getUniqueValueFromDB( "SELECT b FROM player WHERE player_id = {$this->player_id}");

        foreach($tableau as $index)
        {
            if(($index >= 4)&&($index <7))
            {
                $scoretoken = $scoretoken + 4;  
            }

            if(($index >= 7)&&($index <10))
            {
                $scoretoken = $scoretoken + 8;
                if($passportcard == 13)
                {  
                    self::DbQuery( "UPDATE player set passportscore = passportscore +5   WHERE player_id = {$this->player_id}" );
                }
            }

            if(($index >= 10)&&($index <12))
            {
                $scoretoken = $scoretoken + 12;
                if($passportcard == 13)
                {  
                    self::DbQuery( "UPDATE player set passportscore = passportscore +10   WHERE player_id = {$this->player_id}" );
                }  
            }

            if($index >= 12)
            {
                $scoretoken = $scoretoken + 15;
                
                if($passportcard == 13)
                {  
                    self::DbQuery( "UPDATE player set passportscore = passportscore +7  WHERE player_id = {$this->player_id}" );
                } 
            }
        }

        self::DbQuery( "UPDATE player set scoretoken = {$scoretoken} WHERE player_id = {$this->player_id}" );

        if($passportcard == 13)
        {
            
            letsgotojapan::$instance->MajScorePassport(13,$this->player_id);
        }

        if($passportcard == 16)
        {

            // Trouver la plus grosse valeur
            $maxValue = max($tableau);
            
            // Trouver le nombre de valeurs comprises entre 0 et 3 (inclus)
            $valeursEntre0et3 = array_filter($tableau, function($tableau) {
                return $tableau >= 0 && $tableau <= 3;
            });

            $nombreValeursEntre0et3 = count($valeursEntre0et3);

            $score16 = $maxValue + 6*$nombreValeursEntre0et3;
            self::DbQuery( "UPDATE player set passportscore = $score16  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajScorePassport(16,$this->player_id);
        }

        if($passportcard == 17)
        {
        $counttokyocard1 = count(self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_type<=71 AND card_location LIKE 'cardposition%'", true ));
        $counttokyocard2 = count(self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_type>=72 AND walk =1 AND card_location LIKE 'cardposition%'", true ));
        $countkyotocard1 = count(self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_type<=71 AND card_location LIKE 'cardposition%'", true ));
        $countkyotocard2 = count(self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_type>=72 AND walk =1 AND card_location LIKE 'cardposition%'", true ));

        $totaltokyo = $counttokyocard1 + $counttokyocard2;
        $totalkyoto = $countkyotocard1 + $countkyotocard2;

       
        if($totaltokyo == $totalkyoto)
        {
            self::DbQuery( "UPDATE player set passportscore = 14  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajScorePassport(17,$this->player_id);

            
        }
        }

        $scoretrain = 0;
        $counttrainbonustokyo = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND train = 2", true));
        $counttrainbonuskyoto = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND train = 2", true));
        $counttrainmalustokyo = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND train = 3", true));
        $counttrainmaluskyoto = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND train = 3", true));

        $scoretrain = $counttrainbonustokyo*2 + $counttrainbonuskyoto*2 - $counttrainmalustokyo*2 - $counttrainmaluskyoto*2;

        self::DbQuery( "UPDATE player set scoretrain = {$scoretrain} WHERE player_id = {$this->player_id}" );


        $scorerecherche = self::getUniqueValueFromDB( "SELECT passportscore FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT recherche FROM player WHERE player_id = {$this->player_id}");

        self::DbQuery( "UPDATE player set scorerecherche = {$scorerecherche} WHERE player_id = {$this->player_id}" );


        $scoretotal = self::getUniqueValueFromDB( "SELECT lundi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT mardi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT mercredi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT jeudi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT vendredi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT samedi FROM player WHERE player_id = {$this->player_id}") + $scorehumeur + $scoretoken + $scoretrain + $scorerecherche;

        self::DbQuery( "UPDATE player set scoretotal = {$scoretotal} WHERE player_id = {$this->player_id}" );


        
        



        ///////////////////////// FIN DE SCORING POUR AGENT /////////////////// 

        $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

        if($countplayer == 1)

        {

        $scorehumeura =0;
        $lvlhappya = self::getUniqueValueFromDB( "SELECT happy FROM agent WHERE name='agent'");
        if($lvlhappya == 1)
        {
            $scorehumeura = $scorehumeura + 5;
        }

        if($lvlhappya == 2)
        {
            $scorehumeura = $scorehumeura + 12;
        }

        if($lvlhappya == 3)
        {
            $scorehumeura = $scorehumeura + 20;
        }

        $lvlangrya = self::getUniqueValueFromDB( "SELECT angry FROM agent WHERE name='agent'");
        
        if($lvlangrya == 1)
        {
            $scorehumeura = $scorehumeura - 3;
        }

        if($lvlangrya == 2)
        {
            $scorehumeura = $scorehumeura - 8;
        }

        if($lvlangrya == 3)
        {
            $scorehumeura = $scorehumeura - 15;
        }

        self::DbQuery( "UPDATE agent set scorehumeur = {$scorehumeura} WHERE name='agent'" );


        $scoretokena = 0;
        $tableaua = array();
        $tableaua[] = self::getUniqueValueFromDB( "SELECT r FROM agent WHERE name='agent'");
        $tableaua[] = self::getUniqueValueFromDB( "SELECT g FROM agent WHERE name='agent'");
        $tableaua[] = self::getUniqueValueFromDB( "SELECT p FROM agent WHERE name='agent'");
        $tableaua[] = self::getUniqueValueFromDB( "SELECT y FROM agent WHERE name='agent'");
        $tableaua[] = self::getUniqueValueFromDB( "SELECT b FROM agent WHERE name='agent'");

        foreach($tableaua as $indexa)
        {
            if(($indexa >= 4)&&($indexa <7))
            {
                $scoretokena = $scoretokena + 4;  
            }

            if(($indexa >= 7)&&($indexa <10))
            {
                $scoretokena = $scoretokena + 8;  
            }

            if(($indexa >= 10)&&($indexa <12))
            {
                $scoretokena = $scoretokena + 12;  
            }

            if($indexa >= 12)
            {
                $scoretokena = $scoretokena + 15;  
            }
        }

        self::DbQuery( "UPDATE agent set scoretoken = {$scoretokena} WHERE name='agent'" );

        $scoretraina = 0;
        $counttrainbonustokyoa = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = 0 AND train = 2", true));
        $counttrainbonuskyotoa = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = 0 AND train = 2", true));
        

        $scoretraina = $counttrainbonustokyoa*2 + $counttrainbonuskyotoa*2;

        self::DbQuery( "UPDATE agent set scoretrain = {$scoretraina} WHERE name='agent'" );

        $scoretotala = self::getUniqueValueFromDB( "SELECT lundi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT mardi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT mercredi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT jeudi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT vendredi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT samedi FROM agent WHERE name='agent'") + $scorehumeura + $scoretokena + $scoretraina;

        self::DbQuery( "UPDATE agent set scoretotal = {$scoretotala} WHERE name='agent'" );

        
        

        if ($scoretotala > $scoretotal)
        {
            $scoretotalpannel = 0 - $scoretotal;
            self::DbQuery( "UPDATE player set player_score = {$scoretotalpannel} WHERE player_id = {$this->player_id}" );

        }

        if ($scoretotala < $scoretotal)

        {
            $scoretotalpannel = $scoretotal;
            self::DbQuery( "UPDATE player set player_score = {$scoretotalpannel} WHERE player_id = {$this->player_id}" );
        }

        if ($scoretotala == $scoretotal)

        {
            $lvltoken = (self::getUniqueValueFromDB( "SELECT r FROM player WHERE player_id = {$this->player_id}"))+(self::getUniqueValueFromDB( "SELECT g FROM player WHERE player_id = {$this->player_id}"))+(self::getUniqueValueFromDB( "SELECT p FROM player WHERE player_id = {$this->player_id}"))+(self::getUniqueValueFromDB( "SELECT y FROM player WHERE player_id = {$this->player_id}"))+(self::getUniqueValueFromDB( "SELECT b FROM player WHERE player_id = {$this->player_id}"));
            $lvltokena = (self::getUniqueValueFromDB( "SELECT r FROM agent WHERE name='agent'"))+(self::getUniqueValueFromDB( "SELECT g FROM agent WHERE name='agent'"))+(self::getUniqueValueFromDB( "SELECT p FROM agent WHERE name='agent'"))+(self::getUniqueValueFromDB( "SELECT y FROM agent WHERE name='agent'"))+(self::getUniqueValueFromDB( "SELECT b FROM agent WHERE name='agent'"));

            if ($lvltoken >= $lvltokena)
            {
                $scoretotalpannel = $scoretotal;
                self::DbQuery( "UPDATE player set player_score = {$scoretotalpannel} WHERE player_id = {$this->player_id}" );
            }

            if ($lvltoken < $lvltokena)
            {
                $scoretotalpannel = 0 - $scoretotal;
                self::DbQuery( "UPDATE player set player_score = {$scoretotalpannel} WHERE player_id = {$this->player_id}" );
            }


        }





             


        letsgotojapan::$instance->notifyAllPlayers('score2solo',clienttranslate('${player_name} completes the trip to Japan with <b>${total}</b> ${log}'), array(
                
            'numero' => $this->player_no,
            'humeur' => $scorehumeur,
            'token' => $scoretoken,
            'train' => $scoretrain,
            'recherche' => $scorerecherche,
            'total' => $scoretotal,
            'player' => $this->player_id,
            'player_name' => $this->player_name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'pannel' => $scoretotalpannel,
                      
            
            
            )
            );

        letsgotojapan::$instance->notifyAllPlayers('score2agent',clienttranslate('<b>The Travel Agent</b> completes the trip to Japan with <b>${total}</b> ${log}'), array(
            
            'humeur' => $scorehumeura,
            'token' => $scoretokena,
            'train' => $scoretraina,
            'recherche' => 0,
            'total' => $scoretotala,
            'log' => letsgotojapan::$instance->getLogsType(8),
            
                        
            
            
            )
            );

        }

        if($countplayer >=2)

        {
            self::DbQuery( "UPDATE player set player_score = {$scoretotal} WHERE player_id = {$this->player_id}" );

            letsgotojapan::$instance->notifyAllPlayers('score2',clienttranslate('${player_name} completes the trip to Japan with <b>${total}</b> ${log}'), array(
                
                'numero' => $this->player_no,
                'humeur' => $scorehumeur,
                'token' => $scoretoken,
                'train' => $scoretrain,
                'recherche' => $scorerecherche,
                'total' => $scoretotal,
                'player' => $this->player_id,
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(8),
                          
                
                
                )
                );

        }


    
        letsgotojapan::$instance->giveExtraTime($this->player_id);
        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');


        
    }
}


    }




}










    //////////// WILD ////////////////////

    function argFinalWild($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must select the token to advance');

        $ret['buttons'][]='red';
        $ret['buttons'][]='green';
        $ret['buttons'][]='pink';
        $ret['buttons'][]='yellow';
        $ret['buttons'][]='blue';
       
        
     
        $ret['buttons'][]='cancel';
        return $ret;
    }

    function FinalWild($parg1, $parg2, $varg1, $varg2)
    {
        if($varg1 == "cancel")
        {
            if($parg1 == 1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi",1);
            }
            if($parg1 == 2)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardi",1);
            }
            if($parg1 == 3)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercredi",1);
            }
            if($parg1 == 4)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudi",1);
            }
            if($parg1 == 5)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendredi",1);
            }
            if($parg1 == 6)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamedi",1);
            }


        }

        else
        {
            letsgotojapan::$instance->addPending($this->player_id, "ConfirmWild", $varg1, $parg1);
        }
       


    }

    function argConfirmWild($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must confirm <span class="' . $parg1 . '"></span>');

              
        $ret['buttons'][]='confirm';
        $ret['buttons'][]='cancel';
        return $ret;
    }

    function ConfirmWild($parg1, $parg2, $varg1, $varg2)
    {
        if($varg1 == "cancel")
        {
            if($parg2 == 1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi",1);
            }
            if($parg2 == 2)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardi",1);
            }
            if($parg2 == 3)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercredi",1);
            }
            if($parg2 == 4)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudi",1);
            }
            if($parg2 == 5)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendredi",1);
            }
            if($parg2 == 6)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamedi",1);
            }

        }

        

        if($varg1 == "confirm")
        {
            if($parg1 == 'red')
            {
                letsgotojapan::$instance->Gain('r',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses ${log1} and advances ${log2}' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(9),
                    )
                    );
            }
            if($parg1 == 'green')
            {
                letsgotojapan::$instance->Gain('g',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses ${log1} and advances ${log2}' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(10),
                    )
                    );
            }
            if($parg1 == 'pink')
            {
                letsgotojapan::$instance->Gain('p',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses ${log1} and advances ${log2}' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(11),
                    )
                    );
            }
            if($parg1 == 'yellow')
            {
                letsgotojapan::$instance->Gain('y',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses ${log1} and advances ${log2}' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(12),
                    )
                    );
            }
            if($parg1 == 'blue')
            {
                letsgotojapan::$instance->Gain('b',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses ${log1} and advances ${log2}' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(13),
                    )
                    );
                
                $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE player_id = {$this->player_id}");
                if($passportcard == 9)
                {
                    letsgotojapan::$instance->Smile(1,$this->player_id);
                    self::DbQuery( "UPDATE player set passportscore = passportscore +1 WHERE player_id = {$this->player_id}" );
                    letsgotojapan::$instance->MajScorePassport(9,$this->player_id);
                }
            }

            $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");
            if($passportcard!=15)
            {

            self::DbQuery( "UPDATE player set wild = wild -1  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajPannel($this->player_id);

            $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");

            if($wild >=1)
            {
            
            if($parg2 == 1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi",1);
            }
            if($parg2 == 2)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardi",1);
            }
            if($parg2 == 3)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercredi",1);
            }
            if($parg2 == 4)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudi",1);
            }
            if($parg2 == 5)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendredi",1);
            }
            if($parg2 == 6)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamedi",1);
            }
            }

            if($wild == 0)
            {
            
            if($parg2 == 1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi",2);
            }
            if($parg2 == 2)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardi",2);
            }
            if($parg2 == 3)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercredi",2);
            }
            if($parg2 == 4)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudi",2);
            }
            if($parg2 == 5)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendredi",2);
            }
            if($parg2 == 6)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamedi",2);
            }
            }

            }

            if($passportcard==15)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalWildBonus",$parg2, $parg1);
            }



        }
       


    }




    //////////// WILD BONUS////////////////////

    function argFinalWildBonus($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a second token to advance thanks to your passport card');

        if($parg2 != 'red')
        {
            $ret['buttons'][]='red';
        }
        if($parg2 != 'green')
        {
            $ret['buttons'][]='green';
        }
        
        if($parg2 != 'pink')
        {
            $ret['buttons'][]='pink';
        }
        
        if($parg2 != 'yellow')
        {
            $ret['buttons'][]='yellow';
        }
        
        if($parg2 != 'blue')
        {
            $ret['buttons'][]='blue';
        }
        
        
        
        
        
        
       
        
     
        
        return $ret;
    }

    function FinalWildBonus($parg1, $parg2, $varg1, $varg2)
    {
        
            letsgotojapan::$instance->addPending($this->player_id, "ConfirmWildBonus", $varg1.'_'.$parg2, $parg1);
        
       


    }

    function argConfirmWildBonus($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        

        $explode = explode('_',$parg1);

        $ret['titleyou'] = clienttranslate('${you} must confirm <span class="' . $explode[0] . '"></span>');

        $ret['buttons'][]='confirm';
        $ret['buttons'][]='cancel';
        return $ret;
    }

    function ConfirmWildBonus($parg1, $parg2, $varg1, $varg2)
    {
        $explode = explode('_',$parg1);

        if($varg1 == "cancel")
        {
           
                letsgotojapan::$instance->addPending($this->player_id, "FinalWildBonus",$parg2,$explode[1]);
            

        }

        

        if($varg1 == "confirm")
        {
            if($explode[0] == 'red')
            {
                letsgotojapan::$instance->Gain('r',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} advances ${log2} thanks to the passport card' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(9),
                    )
                    );
            }
            if($explode[0] == 'green')
            {
                letsgotojapan::$instance->Gain('g',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} advances ${log2} thanks to the passport card' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(10),
                    )
                    );
            }
            if($explode[0] == 'pink')
            {
                letsgotojapan::$instance->Gain('p',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} advances ${log2} thanks to the passport card' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(11),
                    )
                    );
            }
            if($explode[0] == 'yellow')
            {
                letsgotojapan::$instance->Gain('y',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} advances ${log2} thanks to the passport card' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(12),
                    )
                    );
            }
            if($explode[0] == 'blue')
            {
                letsgotojapan::$instance->Gain('b',$this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} advances ${log2} thanks to the passport card' ), array(
                    'player_name' => $this->player_name,
                    'log1' => letsgotojapan::$instance->getLogsType(3),
                    'log2' => letsgotojapan::$instance->getLogsType(13),
                    )
                    );
            }

            self::DbQuery( "UPDATE player set wild = wild -1  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajPannel($this->player_id);

            $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");

            if($wild >=1)
            {
            
            if($parg2 == 1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi",1);
            }
            if($parg2 == 2)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardi",1);
            }
            if($parg2 == 3)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercredi",1);
            }
            if($parg2 == 4)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudi",1);
            }
            if($parg2 == 5)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendredi",1);
            }
            if($parg2 == 6)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamedi",1);
            }
            }

            if($wild == 0)
            {
            
            if($parg2 == 1)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi",2);
            }
            if($parg2 == 2)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardi",2);
            }
            if($parg2 == 3)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercredi",2);
            }
            if($parg2 == 4)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudi",2);
            }
            if($parg2 == 5)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendredi",2);
            }
            if($parg2 == 6)
            {
                letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamedi",2);
            }
            }



        }
       


    }




    ///////////////////////////////////////////////////////
    //////////////////////// SOLO MODE ////////////////////
    ///////////////////////////////////////////////////////

    function argSoloLevel($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the difficulty level');


        $ret['buttons'][]='easy';
        $ret['buttons'][]='normal';
        $ret['buttons'][]='difficult';
        
        
        
        return $ret;
    }

    function SoloLevel($parg1, $parg2, $varg1, $varg2)
    {
        
        
        if($varg1 == "easy")
        {
            self::DbQuery( "UPDATE agent set sololvl = 1  WHERE name = 'agent'" );

            letsgotojapan::$instance->notifyAllPlayers('infolvl','', array(
                'lvl' => 1,
                'playerid' => $this->player_id,
                )
                );
            
        }

        if($varg1 == "normal")
        {
            self::DbQuery( "UPDATE agent set sololvl = 2  WHERE name = 'agent'" );
            letsgotojapan::$instance->notifyAllPlayers('infolvl','', array(
                'lvl' => 2,
                'playerid' => $this->player_id,
                )
                );
            
        }

        if($varg1 == "difficult")
        {
            self::DbQuery( "UPDATE agent set sololvl = 3  WHERE name = 'agent'" );
            letsgotojapan::$instance->notifyAllPlayers('infolvl','', array(
                'lvl' => 3,
                'playerid' => $this->player_id,
                )
                );
            
        }

        

        letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'playerhand', $this->player_id);
        letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'playerhand', $this->player_id);

        $tokyocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}");
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}");
        
        
        foreach($tokyocard as $card1)
        {
            

        letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
            'id' => $card1['id'],
            'card' => $card1['type'],
            'ville' => 1,
            'playerid' => $this->player_id,
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
            'playerid' => $this->player_id,
            'location' => 'playerhand',
            )
            );
            
        }

               

        letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
 
    }

    function argSoloPhase1Step1($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a card to place or');


        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            $ret["selectable"][] = 'card_1_'.$id1;
        }   

        foreach ($kyotocard as $id2)
        {
            $ret["selectable"][] = 'card_2_'.$id2;
        }

        $ret['buttons'][]='walk';

        if ($this->player_recherche >= 1)
        {
            $ret['buttons'][]='recherche';
        }
        

        
        
        return $ret;
    }

    function SoloPhase1Step1($parg1, $parg2, $varg1, $varg2)
    {
        
        
        if($varg1 == "walk")
        {
            letsgotojapan::$instance->addPending($this->player_id, "SoloWalk");
            
        }

        elseif($varg1 == "recherche")
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "SoloRecherche");
        }

        else
        {
            letsgotojapan::$instance->Deployer($this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step2", $varg1);
        }
        
       
      
    }


    function argSoloPhase1Step2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip (or change card)');

        $ret["selected"][] = $parg1;

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
        $jour = 0;

        foreach ($counttrip as $count)
        {
            $jour = $jour+1;
            if($count == 0)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
            }
            if($count == 1)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
            }
            if($count == 2)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_5_'.$this->player_id;
            }
        }


        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            if ('card_1_'.$id1 != $parg1)
            {
                
                $ret["selectableswitch"][]= 'card_1_'.$id1;

            }
        }   

        foreach ($kyotocard as $id2)
        {
            if ('card_2_'.$id2 != $parg1)
            {
                
                $ret["selectableswitch"][]= 'card_2_'.$id2;

            }
            
        }
       
       
        

        $ret['buttons'][]='cancel';
        


        
        return $ret;
    }

    function SoloPhase1Step2($parg1, $parg2, $varg1, $varg2)
    {
        
        if($varg1 == "cancel")
        {
            
            letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
        }

        elseif (($varg1 != "cancel")&&(strpos($varg1, 'cardposition') !== 0))

        {
                        
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step2", $varg1);
        }
        
        else

        {

            $prefconfirm = self::getUniqueValueFromDB("SELECT valeur FROM prefconfirm WHERE player_id={$this->player_id}");
            if($prefconfirm ==2)
            {

            $explode = explode("_", $parg1);
            $explode2 = explode("_", $varg1);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->tokyocards[$card]['name']);
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->kyotocards[$card]['name']);
            }

           

            letsgotojapan::$instance->notifyAllPlayers('movecard',clienttranslate( '${player_name} places <b>"${name}"</b> on <b>${day}</b>'), array(
                'mobile' =>  $parg1,
                'parent' => $varg1,
                'player_name' => $this->player_name,
                'color' => $this->player_color,
                'id' => $explode[2],
                'ville' => $explode[1],
                'card' => $card,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
            $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
            $counttokyocard = count($tokyocard);
            $countkyotocard = count($kyotocard);

            $positionagent = letsgotojapan::$instance->FirstAgent();

            if ($counttokyocard != 0)
            {
                
                    foreach($tokyocard as $cardid)
                    {
  
                    

                    $type = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$cardid}"); // changer ville

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'cardposition_'.$positionagent, 0 ); // changer ville

                    letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                        'mobile' =>  'card_1_'.$cardid, // a changer
                        'parent' => 'cardposition_'.$positionagent.'_0',
                        'id' => $cardid,
                        'ville' => 1, // a changer
                        'card' => $type,
                        'playerid' => $this->player_id,
                        'location' => 'cardposition_'.$positionagent,
                        
        
                        )
                        );

                    if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id={$cardid}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  'card_1_'.$cardid, // a changer
                            'ville' => 1, // a changer
                            )
                        );*/


                        $card1 = 'card_1_'.$cardid;
                        self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );

                        self::DbQuery( "UPDATE player set yellowpass = 1  WHERE player_id={$this->player_id}" );

                    }

                    else
                    {
                        letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                    }


                    }
                    

            }

            if ($countkyotocard != 0)
            {
                
                    foreach($kyotocard as $cardid)
                    {
                    

                    $type = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$cardid}"); // changer ville

                    letsgotojapan::$instance->kyoto->moveCard( $cardid, 'cardposition_'.$positionagent, 0 ); // changer ville

                    letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                        'mobile' =>  'card_2_'.$cardid, // a changer
                        'parent' => 'cardposition_'.$positionagent.'_0',
                        'id' => $cardid,
                        'ville' => 2, // a changer
                        'card' => $type,
                        'playerid' => $this->player_id,
                        'location' => 'cardposition_'.$positionagent,
                        
        
                        )
                        );

                    if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id={$cardid}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  'card_2_'.$cardid, // a changer
                            'ville' => 2, // a changer
                            )
                        );*/

                        $card1 = 'card_2_'.$cardid;
                        self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );

                        self::DbQuery( "UPDATE player set yellowpass = 1  WHERE player_id={$this->player_id}" );

                    }

                    else
                    {
                        letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                    }



                    }

            }

             
            letsgotojapan::$instance->Condenser($this->player_id, $varg1);


            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
            
            $day = $explode2[1];

            if ($counttrip[$day-1] == 3)
            {
                $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                

                $scorecards = array();

                $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                if ($tokyo != null)
                {
                    foreach ($tokyo as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    }

                }

                if ($tokyowalk != null)
                {
                    foreach ($tokyowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }

                if ($kyoto != null)
                {

                    foreach ($kyoto as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    }
                    
                }

                if ($kyotowalk != null)
                {
                    foreach ($kyotowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }


                $result = array_map(function(...$numbers) {
                    return array_sum($numbers);
                }, ...$scorecards);

                
                if (($colorday>=1)&&($colorday<=5))
                {
                    if($result[$colorday-1]==0)
                    {
                        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
                        
                        if ($yellowpass == 0)
                        {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                        else
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                        }
                    }

                    if($result[$colorday-1]==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);
                        
                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
                        
                        if ($yellowpass == 0)
                        {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                        else
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                        }
                    }

                    if($result[$colorday-1]>=2)
                    {
                       
                        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $result[$colorday-1], $day);
                    }

                }

                if ($colorday == 6)
                {
                    $calculhappy = $result[5]+$result[6];

                    if($calculhappy==0)
                    {
                        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
                        
                        if ($yellowpass == 0)
                        {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                        else
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                        }
                    }

                    if($calculhappy==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);

                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                            $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
                        
                            if ($yellowpass == 0)
                            {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                            else
                            {
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                            }
                    }

                    if($calculhappy>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $calculhappy, $day);
                    }
                    
                }

               
            }

            else
            {
                $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");

                if ($yellowpass == 0)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }

                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }

            }
        }

        if($prefconfirm ==1)
        {
            letsgotojapan::$instance->addPending($this->player_id, "SoloConfirm", $parg1, $varg1);
        }
            
            
        }

    }


    function argSoloConfirm($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();
        
        $ret['titleyou'] = clienttranslate('${you} must confirm');
        
        $ret["selected"][] = $parg1;
        $ret["selected"][] = $parg2;

        $ret['buttons'][]='yes';
        $ret['buttons'][]='no';

                
        return $ret;
    }

    function SoloConfirm($parg1, $parg2, $varg1, $varg2)
    {
        if ($varg1 == 'no')
        {
            letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
        }

        if ($varg1 == 'yes')
        {

            $explode = explode("_", $parg1);
            $explode2 = explode("_", $parg2);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->tokyocards[$card]['name']);
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->kyotocards[$card]['name']);
            }

           

            letsgotojapan::$instance->notifyAllPlayers('movecard',clienttranslate( '${player_name} places <b>"${name}"</b> on <b>${day}</b>'), array(
                'mobile' =>  $parg1,
                'parent' => $parg2,
                'player_name' => $this->player_name,
                'color' => $this->player_color,
                'id' => $explode[2],
                'ville' => $explode[1],
                'card' => $card,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
            $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
            $counttokyocard = count($tokyocard);
            $countkyotocard = count($kyotocard);

            $positionagent = letsgotojapan::$instance->FirstAgent();

            if ($counttokyocard != 0)
            {
                
                    foreach($tokyocard as $cardid)
                    {
  
                    

                    $type = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$cardid}"); // changer ville

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'cardposition_'.$positionagent, 0 ); // changer ville

                    letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                        'mobile' =>  'card_1_'.$cardid, // a changer
                        'parent' => 'cardposition_'.$positionagent.'_0',
                        'id' => $cardid,
                        'ville' => 1, // a changer
                        'card' => $type,
                        'playerid' => $this->player_id,
                        'location' => 'cardposition_'.$positionagent,
                        
        
                        )
                        );

                    if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id={$cardid}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  'card_1_'.$cardid, // a changer
                            'ville' => 1, // a changer
                            )
                        );*/


                        $card1 = 'card_1_'.$cardid;
                        self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );

                        self::DbQuery( "UPDATE player set yellowpass = 1  WHERE player_id={$this->player_id}" );

                    }

                    else
                    {
                        letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                    }


                    }
                    

            }

            if ($countkyotocard != 0)
            {
                
                    foreach($kyotocard as $cardid)
                    {
                    

                    $type = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$cardid}"); // changer ville

                    letsgotojapan::$instance->kyoto->moveCard( $cardid, 'cardposition_'.$positionagent, 0 ); // changer ville

                    letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                        'mobile' =>  'card_2_'.$cardid, // a changer
                        'parent' => 'cardposition_'.$positionagent.'_0',
                        'id' => $cardid,
                        'ville' => 2, // a changer
                        'card' => $type,
                        'playerid' => $this->player_id,
                        'location' => 'cardposition_'.$positionagent,
                        
        
                        )
                        );

                    if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id={$cardid}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  'card_2_'.$cardid, // a changer
                            'ville' => 2, // a changer
                            )
                        );*/

                        $card1 = 'card_2_'.$cardid;
                        self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );

                        self::DbQuery( "UPDATE player set yellowpass = 1  WHERE player_id={$this->player_id}" );

                    }

                    else
                    {
                        letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                    }



                    }

            }

             
            letsgotojapan::$instance->Condenser($this->player_id, $parg2);


            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
            
            $day = $explode2[1];

            if ($counttrip[$day-1] == 3)
            {
                $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                

                $scorecards = array();

                $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                if ($tokyo != null)
                {
                    foreach ($tokyo as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    }

                }

                if ($tokyowalk != null)
                {
                    foreach ($tokyowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }

                if ($kyoto != null)
                {

                    foreach ($kyoto as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    }
                    
                }

                if ($kyotowalk != null)
                {
                    foreach ($kyotowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }


                $result = array_map(function(...$numbers) {
                    return array_sum($numbers);
                }, ...$scorecards);

                
                if (($colorday>=1)&&($colorday<=5))
                {
                    if($result[$colorday-1]==0)
                    {
                        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
                        
                        if ($yellowpass == 0)
                        {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                        else
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                        }
                    }

                    if($result[$colorday-1]==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);
                        
                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
                        
                        if ($yellowpass == 0)
                        {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                        else
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                        }
                    }

                    if($result[$colorday-1]>=2)
                    {
                       
                        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $result[$colorday-1], $day);
                    }

                }

                if ($colorday == 6)
                {
                    $calculhappy = $result[5]+$result[6];

                    if($calculhappy==0)
                    {
                        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
                        
                        if ($yellowpass == 0)
                        {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                        else
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                        }
                    }

                    if($calculhappy==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);

                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                            $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
                        
                            if ($yellowpass == 0)
                            {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                            else
                            {
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                            }
                    }

                    if($calculhappy>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $calculhappy, $day);
                    }
                    
                }

               
            }

            else
            {
                $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");

                if ($yellowpass == 0)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }

                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }

            }

        }
        
        
    }

    ////////////////////// SOLO PASS YELLOW ///////////////////////


    function argSoloPassYellow($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        

        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");

        if($yellowpass == 2)
        {
            $ret['titleyou'] = clienttranslate('${you} can choose a card for your discard pile (passed yellow card) (1/2)');
        }

        if(($yellowpass == 1)&&($parg1 ==1))
        {
            $ret['titleyou'] = clienttranslate('${you} can choose a card for your discard pile (passed yellow card) (2/2)');
        }

        if(($yellowpass == 1)&&($parg1 !=1))
        {
            $ret['titleyou'] = clienttranslate('${you} can choose a card for your discard pile (passed yellow card)');
        }




        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto'; 

        
        
        return $ret;
    }

    function SoloPassYellow($parg1, $parg2, $varg1, $varg2)
    {
          
        if($varg1 == "tokyo")
        {
            letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
            self::DbQuery( "UPDATE player set yellowpass = yellowpass - 1  WHERE player_id={$this->player_id}" );
        }

        if($varg1 == "kyoto")
        {
            letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
            self::DbQuery( "UPDATE player set yellowpass = yellowpass - 1  WHERE player_id={$this->player_id}" );
        }

        if($parg1 !=1)
        {
        letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellowStep2", 1);
        }
        
        if($parg1 ==1)
        {
        letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellowStep2", 2);
        }
        
       
      
    }

    function argSoloPassYellowStep2($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected3"] = array();
        $ret['buttons'] = array();
        
        $ret['titleyou'] = clienttranslate('${you} must choose the location for your opponent\'s yellow card');


        if($parg1 == 1)
        {
        $card = self::getUniqueValueFromDB("SELECT card1 FROM agent WHERE name='agent'");
        $ret["selected3"][] = $card;
        }

        if($parg1 == 2)
        {
        $card = self::getUniqueValueFromDB("SELECT card2 FROM agent WHERE name='agent'");
        $ret["selected3"][] = $card;
        }


        

        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto'; 

        
        
        return $ret;
    }

    function SoloPassYellowStep2($parg1, $parg2, $varg1, $varg2)
    {
        if($parg1 == 1)
        {
            $card = self::getUniqueValueFromDB("SELECT card1 FROM agent WHERE name='agent'"); 
            $explode = explode("_", $card);
            $ville = $explode[1];
            $cardid = $explode[2];
            self::DbQuery( "UPDATE agent set card1 = 0  WHERE name='agent'" );

        }

        if($parg1 == 2)
        {
            $card = self::getUniqueValueFromDB("SELECT card2 FROM agent WHERE name='agent'");
            $explode = explode("_", $card);
            $ville = $explode[1];
            $cardid = $explode[2];
            self::DbQuery( "UPDATE agent set card2 = 0  WHERE name='agent'" );
        }
        
        if($varg1 == "tokyo")
        {
            if($ville == 1)
            {
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id={$cardid}" );
            }

            if($ville == 2)
            {
                self::DbQuery( "UPDATE kyoto set finallocation = 1  WHERE card_id={$cardid}" );
            }

            letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                'card' =>  $card, 
                'ville' => 1, 
                )
            );
            
        }

        if($varg1 == "kyoto")
        {

            if($ville == 1)
            {
                self::DbQuery( "UPDATE tokyo set finallocation = 2  WHERE card_id={$cardid}" );
            }

            if($ville == 2)
            {
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id={$cardid}" );
            }

            letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                'card' =>  $card, 
                'ville' => 2, 
                )
            );
            
        }



        $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;
        
        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");

        if($yellowpass == 0)
        {

            if ($playerhandcount2 == 0)
            {
                
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                
            }

            if ($playerhandcount2 == 3)

            {
                
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            
            }

            if ($playerhandcount2 == 2)
            {
                
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
            
            }
        }

        else

        {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow", 1);

        }

       
        
       
      
    }


    /////////////////////// BONUS JOURNEE //////////////////////////

    function argSoloBonusChoose($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a bonus of the day');

        $ret["selectable"][] = 'bonusjournee_1_'.$this->player_id;
        $ret["selectable"][] = 'bonusjournee_2_'.$this->player_id;
        
        if($parg1 >= 3)
        {
            $ret["selectable"][] = 'bonusjournee_3_'.$this->player_id;
        }

        
        return $ret;
    }

    function SoloBonusChoose($parg1, $parg2, $varg1, $varg2)
    {
        $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

        if ($varg1 === 'bonusjournee_1_' . $this->player_id) 
        {
            letsgotojapan::$instance->Smile(1,$this->player_id);

            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(1),
                )
                );

                $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
            
            if ($playerhandcount2 == 0)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 3)

            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 2)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

        }

        if ($varg1 === 'bonusjournee_2_' . $this->player_id) 
        {
            letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose2", $parg1, $parg2);

        }

        if ($varg1 === 'bonusjournee_3_' . $this->player_id) 
        {
            letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose3", $parg1, $parg2);

        }
        

    }

    function argSoloBonusChoose2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a bonus of the day');

        $ret["selectable"][] = 'bonusjournee_2_1_'.$this->player_id;
        $ret["selectable"][] = 'bonusjournee_2_2_'.$this->player_id;

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function SoloBonusChoose2($parg1, $parg2, $varg1, $varg2)
    {
        $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

        if($varg1 == "cancel")
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $parg1, $parg2);
        }
        
        if ($varg1 === 'bonusjournee_2_1_' . $this->player_id) 
        {
            self::DbQuery( "UPDATE player set recherche = recherche + 2  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajPannel($this->player_id);
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log} ${log}' ), array(
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(2),
                )
                );

                $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
            
            if ($playerhandcount2 == 0)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 3)

            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 2)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

        }

        if ($varg1 === 'bonusjournee_2_2_' . $this->player_id) 
        {
            self::DbQuery( "UPDATE player set wild = wild + 1  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajPannel($this->player_id);
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(3),
                )
                );

                $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
            
            if ($playerhandcount2 == 0)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 3)

            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 2)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

        }
        
        

    }

    function argSoloBonusChoose3($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a bonus of the day');

        $ret["selectable"][] = 'bonusjournee_3_1_'.$this->player_id;
        $ret["selectable"][] = 'bonusjournee_3_2_'.$this->player_id;

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function SoloBonusChoose3($parg1, $parg2, $varg1, $varg2)
    {
        $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
        $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

        if($varg1 == "cancel")
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $parg1, $parg2);
        } 

        if ($varg1 === 'bonusjournee_3_1_' . $this->player_id) 
        {
            self::DbQuery( "UPDATE player set train = train + 1  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajPannel($this->player_id);
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(6),
                )
                );

                $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
            
            if ($playerhandcount2 == 0)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 3)

            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 2)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }


        }

        if ($varg1 === 'bonusjournee_3_2_' . $this->player_id) 
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "SoloExtraWalk", $parg1, $parg2);

        }


       
        

    }

 /////////////////////// WALK ///////////////////


    function argSoloWalk($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the card to discard permanently');

        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            $ret["selectable2"][] = 'card_1_'.$id1;
        }   

        foreach ($kyotocard as $id2)
        {
            $ret["selectable2"][] = 'card_2_'.$id2;
        }        

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function SoloWalk($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            
            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
        }
        else
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "SoloWalkStep2", $varg1);
        } 

              
        

    }

    function argSoloWalkStep2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the location of the walk:');

        $ret["selected"][] = $parg1;

        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        
        $ret['buttons'][]='cancel';
        return $ret;
    }

    function SoloWalkStep2($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            
            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
        }
        else
        {
            letsgotojapan::$instance->Deployer($this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "SoloWalkStep3", $parg1, $varg1);
        } 

              
        

    }

    function argSoloWalkStep3($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["selected2"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip');

        $ret["selected2"][] = $parg1;

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
        $jour = 0;

        foreach ($counttrip as $count)
        {
            $jour = $jour+1;
            if($count == 0)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
            }
            if($count == 1)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
            }
            if($count == 2)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_5_'.$this->player_id;
            }
        }
        
        $ret['buttons'][]='cancel';
        return $ret;
    }

    function SoloWalkStep3($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            if($this->playerhandcount == 2)
            {
                letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
            }
            if($this->playerhandcount == 4)
            {
                letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
            if($this->playerhandcount == 3)
            {
                letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
            
        }
        else
        {
            
            $explode = explode("_", $parg1); /* la carte a defausser*/
            $explode2 = explode("_", $varg1); /* l'emplacement dans le trip*/

            if($explode[1] == 1)
            letsgotojapan::$instance->tokyo->moveCard( $explode[2], 'discard' ); 
            letsgotojapan::$instance->notifyAllPlayers('discard','', array(
                    'carddiscard' => $parg1,
                    'playerid' => $this->player_id,
                       
                    )
                    );

            if($explode[1] == 2)
            letsgotojapan::$instance->kyoto->moveCard( $explode[2], 'discard' ); 
            letsgotojapan::$instance->notifyAllPlayers('discard','', array(
                    'carddiscard' => $parg1,
                    'playerid' => $this->player_id,
                        
                    )
                    );

            $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

            if($parg2 == "tokyo") 
            {
                

                
                letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id);
                $newcardid= self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = '" . $explode2[0] . "_" . $explode2[1] . "_" . $explode2[2] . "'");
                self::DbQuery( "UPDATE tokyo set walk = 1  WHERE card_id ={$newcardid}" );
                self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id ={$newcardid}" );
                letsgotojapan::$instance->notifyAllPlayers('addwalk',clienttranslate( '${player_name} places ${log} on <b>${day}</b>'), array(
                    'parent' => $varg1,
                    'player_name' => $this->player_name,
                    'ville' => 1,
                    'cardid' => $newcardid,
                    'playerid' => $this->player_id,
                    'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                    'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                    'log' => letsgotojapan::$instance->getLogsType(4),
    
                    )
                    );

                    

                    if($playerhandcount2 == 1)
                    {

                    $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                    $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                    $counttokyocard = count($tokyocard);
                    $countkyotocard = count($kyotocard);

                    $positionagent = letsgotojapan::$instance->FirstAgent();
        
                    if ($counttokyocard != 0)
                    {
                
                    foreach($tokyocard as $cardid)
                    {
  
                   

                    $type = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$cardid}"); // changer ville

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'cardposition_'.$positionagent, 0 ); // changer ville

                    letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                        'mobile' =>  'card_1_'.$cardid, // a changer
                        'parent' => 'cardposition_'.$positionagent.'_0',
                        'id' => $cardid,
                        'ville' => 1, // a changer
                        'card' => $type,
                        'playerid' => $this->player_id,
                        'location' => 'cardposition_'.$positionagent,
                        
        
                        )
                        );

                    if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id={$cardid}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  'card_1_'.$cardid, // a changer
                            'ville' => 1, // a changer
                            )
                        );*/

                        $card1 = 'card_1_'.$cardid;
                        self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );
                        self::DbQuery( "UPDATE player set yellowpass = 1  WHERE player_id={$this->player_id}" );

                    }
                    else
                    {
                        letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                    }



                    }
                    

                    }

                    if ($countkyotocard != 0)
                    {
                        
                            foreach($kyotocard as $cardid)
                            {
                            
                            $type = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$cardid}"); // changer ville

                            letsgotojapan::$instance->kyoto->moveCard( $cardid, 'cardposition_'.$positionagent, 0 ); // changer ville

                            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                                'mobile' =>  'card_2_'.$cardid, // a changer
                                'parent' => 'cardposition_'.$positionagent.'_0',
                                'id' => $cardid,
                                'ville' => 2, // a changer
                                'card' => $type,
                                'playerid' => $this->player_id,
                                'location' => 'cardposition_'.$positionagent,
                                
                
                                )
                                );

                            if (($type >=72)&&($type<=80))
                            {
                                /*self::DbQuery( "UPDATE kyoto set finallocation = 1  WHERE card_id={$cardid}" );
                                letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                                    'card' =>  'card_2_'.$cardid, // a changer
                                    'ville' => 2, // a changer
                                    )
                                );*/
                                $card1 = 'card_2_'.$cardid;
                                self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );
                                self::DbQuery( "UPDATE player set yellowpass = 1  WHERE player_id={$this->player_id}" );
        
                            }

                            else
                            {
                                letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                            }



                            }

                    }

                
                

                }

                letsgotojapan::$instance->Condenser($this->player_id, $varg1);

                
            } 



            if($parg2 == "kyoto") 
            {
               


                letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id);
                $newcardid= self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = '" . $explode2[0] . "_" . $explode2[1] . "_" . $explode2[2] . "'");
                self::DbQuery( "UPDATE kyoto set walk = 1  WHERE card_id ={$newcardid}" );
                self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id ={$newcardid}" );
                letsgotojapan::$instance->notifyAllPlayers('addwalk',clienttranslate( '${player_name} places ${log} on <b>${day}</b>'), array(
                    'parent' => $varg1,
                    'player_name' => $this->player_name,
                    'ville' => 2,
                    'cardid' => $newcardid,
                    'playerid' => $this->player_id,
                    'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                    'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                    'log' => letsgotojapan::$instance->getLogsType(4),
    
                    )
                    );

                    
                    if($playerhandcount2 == 1)
                    {

                    $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                    $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
                    $counttokyocard = count($tokyocard);
                    $countkyotocard = count($kyotocard);

                    $positionagent = letsgotojapan::$instance->FirstAgent();
        
                    if ($counttokyocard != 0)
                    {
                
                    foreach($tokyocard as $cardid)
                    {
  
                    
                    $type = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$cardid}"); // changer ville

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'cardposition_'.$positionagent, 0 ); // changer ville

                    letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                        'mobile' =>  'card_1_'.$cardid, // a changer
                        'parent' => 'cardposition_'.$positionagent.'_0',
                        'id' => $cardid,
                        'ville' => 1, // a changer
                        'card' => $type,
                        'playerid' => $this->player_id,
                        'location' => 'cardposition_'.$positionagent,
                        
        
                        )
                        );

                    if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id={$cardid}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  'card_1_'.$cardid, // a changer
                            'ville' => 1, // a changer
                            )
                        );*/

                        $card1 = 'card_1_'.$cardid;
                        self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );

                        self::DbQuery( "UPDATE player set yellowpass = 1  WHERE player_id={$this->player_id}" );


                    }

                    else
                    {
                        letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                    }


                    }
                    

                    }

                    if ($countkyotocard != 0)
                    {
                        
                            foreach($kyotocard as $cardid)
                            {
                            

                            $type = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$cardid}"); // changer ville

                            letsgotojapan::$instance->kyoto->moveCard( $cardid, 'cardposition_'.$positionagent, 0 ); // changer ville

                            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                                'mobile' =>  'card_2_'.$cardid, // a changer
                                'parent' => 'cardposition_'.$positionagent.'_0',
                                'id' => $cardid,
                                'ville' => 2, // a changer
                                'card' => $type,
                                'playerid' => $this->player_id,
                                'location' => 'cardposition_'.$positionagent,
                                
                
                                )
                                );

                                if (($type >=72)&&($type<=80))
                                {
                                    /*self::DbQuery( "UPDATE kyoto set finallocation = 1  WHERE card_id={$cardid}" );
                                    letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                                        'card' =>  'card_2_'.$cardid, // a changer
                                        'ville' => 2, // a changer
                                        )
                                    );*/

                                    $card1 = 'card_2_'.$cardid;
                                    self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );

                                    self::DbQuery( "UPDATE player set yellowpass = 1  WHERE player_id={$this->player_id}" );

            
                                }

                                else
                                {
                                    letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                                }




                            }

                    }

                
                

                }

                
                letsgotojapan::$instance->Condenser($this->player_id, $varg1);

                                

            } 

                
                self::DbQuery( "UPDATE player set recherche = recherche + 1  WHERE player_id = {$this->player_id}" );
                letsgotojapan::$instance->MajPannel($this->player_id);
                letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                    'player_name' => $this->player_name,
                    'log' => letsgotojapan::$instance->getLogsType(2),
                    )
                    );


                $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
                $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
                $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;


                
                $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
                $day = $explode2[1];

                if ($counttrip[$day-1] == 3)
                {
                    $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                    

                    $scorecards = array();

                    $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                    $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                    $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                    $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                    if ($tokyo != null)
                    {
                        foreach ($tokyo as $type)
                        {
                            $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                        }

                    }

                    if ($tokyowalk != null)
                    {
                        foreach ($tokyowalk as $type)
                        {
                            $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                        }

                    }


                    if ($kyoto != null)
                    {

                        foreach ($kyoto as $type)
                        {
                            $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        }
                        
                    }

                    if ($kyotowalk != null)
                    {
                        foreach ($kyotowalk as $type)
                        {
                            $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                        }

                    }

                    $result = array_map(function(...$numbers) {
                        return array_sum($numbers);
                    }, ...$scorecards);

                    
                    if (($colorday>=1)&&($colorday<=5))
                    {
                        if($result[$colorday-1]==0)
                        {
                            if ($playerhandcount2 == 0)
                            {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                            if ($playerhandcount2 == 3)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");

                            }

                            if ($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");

                            }
                        }

                        if($result[$colorday-1]==1)
                        {
                            letsgotojapan::$instance->Smile(1,$this->player_id);
                            
                            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                                'player_name' => $this->player_name,
                                'log' => letsgotojapan::$instance->getLogsType(1),
                                )
                                );
                            
                                if ($playerhandcount2 == 0)
                            {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                            if ($playerhandcount2 == 3)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");

                            }

                            if ($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");

                            }
                        }

                        if($result[$colorday-1]>=2)
                        {
                        
                            letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $result[$colorday-1], $day);
                        }

                    }

                    if ($colorday == 6)
                    {
                        $calculhappy = $result[5]+$result[6];

                        if($calculhappy==0)
                        {
                            if ($playerhandcount2 == 0)
                            {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                            }
                            if ($playerhandcount2 == 3)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");

                            }

                            if ($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");

                            }
                        }

                        if($calculhappy==1)
                        {
                            letsgotojapan::$instance->Smile(1,$this->player_id);

                            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                                'player_name' => $this->player_name,
                                'log' => letsgotojapan::$instance->getLogsType(1),
                                )
                                );

                                if ($playerhandcount2 == 0)
                                {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                                }
                                if ($playerhandcount2 == 3)
                                {
                                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                                    letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
    
                                }
    
                                if ($playerhandcount2 == 2)
                                {
                                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                                    letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
    
                                }
                        }

                        if($calculhappy>=2)
                        {
                            letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $calculhappy, $day);
                        }
                        
                    }

                
                }

                else
                {
                    $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");

                    if ($yellowpass == 0)
                    {
                        if ($playerhandcount2 == 0)
                        {
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                        }
                        if ($playerhandcount2 == 3)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");

                        }

                        if ($playerhandcount2 == 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");

                        }
                    }

                    else
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                    }

                }


            

        }

              
        

    }

    ///////////////////// EXTRA WALK /////////////////////

function argSoloExtraWalk($parg1, $parg2)
{
    $ret = array();
    $ret["selectable"] = array();
    $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
    $ret["selected"] = array();
    $ret['buttons'] = array();
    $ret['titleyou'] = clienttranslate('${you} must choose the location of the extra walk');


    $ret['buttons'][]='tokyo';
    $ret['buttons'][]='kyoto';
    

    $ret['buttons'][]='cancel';
    return $ret;
}

function SoloExtraWalk($parg1, $parg2, $varg1, $varg2)
{

    if($varg1 == "cancel")
    {
        
        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", 3, $parg2);
    } 

    if($varg1 == "tokyo")
    {
        letsgotojapan::$instance->DeployerExtraWalk($this->player_id, $parg2);
        
        letsgotojapan::$instance->addPending($this->player_id, "SoloExtraWalkStep2", 1, $parg2);
    } 

    if($varg1 == "kyoto")
    {
        letsgotojapan::$instance->DeployerExtraWalk($this->player_id, $parg2);
        
        letsgotojapan::$instance->addPending($this->player_id, "SoloExtraWalkStep2", 2, $parg2);
    } 
   

}

function argSoloExtraWalkStep2($parg1, $parg2)
{
    $ret = array();
    $ret["selectable"] = array();
    $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
    $ret["selected"] = array();
    $ret['buttons'] = array();
    $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip for the extra walk');

    $ret["selectable"][] = 'cardposition_'.$parg2.'_1_'.$this->player_id;
    $ret["selectable"][] = 'cardposition_'.$parg2.'_3_'.$this->player_id;
    $ret["selectable"][] = 'cardposition_'.$parg2.'_5_'.$this->player_id;
    $ret["selectable"][] = 'cardposition_'.$parg2.'_7_'.$this->player_id;

    $ret['buttons'][]='cancel';
    return $ret;
}

function SoloExtraWalkStep2($parg1, $parg2, $varg1, $varg2)
{
    $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
    $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
    $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

    if($varg1 == "cancel")
    {
        letsgotojapan::$instance->CondenserExtraWalk($this->player_id, $parg2, 0);
        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", 3, $parg2);
    } 

    else
    {
        
        $explode2 = explode("_", $varg1); /* l'emplacement dans le trip*/


        if($parg1 == 1) 
        {
            

            letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id);
            $newcardid= self::getUniqueValueFromDB("SELECT card_id FROM tokyo WHERE card_location_arg = {$this->player_id} AND card_location = '" . $explode2[0] . "_" . $explode2[1] . "_" . $explode2[2] . "'");
            self::DbQuery( "UPDATE tokyo set walk = 1  WHERE card_id ={$newcardid}" );
            self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id ={$newcardid}" );
            letsgotojapan::$instance->notifyAllPlayers('addwalk',clienttranslate( '${player_name} places an Extra ${log} on <b>${day}</b>'), array(
                'parent' => $varg1,
                'player_name' => $this->player_name,
                'ville' => 1,
                'cardid' => $newcardid,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'log' => letsgotojapan::$instance->getLogsType(4),

                )
                );


        letsgotojapan::$instance->CondenserExtraWalk($this->player_id, $parg2, $varg1);
        }

        if($parg1 == 2) 
        {

            letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id);
            $newcardid= self::getUniqueValueFromDB("SELECT card_id FROM kyoto WHERE card_location_arg = {$this->player_id} AND card_location = '" . $explode2[0] . "_" . $explode2[1] . "_" . $explode2[2] . "'");
            self::DbQuery( "UPDATE kyoto set walk = 1  WHERE card_id ={$newcardid}" );
            self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id ={$newcardid}" );
            letsgotojapan::$instance->notifyAllPlayers('addwalk',clienttranslate( '${player_name} places an Extra ${log} on <b>${day}</b>'), array(
                'parent' => $varg1,
                'player_name' => $this->player_name,
                'ville' => 2,
                'cardid' => $newcardid,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'log' => letsgotojapan::$instance->getLogsType(4),

                )
                );

            
        letsgotojapan::$instance->CondenserExtraWalk($this->player_id, $parg2, $varg1);
        }

        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
            
            if ($playerhandcount2 == 0)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 3)

            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }

            if ($playerhandcount2 == 2)
            {
                if ($yellowpass == 0)
                {
                letsgotojapan::$instance->giveExtraTime($this->player_id);
                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                }
                else
                {
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
                }
            }




    } 

    
   

}





    /////////////////////// RECHERCHE ///////////////////




    function argSoloRecherche($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose your 1st card to draw:');


        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function SoloRecherche($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
        
        } 

        if($varg1 == "tokyo")
        {
            letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);

            
            letsgotojapan::$instance->addPending($this->player_id, "SoloRechercheStep2");
        } 

        if($varg1 == "kyoto")
        {
            letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "SoloRechercheStep2");
        } 


              
        

    }

    function argSoloRechercheStep2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose your 2nd card to draw:');


        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function SoloRechercheStep2($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}", true );
            $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}", true );
            $counttokyocarddiscard = count($tokyocarddiscard);
            $countkyotocarddiscard = count($kyotocarddiscard);

            if ($counttokyocarddiscard != 0)
                {
                    foreach($tokyocarddiscard as $cardid)
                    {

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'discard');
                    }
                        
                }

            if ($countkyotocarddiscard != 0)
                {
                    foreach($kyotocarddiscard as $cardid)
                    {

                    letsgotojapan::$instance->kyoto->moveCard( $cardid, 'discard');
                    }
                        
                }


            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
        } 

        if($varg1 == "tokyo")
        {
            letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "SoloRechercheStep3");
        } 

        if($varg1 == "kyoto")
        {
            letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "SoloRechercheStep3");
        } 


              
        

    }

    function argSoloRechercheStep3($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose your 3rd card to draw:');


        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        

        $ret['buttons'][]='cancel';
        return $ret;
    }

    function SoloRechercheStep3($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "cancel")
        {
            $tokyocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}", true );
            $kyotocarddiscard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}", true );
            $counttokyocarddiscard = count($tokyocarddiscard);
            $countkyotocarddiscard = count($kyotocarddiscard);

            if ($counttokyocarddiscard != 0)
                {
                    foreach($tokyocarddiscard as $cardid)
                    {

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'discard');
                    }
                        
                }

            if ($countkyotocarddiscard != 0)
                {
                    foreach($kyotocarddiscard as $cardid)
                    {

                    letsgotojapan::$instance->kyoto->moveCard( $cardid, 'discard');
                    }
                        
                }


            if($this->playerhandcount == 2)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
            }
            if($this->playerhandcount == 4)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
            if($this->playerhandcount == 3)
            {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
            }
        } 

        if($varg1 == "tokyo")
        {
            letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);

            $tokyonewcard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}");
            $kyotonewcard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}");
            $counttokyonewcard = count($tokyonewcard);
            $countkyotonewcard = count($kyotonewcard);

            
            if ($counttokyonewcard != 0)
                {
                    foreach($tokyonewcard as $card)
                    {
                        letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                            'id' => $card['id'],
                            'card' => $card['type'],
                            'ville' => 1,
                            'playerid' => $this->player_id,
                            'location' => 'playerhand',
            
                            )
                            );
                            
                        self::DbQuery( "UPDATE tokyo set card_location = 'playerhand'  WHERE card_id = {$card['id']}" );
                    }
                        
                }

            if ($countkyotonewcard != 0)
                {
                    foreach($kyotonewcard as $card)
                    {
                        letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                            'id' => $card['id'],
                            'card' => $card['type'],
                            'ville' => 2,
                            'playerid' => $this->player_id,
                            'location' => 'playerhand',
            
                            )
                            );

                        self::DbQuery( "UPDATE kyoto set card_location = 'playerhand'  WHERE card_id = {$card['id']}" );

                    
                    }
                        
                }




            letsgotojapan::$instance->addPending($this->player_id, "SoloRechercheStep4");
        } 

        if($varg1 == "kyoto")
        {
            letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'playernewhand', $this->player_id);

            $tokyonewcard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM tokyo WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}");
            $kyotonewcard = self::getObjectListFromDB( "SELECT card_id id, card_type type FROM kyoto WHERE card_location ='playernewhand' AND card_location_arg = {$this->player_id}");
            $counttokyonewcard = count($tokyonewcard);
            $countkyotonewcard = count($kyotonewcard);

            
            if ($counttokyonewcard != 0)
                {
                    foreach($tokyonewcard as $card)
                    {
                        letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                            'id' => $card['id'],
                            'card' => $card['type'],
                            'ville' => 1,
                            'playerid' => $this->player_id,
                            'location' => 'playerhand',
            
                            )
                            );
                            
                        self::DbQuery( "UPDATE tokyo set card_location = 'playerhand'  WHERE card_id = {$card['id']}" );
                    }
                        
                }

            if ($countkyotonewcard != 0)
                {
                    foreach($kyotonewcard as $card)
                    {
                        letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                            'id' => $card['id'],
                            'card' => $card['type'],
                            'ville' => 2,
                            'playerid' => $this->player_id,
                            'location' => 'playerhand',
            
                            )
                            );

                        self::DbQuery( "UPDATE kyoto set card_location = 'playerhand'  WHERE card_id = {$card['id']}" );

                    
                    }
                        
                }

            letsgotojapan::$instance->addPending($this->player_id, "SoloRechercheStep4");
        } 

    }


    function argSoloRechercheStep4($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the 3 cards to discard');

        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        $select1 = self::getUniqueValueFromDB( "SELECT select1 FROM player WHERE player_id = {$this->player_id}");
        $select2 = self::getUniqueValueFromDB( "SELECT select2 FROM player WHERE player_id = {$this->player_id}");
        $select3 = self::getUniqueValueFromDB( "SELECT select3 FROM player WHERE player_id = {$this->player_id}");
        $selected= [$select1, $select2, $select3];

        $count =0; 

        foreach ($selected as $s)
        {
            if($s != '0')
            {
                $ret["selectable2"][] = $s;
                $count++;
            }


        }

        if($count < 3)
        {
            foreach ($tokyocard as $id1)
            {
                if (!in_array('card_1_'.$id1, $selected))
                {
                $ret["selectableswitch"][] = 'card_1_'.$id1;
                }
            }   

        foreach ($kyotocard as $id2)
            {
                if (!in_array('card_2_'.$id2, $selected))
                {
                $ret["selectableswitch"][] = 'card_2_'.$id2;
                }
            }



        }

        

        $ret['buttons'][]='validate3discard'; 
     

        return $ret;
    }

    function SoloRechercheStep4($parg1, $parg2, $varg1, $varg2)
    {
        
        $select1 = self::getUniqueValueFromDB( "SELECT select1 FROM player WHERE player_id = {$this->player_id}");
        $select2 = self::getUniqueValueFromDB( "SELECT select2 FROM player WHERE player_id = {$this->player_id}");
        $select3 = self::getUniqueValueFromDB( "SELECT select3 FROM player WHERE player_id = {$this->player_id}");
        $selected= [$select1, $select2, $select3];

        if (in_array($varg1, $selected))
        {
            $index = array_search($varg1, $selected);
            $index++;
            self::DbQuery( "UPDATE player set `select{$index}` = '0'  WHERE player_id = {$this->player_id}" );
        }

        else
        {
            
            $index = array_search('0', $selected);
            $index++;
            
            self::DbQuery( "UPDATE player set `select{$index}` = '{$varg1}'  WHERE player_id = {$this->player_id}" );
        }

        letsgotojapan::$instance->addPending($this->player_id, "SoloRechercheStep4");
    }




    /////////////////////// PHASE 2 //////////////////////////
              
        

    function argSoloPhase2Step1($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a card to place or');


        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            $ret["selectable"][] = 'card_1_'.$id1;
        }   

        foreach ($kyotocard as $id2)
        {
            $ret["selectable"][] = 'card_2_'.$id2;
        }

        $ret['buttons'][]='walk';

        if ($this->player_recherche >= 1)
        {
            $ret['buttons'][]='recherche';
        }
        

        
        
        return $ret;
    }

    function SoloPhase2Step1($parg1, $parg2, $varg1, $varg2)
    {
                
        if($varg1 == "walk")
        {
            letsgotojapan::$instance->addPending($this->player_id, "SoloWalk");
            
        }

        elseif($varg1 == "recherche")
        {
            
            letsgotojapan::$instance->addPending($this->player_id, "SoloRecherche");
        }

        else
        {
            letsgotojapan::$instance->Deployer($this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step2", $varg1);
        }
        
       
      
    }

    function argSoloPhase2Step2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip (or change card)');

        $ret["selected"][] = $parg1;

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
        $jour = 0;

        foreach ($counttrip as $count)
        {
            $jour = $jour+1;
            if($count == 0)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
            }
            if($count == 1)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
            }
            if($count == 2)
            {
                $ret["selectable"][] = 'cardposition_'.$jour.'_1_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_3_'.$this->player_id;
                $ret["selectable"][] = 'cardposition_'.$jour.'_5_'.$this->player_id;
            }
        }
        
       
        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            if ('card_1_'.$id1 != $parg1)
            {
                
                $ret["selectableswitch"][]= 'card_1_'.$id1;

            }
        }   

        foreach ($kyotocard as $id2)
        {
            if ('card_2_'.$id2 != $parg1)
            {
                
                $ret["selectableswitch"][]= 'card_2_'.$id2;

            }
            
        }
        

        $ret['buttons'][]='cancel';
        


        
        return $ret;
    }

    function SoloPhase2Step2($parg1, $parg2, $varg1, $varg2)
    {
        
        if($varg1 == "cancel")
        {
            
            letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
        }

        elseif (($varg1 != "cancel")&&(strpos($varg1, 'cardposition') !== 0))

        {
                        
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step2", $varg1);
        }
        
        else

        {
            $prefconfirm = self::getUniqueValueFromDB("SELECT valeur FROM prefconfirm WHERE player_id={$this->player_id}");
            if($prefconfirm ==2)
            {

            $explode = explode("_", $parg1);
            $explode2 = explode("_", $varg1);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->tokyocards[$card]['name']);
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->kyotocards[$card]['name']);
            }

            

            letsgotojapan::$instance->notifyAllPlayers('movecard',clienttranslate( '${player_name} places <b>"${name}"</b> on <b>${day}</b>'), array(
                'mobile' =>  $parg1,
                'parent' => $varg1,
                'player_name' => $this->player_name,
                'color' => $this->player_color,
                'id' => $explode[2],
                'ville' => $explode[1],
                'card' => $card,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

            
            letsgotojapan::$instance->Condenser($this->player_id, $varg1);
            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
            
            $day = $explode2[1];

            

            

            if ($counttrip[$day-1] == 3)
            {
                $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                
                
                $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                if ($tokyo != null)
                {
                    foreach ($tokyo as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    }

                }

                if ($tokyowalk != null)
                {
                    foreach ($tokyowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }

                if ($kyoto != null)
                {

                    foreach ($kyoto as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    }
                    
                }

                if ($kyotowalk != null)
                {
                    foreach ($kyotowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }


                $result = array_map(function(...$numbers) {
                    return array_sum($numbers);
                }, ...$scorecards);

                
                if (($colorday>=1)&&($colorday<=5))
                {
                    if($result[$colorday-1]==0)
                    {
                        if($playerhandcount2 != 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                        }
                        if($playerhandcount2 == 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                        }
                    }

                    if($result[$colorday-1]==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);
                        
                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );
                        
                            if($playerhandcount2 != 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                            }
                            if($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                            }
                    }

                    if($result[$colorday-1]>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $result[$colorday-1], $day);
                    }

                }

                if ($colorday == 6)
                {
                    $calculhappy = $result[5]+$result[6];

                    if($calculhappy==0)
                    {
                        if($playerhandcount2 != 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                        }
                        if($playerhandcount2 == 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                        }
                    }

                    if($calculhappy==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);

                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                            if($playerhandcount2 != 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                            }
                            if($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                            }
                    }

                    if($calculhappy>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $calculhappy, $day);
                    }
                    
                }

               
            }

            else
            {
                if($playerhandcount2 != 2)
                    {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                    }
                if($playerhandcount2 == 2)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                }


            }
        }

        if($prefconfirm ==1)
        {
            letsgotojapan::$instance->addPending($this->player_id, "SoloConfirm2", $parg1, $varg1);
        }
            
            
        }

    }


    function argSoloPhase2Step3($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the first card to pass to the travel agent');


        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            $ret["selectable"][] = 'card_1_'.$id1;
        }   

        foreach ($kyotocard as $id2)
        {
            $ret["selectable"][] = 'card_2_'.$id2;
        }

        
        
        return $ret;
    }

    function SoloPhase2Step3($parg1, $parg2, $varg1, $varg2)
    {

        $explode = explode("_", $varg1);

        $positionagent = letsgotojapan::$instance->FirstAgent(); 
        
        if($explode[1] == 1)
        {
            

            $type = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}"); // changer ville

            letsgotojapan::$instance->tokyo->moveCard( $explode[2], 'cardposition_'.$positionagent, 0 ); // changer ville

            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                'mobile' =>  $varg1, // a changer
                'parent' => 'cardposition_'.$positionagent.'_0',
                'id' => $explode[2],
                'ville' => 1, // a changer
                'card' => $type,
                'playerid' => $this->player_id,
                'location' => 'cardposition_'.$positionagent,
                

                )
                );

                if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id={$explode[2]}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  $varg1, // a changer
                            'ville' => 1, // a changer
                            )
                        );*/

                    $card1 = $varg1;
                    self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );
                    self::DbQuery( "UPDATE player set yellowpass = yellowpass + 1  WHERE player_id={$this->player_id}" );

                    }
                else
                {
                    letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                }

        }

        if($explode[1] == 2)
        {

            
            $type = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}"); // changer ville

            letsgotojapan::$instance->kyoto->moveCard( $explode[2], 'cardposition_'.$positionagent, 0 ); // changer ville

            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                'mobile' =>  $varg1, // a changer
                'parent' => 'cardposition_'.$positionagent.'_0',
                'id' => $explode[2],
                'ville' => 2, // a changer
                'card' => $type,
                'playerid' => $this->player_id,
                'location' => 'cardposition_'.$positionagent,
                

                )
                );

                if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id={$explode[2]}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  $varg1, // a changer
                            'ville' => 2, // a changer
                            )
                        );*/

                        $card1 = $varg1;
                        self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );
                    
                        self::DbQuery( "UPDATE player set yellowpass = yellowpass + 1  WHERE player_id={$this->player_id}" );

                    }

                    else
                    {
                        letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                    }

        }


        $positionagent = letsgotojapan::$instance->FirstAgent(); 
        $carte = array ();
        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            $carte[] = 'card_1_'.$id1;
        }   

        foreach ($kyotocard as $id2)
        {
            $carte[] = 'card_2_'.$id2;
        }

        $explode2 = explode("_", $carte[0]);


        if($explode2[1] == 1)
        {
            

            $type = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode2[2]}"); // changer ville

            letsgotojapan::$instance->tokyo->moveCard( $explode2[2], 'cardposition_'.$positionagent, 0 ); // changer ville

            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                'mobile' =>  'card_1_'.$explode2[2], // a changer
                'parent' => 'cardposition_'.$positionagent.'_0',
                'id' => $explode2[2],
                'ville' => 1, // a changer
                'card' => $type,
                'playerid' => $this->player_id,
                'location' => 'cardposition_'.$positionagent,
                

                )
                );

                if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE tokyo set finallocation = 1  WHERE card_id={$explode2[2]}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  'card_1_'.$explode2[2], // a changer
                            'ville' => 1, // a changer
                            )
                        );*/

                        $card1 = 'card_1_'.$explode2[2];
                        $testcard1 = self::getUniqueValueFromDB("SELECT card1 FROM agent WHERE name='agent'");
                        if($testcard1 == 0)
                        {
                            self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );
                        }
                        else
                        {
                            self::DbQuery( "UPDATE agent set card2 = '$card1'  WHERE name='agent'" );
                        }

                        self::DbQuery( "UPDATE player set yellowpass = yellowpass + 1  WHERE player_id={$this->player_id}" );

                    }
                    else
                    {
                        letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                    }

        }

        if($explode2[1] == 2)
        {

            

            $type = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode2[2]}"); // changer ville

            letsgotojapan::$instance->kyoto->moveCard( $explode2[2], 'cardposition_'.$positionagent, 0 ); // changer ville

            letsgotojapan::$instance->notifyAllPlayers('movecard','', array(
                'mobile' =>  'card_2_'.$explode2[2], // a changer
                'parent' => 'cardposition_'.$positionagent.'_0',
                'id' => $explode2[2],
                'ville' => 2, // a changer
                'card' => $type,
                'playerid' => $this->player_id,
                'location' => 'cardposition_'.$positionagent,
                

                )
                );

                if (($type >=72)&&($type<=80))
                    {
                        /*self::DbQuery( "UPDATE kyoto set finallocation = 2  WHERE card_id={$explode2[2]}" );
                        letsgotojapan::$instance->notifyAllPlayers('finallocation','', array(
                            'card' =>  'card_2_'.$explode2[2], // a changer
                            'ville' => 2, // a changer
                            )
                        );*/

                        $card1 = 'card_2_'.$explode2[2];
                        $testcard1 = self::getUniqueValueFromDB("SELECT card1 FROM agent WHERE name='agent'");
                        if($testcard1 == 0)
                        {
                            self::DbQuery( "UPDATE agent set card1 = '$card1'  WHERE name='agent'" );
                        }
                        else
                        {
                            self::DbQuery( "UPDATE agent set card2 = '$card1'  WHERE name='agent'" );
                        }

                        self::DbQuery( "UPDATE player set yellowpass = yellowpass + 1  WHERE player_id={$this->player_id}" );

                    }

                    else
                    {
                        letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'discardboardhidden', $this->player_id); // changer ville
                    }

        }


        $yellowpass = self::getUniqueValueFromDB("SELECT yellowpass FROM player WHERE player_id={$this->player_id}");
        if($yellowpass == 0)
        {
       
        letsgotojapan::$instance->giveExtraTime($this->player_id);
        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
        }
        else
        {
            letsgotojapan::$instance->addPending($this->player_id, "SoloPassYellow");
        }
       
      
    }









    /////////////////////////// LAST TURN /////////////////////////

    function argSoloLastTurn($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the card to draw:');

        
        $ret['buttons'][]='tokyo';
        $ret['buttons'][]='kyoto';
        
        
        return $ret;
    }

    function SoloLastTurn($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "tokyo")
        {
            
            $newcard = letsgotojapan::$instance->tokyo->pickCardForLocation( 'deck', 'playerhand', $this->player_id);

            letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                'id' =>$newcard['id'],
                'card' => $newcard['type'],
                'ville' => 1,
                'playerid' => $this->player_id,
                'location' => 'playerhand',

                )
                );
                 
            
  
            
            
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
            
        }
        if($varg1 == "kyoto")
        {
            
            $newcard = letsgotojapan::$instance->kyoto->pickCardForLocation( 'deck', 'playerhand', $this->player_id);

            letsgotojapan::$instance->notifyAllPlayers('drawcard','', array(
                'id' =>$newcard['id'],
                'card' => $newcard['type'],
                'ville' => 2,
                'playerid' => $this->player_id,
                'location' => 'playerhand',

                )
                );
                 
            


            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase1Step1");
            
        }
        

              
        

    }


    function argSoloConfirm2($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();
        
        $ret['titleyou'] = clienttranslate('${you} must confirm');
        
        $ret["selected"][] = $parg1;
        $ret["selected"][] = $parg2;

        $ret['buttons'][]='yes';
        $ret['buttons'][]='no';

                
        return $ret;
    }

    function SoloConfirm2($parg1, $parg2, $varg1, $varg2)
    {
        if ($varg1 == 'no')
        {
            letsgotojapan::$instance->Condenser($this->player_id, 0);
            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
        }

        if ($varg1 == 'yes')
        {

            $explode = explode("_", $parg1);
            $explode2 = explode("_", $parg2);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->tokyocards[$card]['name']);
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );

                $name = ucwords(letsgotojapan::$instance->kyotocards[$card]['name']);
            }

            

            letsgotojapan::$instance->notifyAllPlayers('movecard',clienttranslate( '${player_name} places <b>"${name}"</b> on <b>${day}</b>'), array(
                'mobile' =>  $parg1,
                'parent' => $parg2,
                'player_name' => $this->player_name,
                'color' => $this->player_color,
                'id' => $explode[2],
                'ville' => $explode[1],
                'card' => $card,
                'playerid' => $this->player_id,
                'location' => $explode2[0].'_'.$explode2[1].'_'.$explode2[2],
                'day' => letsgotojapan::$instance->days[$explode2[1]]['name'],
                'name' => $name,

                )
                );

            $counthandtokyocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $counthandkyotocard2 = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true ));
            $playerhandcount2 = $counthandtokyocard2 + $counthandkyotocard2;

            
            letsgotojapan::$instance->Condenser($this->player_id, $parg2);
            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
            
            $day = $explode2[1];

            

            

            if ($counttrip[$day-1] == 3)
            {
                $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                
                
                $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =0 AND card_location LIKE 'cardposition_{$day}%'", true );
                $tokyowalk = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyotowalk = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND walk =1 AND card_location LIKE 'cardposition_{$day}%'", true );

                if ($tokyo != null)
                {
                    foreach ($tokyo as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    }

                }

                if ($tokyowalk != null)
                {
                    foreach ($tokyowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }

                if ($kyoto != null)
                {

                    foreach ($kyoto as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    }
                    
                }

                if ($kyotowalk != null)
                {
                    foreach ($kyotowalk as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->walk[0]['bonus'];
                    }

                }


                $result = array_map(function(...$numbers) {
                    return array_sum($numbers);
                }, ...$scorecards);

                
                if (($colorday>=1)&&($colorday<=5))
                {
                    if($result[$colorday-1]==0)
                    {
                        if($playerhandcount2 != 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                        }
                        if($playerhandcount2 == 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                        }
                    }

                    if($result[$colorday-1]==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);
                        
                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );
                        
                            if($playerhandcount2 != 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                            }
                            if($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                            }
                    }

                    if($result[$colorday-1]>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $result[$colorday-1], $day);
                    }

                }

                if ($colorday == 6)
                {
                    $calculhappy = $result[5]+$result[6];

                    if($calculhappy==0)
                    {
                        if($playerhandcount2 != 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                        }
                        if($playerhandcount2 == 2)
                        {
                            letsgotojapan::$instance->giveExtraTime($this->player_id);
                            letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                        }
                    }

                    if($calculhappy==1)
                    {
                        letsgotojapan::$instance->Smile(1,$this->player_id);

                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
                            'player_name' => $this->player_name,
                            'log' => letsgotojapan::$instance->getLogsType(1),
                            )
                            );

                            if($playerhandcount2 != 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                            }
                            if($playerhandcount2 == 2)
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                            }
                    }

                    if($calculhappy>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "SoloBonusChoose", $calculhappy, $day);
                    }
                    
                }

               
            }

            else
            {
                if($playerhandcount2 != 2)
                    {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step1");
                    }
                if($playerhandcount2 == 2)
                {
                    letsgotojapan::$instance->giveExtraTime($this->player_id);
                    letsgotojapan::$instance->addPending($this->player_id, "SoloPhase2Step3");
                }


            }

        }
        
        
    }


    ////////////////  PASSPORT EXTENSION  ////////////////////


    function argPassport1($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();
        
        $ret['titleyou'] = clienttranslate('${you} must choose your Passport card');

        $passport = self::getObjectListFromDB( "SELECT card_type type FROM passport WHERE  card_location_arg = {$this->player_id}", true );
        
        foreach ($passport as $type)
        {
        $ret["selectable"][] = 'passportcard_'.$type.'_'.$this->player_id;
        }

                
        return $ret;
    }

    function Passport1($parg1, $parg2, $varg1, $varg2)
    {

        letsgotojapan::$instance->addPending($this->player_id, "Passport2", $varg1);

    }


    function argPassport2($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();
        
        $ret['titleyou'] = clienttranslate('${you} must confirm');

        $ret["selected"][] = $parg1;
        
        $ret["buttons"][] = 'yes';
        $ret["buttons"][] = 'no';
        

                
        return $ret;
    }

    function Passport2($parg1, $parg2, $varg1, $varg2)
    {
        if($varg1 == 'no')
        {
        letsgotojapan::$instance->addPending($this->player_id, "Passport1");
        }

        if($varg1 == 'yes')
        {


        

        $explode = explode('_', $parg1);
        self::DbQuery( "UPDATE player set passportcard = '$explode[1]' WHERE player_id = {$this->player_id}" );
        
        $noid = self::getUniqueValueFromDB("SELECT card_id FROM passport WHERE card_type !={$explode[1]} AND card_location_arg = {$this->player_id}");
        $notype = self::getUniqueValueFromDB("SELECT card_type FROM passport WHERE card_type !={$explode[1]} AND card_location_arg = {$this->player_id}");
        
        letsgotojapan::$instance->passport->moveCard( $noid, 'discard' ); 

         letsgotojapan::$instance->notifyAllPlayers('passportchoix','', array(
        'player_id' => $this->player_id,
        'type' => $notype,
        )
        );

        letsgotojapan::$instance->giveExtraTime($this->player_id);
        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');


        }

    }


    ////////////////  PASSPORT CARD 10  ////////////////////


    function argForceLundi($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();

        $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");

        if($pass10 == 2)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (1/2)');
        }

        if($pass10 == 1)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (2/2)');
        }
        
        

        
        
        $ret["buttons"][] = 'yes';
        $ret["buttons"][] = 'no';
        

                
        return $ret;
    }

    function ForceLundi($parg1, $parg2, $varg1, $varg2)
    {

        $day = 1;  //// A MODIFIER

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
        $countday = $counttrip[$day-1];
        $ville = 0;

        $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($lastville != null)
        {
            $ville = 1;
        }
        else
        {
            $ville = 2;
        }

        if($varg1 == 'no')
        {
            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set lundicheck = 2  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set lundicheck = 2  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 2,
                
                
                )
                );


        }

        if($varg1 == 'yes')
        {
            self::DbQuery( "UPDATE player set pass10 = pass10 - 1  WHERE player_id = {$this->player_id}" );

            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Tokyo_" . $lastday;
                CardTokyo::$method($this->player_id, 'lundi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set lundicheck = 1  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Kyoto_" . $lastday;
                CardKyoto::$method($this->player_id, 'lundi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set lundicheck = 1  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 1,
                
                
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses the passport card to force the <b>${day}</b> bonus'), array(
                
                
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[1]['name'],   // A MODIFIER JOUR
                
                )
                );


        }



        ///////////////////////////////////////////////
        ////////////////////////////////////////////////
        ////////////////////////////////////////////////

        $finalscore = self::getUniqueValueFromDB( "SELECT lundi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => $this->player_no,
                'score' => $finalscore,
                'position' => $day,
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[1]['name'],   // changer jour
                
                )
                );     
                
            //////////////////////////////////////////////////////////////////////////////   
            ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

            if($countplayer == 1)

            {


            $counttrip = letsgotojapan::$instance->CountTrip(0);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

                if ($type != null)
                {
                    $ville = 1;
                
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                self::DbQuery( "UPDATE agent set lundi = lundi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',0);
                    }

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',0);
                    }

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',0);
                    }

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',0);
                    }

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',0);
                    }

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',0);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',0);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',0);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',0);
                    }

                }

                
                
                

            }

            if($ville == 1)
                {
                    $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                    $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                    
                    
                    $method = "AgentTokyo_" . $lastday;
                    $check = AgentCardTokyo::$method(0, 'lundi'); // A MODIFIER JOUR

                    if($check == 1)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set lundicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set lundicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                    

                    

                    letsgotojapan::$instance->notifyAllPlayers('check','', array(
                    
                        'id' => $cardid,
                        'ville' => 1,
                        'check' => $check,
                        
                        )
                        ); 

                }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                
                
                $method = "AgentKyoto_" . $lastday;
                $check = AgentCardKyoto::$method(0, 'lundi'); // A MODIFIER JOUR

                if($check == 1)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set lundicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                        
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set lundicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 2,
                    'check' => $check,
                    
                    
                    )
                    ); 
                
            }


            $finalscore = self::getUniqueValueFromDB( "SELECT lundi FROM agent WHERE name='agent'");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => 2,
                'score' => $finalscore,
                'position' => $day,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[1]['name'],   // changer jour
                
                )
                ); 


            
            }

            ////////////////////////////////////////////////////////////////////////////// 
            ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 
            

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMardiWalk"); // à modifier pour aller sur le mardi

        

    }

    function argForceMardi($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();

        $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");

        if($pass10 == 2)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (1/2)');
        }

        if($pass10 == 1)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (2/2)');
        }
        
        

        
        
        $ret["buttons"][] = 'yes';
        $ret["buttons"][] = 'no';
        

                
        return $ret;
    }


    function ForceMardi($parg1, $parg2, $varg1, $varg2)
    {

        $day = 2;  //// A MODIFIER

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
        $countday = $counttrip[$day-1];
        $ville = 0;

        $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($lastville != null)
        {
            $ville = 1;
        }
        else
        {
            $ville = 2;
        }

        if($varg1 == 'no')
        {
            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set mardicheck = 2  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set mardicheck = 2  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 2,
                
                
                )
                );


        }

        if($varg1 == 'yes')
        {
            self::DbQuery( "UPDATE player set pass10 = pass10 - 1  WHERE player_id = {$this->player_id}" );

            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Tokyo_" . $lastday;
                CardTokyo::$method($this->player_id, 'mardi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set mardicheck = 1  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Kyoto_" . $lastday;
                CardKyoto::$method($this->player_id, 'mardi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set mardicheck = 1  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 1,
                
                
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses the passport card to force the <b>${day}</b> bonus'), array(
                
                
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[2]['name'],   // A MODIFIER JOUR
                
                )
                );


        }



        ///////////////////////////////////////////////
        ////////////////////////////////////////////////
        ////////////////////////////////////////////////

        $finalscore = self::getUniqueValueFromDB( "SELECT mardi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => $this->player_no,
                'score' => $finalscore,
                'position' => $day,
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[2]['name'],
                
                )
                ); 



            //////////////////////////////////////////////////////////////////////////////   
            ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

            if($countplayer == 1)

            {

            $counttrip = letsgotojapan::$instance->CountTrip(0);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

                if ($type != null)
                {
                    $ville = 1;
                
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                self::DbQuery( "UPDATE agent set mardi = mardi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',0);
                    }

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',0);
                    }

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',0);
                    }

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',0);
                    }

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',0);
                    }

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',0);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',0);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',0);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',0);
                    }

                }

                
                
                

            }

            if($ville == 1)
                {
                    $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                    $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                    
                    
                    $method = "AgentTokyo_" . $lastday;
                    $check = AgentCardTokyo::$method(0, 'mardi'); // A MODIFIER JOUR

                    if($check == 1)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mardicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mardicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                    

                    

                    letsgotojapan::$instance->notifyAllPlayers('check','', array(
                    
                        'id' => $cardid,
                        'ville' => 1,
                        'check' => $check,
                        
                        )
                        ); 

                }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                
                
                $method = "AgentKyoto_" . $lastday;
                $check = AgentCardKyoto::$method(0, 'mardi'); // A MODIFIER JOUR

                if($check == 1)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mardicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                        
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mardicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 2,
                    'check' => $check,
                    
                    
                    )
                    ); 
                
            }


            $finalscore = self::getUniqueValueFromDB( "SELECT mardi FROM agent WHERE name='agent'");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => 2,
                'score' => $finalscore,
                'position' => $day,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[2]['name'],   // changer jour
                
                )
                ); 


            
            }

            ////////////////////////////////////////////////////////////////////////////// 
            ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepMercrediWalk"); // à modifier pour aller sur le mardi


    }


    function argForceMercredi($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();

        $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");

        if($pass10 == 2)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (1/2)');
        }

        if($pass10 == 1)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (2/2)');
        }
        
        

        
        
        $ret["buttons"][] = 'yes';
        $ret["buttons"][] = 'no';
        

                
        return $ret;
    }


    function ForceMercredi($parg1, $parg2, $varg1, $varg2)
    {

        $day = 3;  //// A MODIFIER

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
        $countday = $counttrip[$day-1];
        $ville = 0;

        $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($lastville != null)
        {
            $ville = 1;
        }
        else
        {
            $ville = 2;
        }

        if($varg1 == 'no')
        {
            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set mercredicheck = 2  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set mercredicheck = 2  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 2,
                
                
                )
                );


        }

        if($varg1 == 'yes')
        {
            self::DbQuery( "UPDATE player set pass10 = pass10 - 1  WHERE player_id = {$this->player_id}" );

            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Tokyo_" . $lastday;
                CardTokyo::$method($this->player_id, 'mercredi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set mercredicheck = 1  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Kyoto_" . $lastday;
                CardKyoto::$method($this->player_id, 'mercredi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set mercredicheck = 1  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 1,
                
                
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses the passport card to force the <b>${day}</b> bonus'), array(
                
                
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[3]['name'],   // A MODIFIER JOUR
                
                )
                );


        }



        ///////////////////////////////////////////////
        ////////////////////////////////////////////////
        ////////////////////////////////////////////////

        $finalscore = self::getUniqueValueFromDB( "SELECT mercredi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => $this->player_no,
                'score' => $finalscore,
                'position' => $day,
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[3]['name'],
                
                )
                );

            //////////////////////////////////////////////////////////////////////////////   
            ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

            if($countplayer == 1)

            {

            $counttrip = letsgotojapan::$instance->CountTrip(0);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

                if ($type != null)
                {
                    $ville = 1;
                
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                self::DbQuery( "UPDATE agent set mercredi = mercredi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',0);
                    }

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',0);
                    }

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',0);
                    }

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',0);
                    }

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',0);
                    }

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',0);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',0);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',0);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',0);
                    }

                }

                
                
                

            }

            if($ville == 1)
                {
                    $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                    $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                    
                    
                    $method = "AgentTokyo_" . $lastday;
                    $check = AgentCardTokyo::$method(0, 'mercredi'); // A MODIFIER JOUR

                    if($check == 1)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mercredicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mercredicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                    

                    

                    letsgotojapan::$instance->notifyAllPlayers('check','', array(
                    
                        'id' => $cardid,
                        'ville' => 1,
                        'check' => $check,
                        
                        )
                        ); 

                }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                
                
                $method = "AgentKyoto_" . $lastday;
                $check = AgentCardKyoto::$method(0, 'mercredi'); // A MODIFIER JOUR

                if($check == 1)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mercredicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                        
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set mercredicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 2,
                    'check' => $check,
                    
                    
                    )
                    ); 
                
            }


            $finalscore = self::getUniqueValueFromDB( "SELECT mercredi FROM agent WHERE name='agent'");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => 2,
                'score' => $finalscore,
                'position' => $day,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[3]['name'],   // changer jour
                
                )
                ); 


            
            }

            ////////////////////////////////////////////////////////////////////////////// 
            ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

            letsgotojapan::$instance->addPending($this->player_id, "FinalStepJeudiWalk"); // à modifier pour aller sur le mardi


    }

    function argForceJeudi($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();

        $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");

        if($pass10 == 2)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (1/2)');
        }

        if($pass10 == 1)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (2/2)');
        }
        
        

        
        
        $ret["buttons"][] = 'yes';
        $ret["buttons"][] = 'no';
        

                
        return $ret;
    }


    function ForceJeudi($parg1, $parg2, $varg1, $varg2)
    {

        $day = 4;  //// A MODIFIER

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
        $countday = $counttrip[$day-1];
        $ville = 0;

        $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($lastville != null)
        {
            $ville = 1;
        }
        else
        {
            $ville = 2;
        }

        if($varg1 == 'no')
        {
            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set jeudicheck = 2  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set jeudicheck = 2  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 2,
                
                
                )
                );


        }

        if($varg1 == 'yes')
        {
            self::DbQuery( "UPDATE player set pass10 = pass10 - 1  WHERE player_id = {$this->player_id}" );

            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Tokyo_" . $lastday;
                CardTokyo::$method($this->player_id, 'jeudi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set jeudicheck = 1  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Kyoto_" . $lastday;
                CardKyoto::$method($this->player_id, 'jeudi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set jeudicheck = 1  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 1,
                
                
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses the passport card to force the <b>${day}</b> bonus'), array(
                
                
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[4]['name'],   // A MODIFIER JOUR
                
                )
                );


        }



        ///////////////////////////////////////////////
        ////////////////////////////////////////////////
        ////////////////////////////////////////////////

        $finalscore = self::getUniqueValueFromDB( "SELECT jeudi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
            'numero' => $this->player_no,
            'score' => $finalscore,
            'position' => $day,
            'player_name' => $this->player_name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[4]['name'],
            
            )
            );


        //////////////////////////////////////////////////////////////////////////////   
        ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

        if($countplayer == 1)

        {

            $counttrip = letsgotojapan::$instance->CountTrip(0);  
            $countday = $counttrip[$day-1];
            $bonuscard = array();
            $pvcard =0;
            $ville = 0;

            for ($i=1; $i<=$countday; $i++)
            {
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

                if ($type != null)
                {
                    $ville = 1;
                
                    $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                    

                    $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                else
                {
                    $ville = 2;
                    $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    
                        $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                        $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                    
                    $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                    if ($train != 0)
                    {
                        self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                    }
                    if ($train == 2)
                    {
                        self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                        letsgotojapan::$instance->Smile(1,0);
                    }

                    
                }

                self::DbQuery( "UPDATE agent set jeudi = jeudi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


                if($bonuscard[0]>=1)
                {
                    for($token=1; $token<=$bonuscard[0]; $token++)
                    {
                        letsgotojapan::$instance->Gain('r',0);
                    }

                }

                if($bonuscard[1]>=1)
                {
                    for($token=1; $token<=$bonuscard[1]; $token++)
                    {
                        letsgotojapan::$instance->Gain('g',0);
                    }

                }

                if($bonuscard[2]>=1)
                {
                    for($token=1; $token<=$bonuscard[2]; $token++)
                    {
                        letsgotojapan::$instance->Gain('p',0);
                    }

                }

                if($bonuscard[3]>=1)
                {
                    for($token=1; $token<=$bonuscard[3]; $token++)
                    {
                        letsgotojapan::$instance->Gain('y',0);
                    }

                }

                if($bonuscard[4]>=1)
                {
                    for($token=1; $token<=$bonuscard[4]; $token++)
                    {
                        letsgotojapan::$instance->Gain('b',0);
                    }

                }

                if($bonuscard[5]>=1)
                {
                    for($token=1; $token<=$bonuscard[5]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h1',0);
                    }

                }

                if($bonuscard[6]>=1)
                {
                    for($token=1; $token<=$bonuscard[6]; $token++)
                    {
                        letsgotojapan::$instance->Gain('h2',0);
                    }

                }

                if($bonuscard[7]>=1)
                {
                    for($token=1; $token<=$bonuscard[7]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a1',0);
                    }

                }

                if($bonuscard[8]>=1)
                {
                    for($token=1; $token<=$bonuscard[8]; $token++)
                    {
                        letsgotojapan::$instance->Gain('a2',0);
                    }

                }

                
                
                

            }

            if($ville == 1)
                {
                    $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                    $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                    
                    
                    $method = "AgentTokyo_" . $lastday;
                    $check = AgentCardTokyo::$method(0, 'jeudi'); // A MODIFIER JOUR

                    if($check == 1)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set jeudicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set jeudicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                    

                    

                    letsgotojapan::$instance->notifyAllPlayers('check','', array(
                    
                        'id' => $cardid,
                        'ville' => 1,
                        'check' => $check,
                        
                        )
                        ); 

                }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                
                
                $method = "AgentKyoto_" . $lastday;
                $check = AgentCardKyoto::$method(0, 'jeudi'); // A MODIFIER JOUR

                if($check == 1)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set jeudicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 1,
                            'position' => $day,
                                                        
                            )
                            ); 
                        
                    }

                    if($check == 2)
                    {
                        self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                        self::DbQuery( "UPDATE agent set jeudicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                        letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                    
                            'numero' => 2,
                            'check' => 2,
                            'position' => $day,
                                                        
                            )
                            ); 
                    }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 2,
                    'check' => $check,
                    
                    
                    )
                    ); 
                
            }


            $finalscore = self::getUniqueValueFromDB( "SELECT jeudi FROM agent WHERE name='agent'");   /// CHANGER JOUR
            letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                    
                'numero' => 2,
                'score' => $finalscore,
                'position' => $day,
                'log' => letsgotojapan::$instance->getLogsType(8),
                'day' => letsgotojapan::$instance->days[4]['name'],   // changer jour
                
                )
                ); 


            
            }

            ////////////////////////////////////////////////////////////////////////////// 
            ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
            ////////////////////////////////////////////////////////////////////////////// 

        letsgotojapan::$instance->addPending($this->player_id, "FinalStepVendrediWalk"); // à modifier pour aller sur le mardi


    }

    function argForceVendredi($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();

        $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");

        if($pass10 == 2)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (1/2)');
        }

        if($pass10 == 1)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (2/2)');
        }
        
        

        
        
        $ret["buttons"][] = 'yes';
        $ret["buttons"][] = 'no';
        

                
        return $ret;
    }


    function ForceVendredi($parg1, $parg2, $varg1, $varg2)
    {

        $day = 5;  //// A MODIFIER

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
        $countday = $counttrip[$day-1];
        $ville = 0;

        $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($lastville != null)
        {
            $ville = 1;
        }
        else
        {
            $ville = 2;
        }

        if($varg1 == 'no')
        {
            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set vendredicheck = 2  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set vendredicheck = 2  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 2,
                
                
                )
                );


        }

        if($varg1 == 'yes')
        {
            self::DbQuery( "UPDATE player set pass10 = pass10 - 1  WHERE player_id = {$this->player_id}" );

            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Tokyo_" . $lastday;
                CardTokyo::$method($this->player_id, 'vendredi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set vendredicheck = 1  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Kyoto_" . $lastday;
                CardKyoto::$method($this->player_id, 'vendredi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set vendredicheck = 1  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 1,
                
                
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses the passport card to force the <b>${day}</b> bonus'), array(
                
                
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[5]['name'],   // A MODIFIER JOUR
                
                )
                );


        }



        ///////////////////////////////////////////////
        ////////////////////////////////////////////////
        ////////////////////////////////////////////////

        $finalscore = self::getUniqueValueFromDB( "SELECT vendredi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
            'numero' => $this->player_no,
            'score' => $finalscore,
            'position' => $day,
            'player_name' => $this->player_name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[5]['name'],
            
            )
            );


        //////////////////////////////////////////////////////////////////////////////   
        ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

        if($countplayer == 1)

        {

        $counttrip = letsgotojapan::$instance->CountTrip(0);  
        $countday = $counttrip[$day-1];
        $bonuscard = array();
        $pvcard =0;
        $ville = 0;

        for ($i=1; $i<=$countday; $i++)
        {
            $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

            if ($type != null)
            {
                $ville = 1;
            
                $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                

                $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                }
                if ($train == 2)
                {
                    self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                    letsgotojapan::$instance->Smile(1,0);
                }

                
            }

            else
            {
                $ville = 2;
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                
                    $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                
                $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                }
                if ($train == 2)
                {
                    self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                    letsgotojapan::$instance->Smile(1,0);
                }

                
            }

            self::DbQuery( "UPDATE agent set vendredi = vendredi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


            if($bonuscard[0]>=1)
            {
                for($token=1; $token<=$bonuscard[0]; $token++)
                {
                    letsgotojapan::$instance->Gain('r',0);
                }

            }

            if($bonuscard[1]>=1)
            {
                for($token=1; $token<=$bonuscard[1]; $token++)
                {
                    letsgotojapan::$instance->Gain('g',0);
                }

            }

            if($bonuscard[2]>=1)
            {
                for($token=1; $token<=$bonuscard[2]; $token++)
                {
                    letsgotojapan::$instance->Gain('p',0);
                }

            }

            if($bonuscard[3]>=1)
            {
                for($token=1; $token<=$bonuscard[3]; $token++)
                {
                    letsgotojapan::$instance->Gain('y',0);
                }

            }

            if($bonuscard[4]>=1)
            {
                for($token=1; $token<=$bonuscard[4]; $token++)
                {
                    letsgotojapan::$instance->Gain('b',0);
                }

            }

            if($bonuscard[5]>=1)
            {
                for($token=1; $token<=$bonuscard[5]; $token++)
                {
                    letsgotojapan::$instance->Gain('h1',0);
                }

            }

            if($bonuscard[6]>=1)
            {
                for($token=1; $token<=$bonuscard[6]; $token++)
                {
                    letsgotojapan::$instance->Gain('h2',0);
                }

            }

            if($bonuscard[7]>=1)
            {
                for($token=1; $token<=$bonuscard[7]; $token++)
                {
                    letsgotojapan::$instance->Gain('a1',0);
                }

            }

            if($bonuscard[8]>=1)
            {
                for($token=1; $token<=$bonuscard[8]; $token++)
                {
                    letsgotojapan::$instance->Gain('a2',0);
                }

            }

            
            
            

        }

        if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                
                
                $method = "AgentTokyo_" . $lastday;
                $check = AgentCardTokyo::$method(0, 'vendredi'); // A MODIFIER JOUR

                if($check == 1)
                {
                    self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set vendredicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 1,
                        'position' => $day,
                                                    
                        )
                        ); 
                }

                if($check == 2)
                {
                    self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set vendredicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 2,
                        'position' => $day,
                                                    
                        )
                        ); 
                }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 1,
                    'check' => $check,
                    
                    )
                    ); 

            }

        if($ville == 2)
        {
            $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
            $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
            
            
            $method = "AgentKyoto_" . $lastday;
            $check = AgentCardKyoto::$method(0, 'vendredi'); // A MODIFIER JOUR

            if($check == 1)
                {
                    self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set vendredicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 1,
                        'position' => $day,
                                                    
                        )
                        ); 
                    
                }

                if($check == 2)
                {
                    self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set vendredicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 2,
                        'position' => $day,
                                                    
                        )
                        ); 
                }
            

            

            letsgotojapan::$instance->notifyAllPlayers('check','', array(
            
                'id' => $cardid,
                'ville' => 2,
                'check' => $check,
                
                
                )
                ); 
            
        }


        $finalscore = self::getUniqueValueFromDB( "SELECT vendredi FROM agent WHERE name='agent'");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                
            'numero' => 2,
            'score' => $finalscore,
            'position' => $day,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[5]['name'],   // changer jour
            
            )
            ); 


        
        }

        ////////////////////////////////////////////////////////////////////////////// 
        ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        letsgotojapan::$instance->addPending($this->player_id, "FinalStepSamediWalk"); // à modifier pour aller sur le mardi


    }

    function argForceSamedi($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();

        $pass10 = self::getUniqueValueFromDB("SELECT pass10 FROM player WHERE player_id= {$this->player_id}");

        if($pass10 == 2)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (1/2)');
        }

        if($pass10 == 1)
        {
            $ret['titleyou'] = clienttranslate('${you} can use your passport card to force the bonus gain (2/2)');
        }
        
        

        
        
        $ret["buttons"][] = 'yes';
        $ret["buttons"][] = 'no';
        

                
        return $ret;
    }


    function ForceSamedi($parg1, $parg2, $varg1, $varg2)
    {

        $day = 6;  //// A MODIFIER

        $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);  
        $countday = $counttrip[$day-1];
        $ville = 0;

        $lastville = self::getUniqueValueFromDB( "SELECT card_type_arg ville FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
        if ($lastville != null)
        {
            $ville = 1;
        }
        else
        {
            $ville = 2;
        }

        if($varg1 == 'no')
        {
            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set samedicheck = 2  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set samedicheck = 2  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 2,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 2,
                
                
                )
                );


        }

        if($varg1 == 'yes')
        {
            self::DbQuery( "UPDATE player set pass10 = pass10 - 1  WHERE player_id = {$this->player_id}" );

            if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Tokyo_" . $lastday;
                CardTokyo::$method($this->player_id, 'samedi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set samedicheck = 1  WHERE player_id = {$this->player_id}" );  // JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );


            }

            if($ville == 2)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location = 'cardposition_{$day}_{$countday}'");

                $method = "Kyoto_" . $lastday;
                CardKyoto::$method($this->player_id, 'samedi', 1); // A MODIFIER JOUR

                self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                self::DbQuery( "UPDATE player set samedicheck = 1  WHERE player_id = {$this->player_id}" ); //JOUR
                letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
            
                    'numero' => $this->player_no,
                    'check' => 1,
                    'position' => $day,
                                                
                    )
                    );
                
            }


            letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                'id' => $cardid,
                'ville' => $ville,
                'check' => 1,
                
                
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} uses the passport card to force the <b>${day}</b> bonus'), array(
                
                
                'player_name' => $this->player_name,
                'day' => letsgotojapan::$instance->days[6]['name'],   // A MODIFIER JOUR
                
                )
                );


        }



        ///////////////////////////////////////////////
        ////////////////////////////////////////////////
        ////////////////////////////////////////////////

        $finalscore = self::getUniqueValueFromDB( "SELECT samedi FROM player WHERE player_id = {$this->player_id}");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '${player_name} gains ${score} ${log} for <b>${day}</b>'), array(
                    
            'numero' => $this->player_no,
            'score' => $finalscore,
            'position' => $day,
            'player_name' => $this->player_name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[6]['name'],
            
            )
            );


        //////////////////////////////////////////////////////////////////////////////   
        ////////////////////////////////// DEBUT SCORE AGENT /////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

            if($countplayer == 1)

            {

        $counttrip = letsgotojapan::$instance->CountTrip(0);  
        $countday = $counttrip[$day-1];
        $bonuscard = array();
        $pvcard =0;
        $ville = 0;

        for ($i=1; $i<=$countday; $i++)
        {
            $type = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");

            if ($type != null)
            {
                $ville = 1;
            
                $bonuscard = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                $pvcard = letsgotojapan::$instance->tokyocards[$type]['pv'];
                

                $train = self::getUniqueValueFromDB( "SELECT train train FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                }
                if ($train == 2)
                {
                    self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                    letsgotojapan::$instance->Smile(1,0);
                }

                
            }

            else
            {
                $ville = 2;
                $type = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                
                    $bonuscard = letsgotojapan::$instance->kyotocards[$type]['bonus'];
                    $pvcard = letsgotojapan::$instance->kyotocards[$type]['pv'];
                
                $train = self::getUniqueValueFromDB( "SELECT train train FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$i}'");
                if ($train != 0)
                {
                    self::DbQuery( "UPDATE agent set trainday = trainday +1   WHERE name='agent'" );
                }
                if ($train == 2)
                {
                    self::DbQuery( "UPDATE agent set happy1 = happy1 +1   WHERE name='agent'" );
                    letsgotojapan::$instance->Smile(1,0);
                }

                
            }

            self::DbQuery( "UPDATE agent set samedi = samedi + {$pvcard}  WHERE name='agent' " );   //// CHANGER LE JOUR


            if($bonuscard[0]>=1)
            {
                for($token=1; $token<=$bonuscard[0]; $token++)
                {
                    letsgotojapan::$instance->Gain('r',0);
                }

            }

            if($bonuscard[1]>=1)
            {
                for($token=1; $token<=$bonuscard[1]; $token++)
                {
                    letsgotojapan::$instance->Gain('g',0);
                }

            }

            if($bonuscard[2]>=1)
            {
                for($token=1; $token<=$bonuscard[2]; $token++)
                {
                    letsgotojapan::$instance->Gain('p',0);
                }

            }

            if($bonuscard[3]>=1)
            {
                for($token=1; $token<=$bonuscard[3]; $token++)
                {
                    letsgotojapan::$instance->Gain('y',0);
                }

            }

            if($bonuscard[4]>=1)
            {
                for($token=1; $token<=$bonuscard[4]; $token++)
                {
                    letsgotojapan::$instance->Gain('b',0);
                }

            }

            if($bonuscard[5]>=1)
            {
                for($token=1; $token<=$bonuscard[5]; $token++)
                {
                    letsgotojapan::$instance->Gain('h1',0);
                }

            }

            if($bonuscard[6]>=1)
            {
                for($token=1; $token<=$bonuscard[6]; $token++)
                {
                    letsgotojapan::$instance->Gain('h2',0);
                }

            }

            if($bonuscard[7]>=1)
            {
                for($token=1; $token<=$bonuscard[7]; $token++)
                {
                    letsgotojapan::$instance->Gain('a1',0);
                }

            }

            if($bonuscard[8]>=1)
            {
                for($token=1; $token<=$bonuscard[8]; $token++)
                {
                    letsgotojapan::$instance->Gain('a2',0);
                }

            }

            
            
            

        }

        if($ville == 1)
            {
                $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
                $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");

                
                
                $method = "AgentTokyo_" . $lastday;
                $check = AgentCardTokyo::$method(0, 'samedi'); // A MODIFIER JOUR

                if($check == 1)
                {
                    self::DbQuery( "UPDATE tokyo set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set samedicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 1,
                        'position' => $day,
                                                    
                        )
                        ); 
                }

                if($check == 2)
                {
                    self::DbQuery( "UPDATE tokyo set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set samedicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 2,
                        'position' => $day,
                                                    
                        )
                        ); 
                }
                

                

                letsgotojapan::$instance->notifyAllPlayers('check','', array(
                
                    'id' => $cardid,
                    'ville' => 1,
                    'check' => $check,
                    
                    )
                    ); 

            }

        if($ville == 2)
        {
            $lastday = self::getUniqueValueFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
            $cardid = self::getUniqueValueFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = 0 AND card_location = 'cardposition_{$day}_{$countday}'");
            
            
            $method = "AgentKyoto_" . $lastday;
            $check = AgentCardKyoto::$method(0, 'samedi'); // A MODIFIER JOUR

            if($check == 1)
                {
                    self::DbQuery( "UPDATE kyoto set checkcard = 1  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set samedicheck = 1  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 1,
                        'position' => $day,
                                                    
                        )
                        ); 
                    
                }

                if($check == 2)
                {
                    self::DbQuery( "UPDATE kyoto set checkcard = 2  WHERE card_id = {$cardid}" );
                    self::DbQuery( "UPDATE agent set samedicheck = 2  WHERE name='agent'" ); // A MODIFIER JOUR
                    letsgotojapan::$instance->notifyAllPlayers('checkscore','', array(
                
                        'numero' => 2,
                        'check' => 2,
                        'position' => $day,
                                                    
                        )
                        ); 
                }
            

            

            letsgotojapan::$instance->notifyAllPlayers('check','', array(
            
                'id' => $cardid,
                'ville' => 2,
                'check' => $check,
                
                
                )
                ); 
            
        }


        $finalscore = self::getUniqueValueFromDB( "SELECT samedi FROM agent WHERE name='agent'");   /// CHANGER JOUR
        letsgotojapan::$instance->notifyAllPlayers('score',clienttranslate( '<b>The Travel Agent</b> gains ${score} ${log} for <b>${day}</b>'), array(
                
            'numero' => 2,
            'score' => $finalscore,
            'position' => $day,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'day' => letsgotojapan::$instance->days[6]['name'],   // changer jour
            
            )
            ); 


        
         }

        ////////////////////////////////////////////////////////////////////////////// 
        ////////////////////////////////// FIN SCORE AGENT ///////////////////////////
        ////////////////////////////////////////////////////////////////////////////// 

        
        


        ///////////////////////// FIN DE SCORING ///////////////////

        $passportcard = self::getUniqueValueFromDB( "SELECT passportcard FROM player WHERE  player_id = {$this->player_id}");


        $scorehumeur =0;
        $lvlhappy = self::getUniqueValueFromDB( "SELECT happy FROM player WHERE player_id = {$this->player_id}");
        if($lvlhappy == 1)
        {
            $scorehumeur = $scorehumeur + 5;
        }

        if($lvlhappy == 2)
        {
            $scorehumeur = $scorehumeur + 12;
        }

        if($lvlhappy == 3)
        {
            $scorehumeur = $scorehumeur + 20;
        }

        $lvlangry = self::getUniqueValueFromDB( "SELECT angry FROM player WHERE player_id = {$this->player_id}");
        
        if($lvlangry == 1)
        {
            $scorehumeur = $scorehumeur - 3;
        }

        if($lvlangry == 2)
        {
            $scorehumeur = $scorehumeur - 8;
        }

        if($lvlangry == 3)
        {
            $scorehumeur = $scorehumeur - 15;
        }

        self::DbQuery( "UPDATE player set scorehumeur = {$scorehumeur} WHERE player_id = {$this->player_id}" );

        if($passportcard == 11)
        {
            self::DbQuery( "UPDATE player set passportscore = $scorehumeur   WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajScorePassport(11,$this->player_id);
        }


        $scoretoken = 0;
        $tableau = array();
        $tableau[] = self::getUniqueValueFromDB( "SELECT r FROM player WHERE player_id = {$this->player_id}");
        $tableau[] = self::getUniqueValueFromDB( "SELECT g FROM player WHERE player_id = {$this->player_id}");
        $tableau[] = self::getUniqueValueFromDB( "SELECT p FROM player WHERE player_id = {$this->player_id}");
        $tableau[] = self::getUniqueValueFromDB( "SELECT y FROM player WHERE player_id = {$this->player_id}");
        $tableau[] = self::getUniqueValueFromDB( "SELECT b FROM player WHERE player_id = {$this->player_id}");

        foreach($tableau as $index)
        {
            if(($index >= 4)&&($index <7))
            {
                $scoretoken = $scoretoken + 4;  
            }

            if(($index >= 7)&&($index <10))
            {
                $scoretoken = $scoretoken + 8;
                if($passportcard == 13)
                {  
                    self::DbQuery( "UPDATE player set passportscore = passportscore +5   WHERE player_id = {$this->player_id}" );
                }
            }

            if(($index >= 10)&&($index <12))
            {
                $scoretoken = $scoretoken + 12;
                if($passportcard == 13)
                {  
                    self::DbQuery( "UPDATE player set passportscore = passportscore +10   WHERE player_id = {$this->player_id}" );
                }  
            }

            if($index >= 12)
            {
                $scoretoken = $scoretoken + 15;
                
                if($passportcard == 13)
                {  
                    self::DbQuery( "UPDATE player set passportscore = passportscore +7  WHERE player_id = {$this->player_id}" );
                } 
            }
        }

        self::DbQuery( "UPDATE player set scoretoken = {$scoretoken} WHERE player_id = {$this->player_id}" );

        if($passportcard == 13)
        {
            
            letsgotojapan::$instance->MajScorePassport(13,$this->player_id);
        }

        if($passportcard == 16)
        {

            // Trouver la plus grosse valeur
            $maxValue = max($tableau);
            
            // Trouver le nombre de valeurs comprises entre 0 et 3 (inclus)
            $valeursEntre0et3 = array_filter($tableau, function($tableau) {
                return $tableau >= 0 && $tableau <= 3;
            });

            $nombreValeursEntre0et3 = count($valeursEntre0et3);

            $score16 = $maxValue + 6*$nombreValeursEntre0et3;
            self::DbQuery( "UPDATE player set passportscore = $score16  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajScorePassport(16,$this->player_id);
        }

        if($passportcard == 17)
        {
        $counttokyocard1 = count(self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_type<=71 AND card_location LIKE 'cardposition%'", true ));
        $counttokyocard2 = count(self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_type>=72 AND walk =1 AND card_location LIKE 'cardposition%'", true ));
        $countkyotocard1 = count(self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_type<=71 AND card_location LIKE 'cardposition%'", true ));
        $countkyotocard2 = count(self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_type>=72 AND walk =1 AND card_location LIKE 'cardposition%'", true ));

        $totaltokyo = $counttokyocard1 + $counttokyocard2;
        $totalkyoto = $countkyotocard1 + $countkyotocard2;

       
        if($totaltokyo == $totalkyoto)
        {
            self::DbQuery( "UPDATE player set passportscore = 14  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajScorePassport(17,$this->player_id);

            
        }
        }

        $scoretrain = 0;
        $counttrainbonustokyo = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND train = 2", true));
        $counttrainbonuskyoto = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND train = 2", true));
        $counttrainmalustokyo = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = {$this->player_id} AND train = 3", true));
        $counttrainmaluskyoto = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = {$this->player_id} AND train = 3", true));

        $scoretrain = $counttrainbonustokyo*2 + $counttrainbonuskyoto*2 - $counttrainmalustokyo*2 - $counttrainmaluskyoto*2;

        self::DbQuery( "UPDATE player set scoretrain = {$scoretrain} WHERE player_id = {$this->player_id}" );


        $scorerecherche = self::getUniqueValueFromDB( "SELECT passportscore FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT recherche FROM player WHERE player_id = {$this->player_id}");

        self::DbQuery( "UPDATE player set scorerecherche = {$scorerecherche} WHERE player_id = {$this->player_id}" );


        $scoretotal = self::getUniqueValueFromDB( "SELECT lundi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT mardi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT mercredi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT jeudi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT vendredi FROM player WHERE player_id = {$this->player_id}") + self::getUniqueValueFromDB( "SELECT samedi FROM player WHERE player_id = {$this->player_id}") + $scorehumeur + $scoretoken + $scoretrain + $scorerecherche;

        self::DbQuery( "UPDATE player set scoretotal = {$scoretotal} WHERE player_id = {$this->player_id}" );


        
        



        ///////////////////////// FIN DE SCORING POUR AGENT /////////////////// 

        $countplayer = count(self::getObjectListFromDB( "SELECT player_id id FROM player", true ));

        if($countplayer == 1)

        {

        $scorehumeura =0;
        $lvlhappya = self::getUniqueValueFromDB( "SELECT happy FROM agent WHERE name='agent'");
        if($lvlhappya == 1)
        {
            $scorehumeura = $scorehumeura + 5;
        }

        if($lvlhappya == 2)
        {
            $scorehumeura = $scorehumeura + 12;
        }

        if($lvlhappya == 3)
        {
            $scorehumeura = $scorehumeura + 20;
        }

        $lvlangrya = self::getUniqueValueFromDB( "SELECT angry FROM agent WHERE name='agent'");
        
        if($lvlangrya == 1)
        {
            $scorehumeura = $scorehumeura - 3;
        }

        if($lvlangrya == 2)
        {
            $scorehumeura = $scorehumeura - 8;
        }

        if($lvlangrya == 3)
        {
            $scorehumeura = $scorehumeura - 15;
        }

        self::DbQuery( "UPDATE agent set scorehumeur = {$scorehumeura} WHERE name='agent'" );


        $scoretokena = 0;
        $tableaua = array();
        $tableaua[] = self::getUniqueValueFromDB( "SELECT r FROM agent WHERE name='agent'");
        $tableaua[] = self::getUniqueValueFromDB( "SELECT g FROM agent WHERE name='agent'");
        $tableaua[] = self::getUniqueValueFromDB( "SELECT p FROM agent WHERE name='agent'");
        $tableaua[] = self::getUniqueValueFromDB( "SELECT y FROM agent WHERE name='agent'");
        $tableaua[] = self::getUniqueValueFromDB( "SELECT b FROM agent WHERE name='agent'");

        foreach($tableaua as $indexa)
        {
            if(($indexa >= 4)&&($indexa <7))
            {
                $scoretokena = $scoretokena + 4;  
            }

            if(($indexa >= 7)&&($indexa <10))
            {
                $scoretokena = $scoretokena + 8;  
            }

            if(($indexa >= 10)&&($indexa <12))
            {
                $scoretokena = $scoretokena + 12;  
            }

            if($indexa >= 12)
            {
                $scoretokena = $scoretokena + 15;  
            }
        }

        self::DbQuery( "UPDATE agent set scoretoken = {$scoretokena} WHERE name='agent'" );

        $scoretraina = 0;
        $counttrainbonustokyoa = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location_arg = 0 AND train = 2", true));
        $counttrainbonuskyotoa = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location_arg = 0 AND train = 2", true));
        

        $scoretraina = $counttrainbonustokyoa*2 + $counttrainbonuskyotoa*2;

        self::DbQuery( "UPDATE agent set scoretrain = {$scoretraina} WHERE name='agent'" );

        $scoretotala = self::getUniqueValueFromDB( "SELECT lundi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT mardi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT mercredi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT jeudi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT vendredi FROM agent WHERE name='agent'") + self::getUniqueValueFromDB( "SELECT samedi FROM agent WHERE name='agent'") + $scorehumeura + $scoretokena + $scoretraina;

        self::DbQuery( "UPDATE agent set scoretotal = {$scoretotala} WHERE name='agent'" );

        
        

        if ($scoretotala > $scoretotal)
        {
            $scoretotalpannel = 0 - $scoretotal;
            self::DbQuery( "UPDATE player set player_score = {$scoretotalpannel} WHERE player_id = {$this->player_id}" );

        }

        if ($scoretotala < $scoretotal)

        {
            $scoretotalpannel = $scoretotal;
            self::DbQuery( "UPDATE player set player_score = {$scoretotalpannel} WHERE player_id = {$this->player_id}" );
        }

        if ($scoretotala == $scoretotal)

        {
            $lvltoken = (self::getUniqueValueFromDB( "SELECT r FROM player WHERE player_id = {$this->player_id}"))+(self::getUniqueValueFromDB( "SELECT g FROM player WHERE player_id = {$this->player_id}"))+(self::getUniqueValueFromDB( "SELECT p FROM player WHERE player_id = {$this->player_id}"))+(self::getUniqueValueFromDB( "SELECT y FROM player WHERE player_id = {$this->player_id}"))+(self::getUniqueValueFromDB( "SELECT b FROM player WHERE player_id = {$this->player_id}"));
            $lvltokena = (self::getUniqueValueFromDB( "SELECT r FROM agent WHERE name='agent'"))+(self::getUniqueValueFromDB( "SELECT g FROM agent WHERE name='agent'"))+(self::getUniqueValueFromDB( "SELECT p FROM agent WHERE name='agent'"))+(self::getUniqueValueFromDB( "SELECT y FROM agent WHERE name='agent'"))+(self::getUniqueValueFromDB( "SELECT b FROM agent WHERE name='agent'"));

            if ($lvltoken >= $lvltokena)
            {
                $scoretotalpannel = $scoretotal;
                self::DbQuery( "UPDATE player set player_score = {$scoretotalpannel} WHERE player_id = {$this->player_id}" );
            }

            if ($lvltoken < $lvltokena)
            {
                $scoretotalpannel = 0 - $scoretotal;
                self::DbQuery( "UPDATE player set player_score = {$scoretotalpannel} WHERE player_id = {$this->player_id}" );
            }


        }





             


        letsgotojapan::$instance->notifyAllPlayers('score2solo',clienttranslate('${player_name} completes the trip to Japan with <b>${total}</b> ${log}'), array(
                
            'numero' => $this->player_no,
            'humeur' => $scorehumeur,
            'token' => $scoretoken,
            'train' => $scoretrain,
            'recherche' => $scorerecherche,
            'total' => $scoretotal,
            'player' => $this->player_id,
            'player_name' => $this->player_name,
            'log' => letsgotojapan::$instance->getLogsType(8),
            'pannel' => $scoretotalpannel,
                      
            
            
            )
            );

        letsgotojapan::$instance->notifyAllPlayers('score2agent',clienttranslate('<b>The Travel Agent</b> completes the trip to Japan with <b>${total}</b> ${log}'), array(
            
            'humeur' => $scorehumeura,
            'token' => $scoretokena,
            'train' => $scoretraina,
            'recherche' => 0,
            'total' => $scoretotala,
            'log' => letsgotojapan::$instance->getLogsType(8),
            
                        
            
            
            )
            );

        }

        if($countplayer >=2)

        {
            self::DbQuery( "UPDATE player set player_score = {$scoretotal} WHERE player_id = {$this->player_id}" );

            letsgotojapan::$instance->notifyAllPlayers('score2',clienttranslate('${player_name} completes the trip to Japan with <b>${total}</b> ${log}'), array(
                
                'numero' => $this->player_no,
                'humeur' => $scorehumeur,
                'token' => $scoretoken,
                'train' => $scoretrain,
                'recherche' => $scorerecherche,
                'total' => $scoretotal,
                'player' => $this->player_id,
                'player_name' => $this->player_name,
                'log' => letsgotojapan::$instance->getLogsType(8),
                          
                
                
                )
                );

        }


    
        letsgotojapan::$instance->giveExtraTime($this->player_id);
        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');


    }




    /*function argVide($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selectableswitch"] = array();
        $ret["selected"] = array();
        $ret["buttons"] = array();
        
        $ret['titleyou'] = clienttranslate('${you} step vide');

        
        
        $ret["buttons"][] = 'yes';
        $ret["buttons"][] = 'no';
        

                
        return $ret;
    }

    function Vide($parg1, $parg2, $varg1, $varg2)
    {
        

    }*/




























}