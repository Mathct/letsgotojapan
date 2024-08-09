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

            

            letsgotojapan::$instance->notifyAllPlayers('movecard',clienttranslate( '${player_name} places a card on <b>${day}</b>'), array(
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

            

            letsgotojapan::$instance->notifyAllPlayers('movecard',clienttranslate( '${player_name} places a card on <b>${day}</b>'), array(
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


/////////////////////// FINAL PHASE ///////////////////


function argFinalStep1($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
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

            $ret['titleyou'] = clienttranslate('${you} do not have generic activity');
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
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the generic activities' ), array(
                'player_name' => $this->player_name,
                
                )
                );
            
            letsgotojapan::$instance->addPending($this->player_id, "FinalStep2");
            
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

    function argFinalStep2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
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

            $ret['titleyou'] = clienttranslate('${you} must choose the side of the card for this walk <br>');

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

            $ret['titleyou'] = clienttranslate('${you} have no walk');
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
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the walks' ), array(
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

              

              
        

    }


    function argFinalStep3($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
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

            $ret['titleyou'] = clienttranslate('${you} have no train to place');
            $ret['buttons'][]='continue';
        }

        
        return $ret;
    }

    function FinalStep3($parg1, $parg2, $varg1, $varg2)
    {

        if($varg1 == "continue")
        {
            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} managed the trains' ), array(
                'player_name' => $this->player_name,
                
                )
                );

            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} has finished planning the trip' ), array(
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



    function argFinalStepLundi($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        

        $wild = self::getUniqueValueFromDB( "SELECT wild FROM player WHERE player_id = {$this->player_id}");

        if($wild >=1)
        {
            $ret['titleyou'] = clienttranslate('Monday! ${you} can use one (or more) <span class="wild"></span>');
            $ret['buttons'][]='yes';
            $ret['buttons'][]='no';
        }
        else
        {
            $ret['titleyou'] = clienttranslate('Monday!');
            $ret['buttons'][]='continue';
        }
       
        
     

        return $ret;
    }

    function FinalStepLundi($parg1, $parg2, $varg1, $varg2)
    {
        if($varg1 == "yes")
        {
            letsgotojapan::$instance->addPending($this->player_id, "WildLundi");

        }

        if(($varg1 == "no")||($varg1 == "continue"))
        {
            $day = 1;


        }




    }

    function argWildLundi($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
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

    function WildLundi($parg1, $parg2, $varg1, $varg2)
    {
        if($varg1 == "cancel")
        {
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi");

        }

        else
        {
            letsgotojapan::$instance->addPending($this->player_id, "ConfirmWildLundi", $varg1);
        }
       


    }

    function argConfirmWildLundi($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret["selectable2"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must confirm <span class="' . $parg1 . '"></span>');

              
        $ret['buttons'][]='confirm';
        $ret['buttons'][]='cancel';
        return $ret;
    }

    function ConfirmWildLundi($parg1, $parg2, $varg1, $varg2)
    {
        if($varg1 == "cancel")
        {
            letsgotojapan::$instance->addPending($this->player_id, "WildLundi");

        }

        

        if($varg1 == "confirm")
        {
            if($parg1 == 'red')
            {
                letsgotojapan::$instance->Gain('r',$this->player_id);
            }
            if($parg1 == 'green')
            {
                letsgotojapan::$instance->Gain('g',$this->player_id);
            }
            if($parg1 == 'pink')
            {
                letsgotojapan::$instance->Gain('p',$this->player_id);
            }
            if($parg1 == 'yellow')
            {
                letsgotojapan::$instance->Gain('y',$this->player_id);
            }
            if($parg1 == 'blue')
            {
                letsgotojapan::$instance->Gain('b',$this->player_id);
            }

            self::DbQuery( "UPDATE player set wild = wild -1  WHERE player_id = {$this->player_id}" );
            letsgotojapan::$instance->MajPannel($this->player_id);
            letsgotojapan::$instance->addPending($this->player_id, "FinalStepLundi");
        }
       


    }































}