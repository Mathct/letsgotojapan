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
        //CardTokyo::Tokyo_1($this->player_id, $day);
        
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
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip');

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
        
        else

        {

            $explode = explode("_", $parg1);
            $explode2 = explode("_", $varg1);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );
            }

            

            letsgotojapan::$instance->notifyAllPlayers('movecard',clienttranslate( '${player_name} places a card on ${day}'), array(
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
                        
                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
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

                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
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
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log} ${log}' ), array(
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
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
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
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
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
                letsgotojapan::$instance->notifyAllPlayers('addwalk',clienttranslate( '${player_name} places ${log} on ${day}'), array(
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
                letsgotojapan::$instance->notifyAllPlayers('addwalk',clienttranslate( '${player_name} places ${log} on ${day}'), array(
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
                            else
                            {
                                letsgotojapan::$instance->giveExtraTime($this->player_id);
                                letsgotojapan::$instance->addPending($this->player_id, "Phase2Step1");

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
            letsgotojapan::$instance->notifyAllPlayers('addwalk',clienttranslate( '${player_name} places an Extra ${log} on ${day}'), array(
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
            letsgotojapan::$instance->notifyAllPlayers('addwalk',clienttranslate( '${player_name} places an Extra ${log} on ${day}'), array(
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
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose your 1st card:');


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
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose your 2nd card:');


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
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose your 3rd card:');


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
        $ret["selectable3discard"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose the 3 cards to discard');

        $tokyocard = self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );
        $kyotocard = self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE card_location ='playerhand' AND card_location_arg = {$this->player_id}", true );

        foreach ($tokyocard as $id1)
        {
            $ret["selectable3discard"][] = 'card_1_'.$id1;
        }   

        foreach ($kyotocard as $id2)
        {
            $ret["selectable3discard"][] = 'card_2_'.$id2;
        }

        $ret['buttons'][]='validate3discard'; 
     

        return $ret;
    }

    function RechercheStep4($parg1, $parg2, $varg1, $varg2)
    {
        // RIEN A FAIRE
    }




     /////////////////////// PHASE 2 //////////////////////////
              
        

    function argPhase2Step1($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
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
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip');

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
        
        else

        {

            $explode = explode("_", $parg1);
            $explode2 = explode("_", $varg1);

            if($explode[1] == 1)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->tokyo->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );
            }

            if($explode[1] == 2)
            {
                $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
                letsgotojapan::$instance->kyoto->moveCard( $explode[2], $explode2[0].'_'.$explode2[1].'_'.$explode2[2], $this->player_id );
            }

            

            letsgotojapan::$instance->notifyAllPlayers('movecard',clienttranslate( '${player_name} places a card on ${day}'), array(
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
                        
                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
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

                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains ${log}' ), array(
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



































}