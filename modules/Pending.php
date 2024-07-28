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
    }

    /////////////////////// PHASE 1 //////////////////////////
    
    function argPhase1Step1($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret["selected"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a card to place');


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

    function Phase1Step1($parg1, $parg2, $varg1, $varg2)
    {

        
        //CardTokyo::Tokyo_1($this->player_id);

        /*$explode = explode("_", $varg1);
        if($explode[1] == 1)
        {
            $card = self::getUniqueValueFromDB("SELECT card_type FROM tokyo WHERE card_id={$explode[2]}");
            var_dump(letsgotojapan::$instance->tokyocards[$card]);
        }

        if($explode[1] == 2)
        {
            $card = self::getUniqueValueFromDB("SELECT card_type FROM kyoto WHERE card_id={$explode[2]}");
            var_dump(letsgotojapan::$instance->kyotocards[$card]);
        }*/

        
           
            letsgotojapan::$instance->Deployer($this->player_id);
            

            letsgotojapan::$instance->addPending($this->player_id, "Phase1Step2", $varg1);
       

        

            
    }

    function argPhase1Step2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
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
                    foreach($tokyocard as $cardid)
                    {

                    letsgotojapan::$instance->tokyo->moveCard( $cardid, 'discardboard', $this->player_id );
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
                    foreach($kyotocard as $cardid)
                    {
                    letsgotojapan::$instance->kyoto->moveCard( $cardid, 'discardboard', $this->player_id );
                    letsgotojapan::$instance->notifyAllPlayers('passcard','', array(
                        'id' => $cardid,
                        'ville' => 2,
                        'playerid' => $this->player_id,

                        )
                        );
                    }

            }

            letsgotojapan::$instance->notifyAllPlayers( 'simplePause', '', [ 'time' => 1000] ); 
            letsgotojapan::$instance->Condenser($this->player_id, $varg1);


            $counttrip = letsgotojapan::$instance->CountTrip($this->player_id);
            
            $day = $explode2[1];

            if ($counttrip[$day-1] == 3)
            {
                $colorday = intval(self::getUniqueValueFromDB("SELECT level FROM tokens WHERE name={$day}"));
                

                $scorecards = array();

                $tokyo = self::getObjectListFromDB( "SELECT card_type type FROM tokyo WHERE  card_location_arg = {$this->player_id} AND card_location LIKE 'cardposition_{$day}%'", true );
                $kyoto = self::getObjectListFromDB( "SELECT card_type type FROM kyoto WHERE  card_location_arg = {$this->player_id} AND card_location LIKE 'cardposition_{$day}%'", true );

                if ($tokyo != null)
                {
                    foreach ($tokyo as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->tokyocards[$type]['bonus'];
                    }

                }

                if ($kyoto != null)
                {

                    foreach ($kyoto as $type)
                    {
                        $scorecards[] = letsgotojapan::$instance->kyotocards[$type]['bonus'];
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
                        
                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains smile' ), array(
                            'player_name' => $this->player_name,
                            )
                            );
                        
                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($result[$colorday-1]>=2)
                    {
                       
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $result[$colorday-1]);
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

                        letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains smile' ), array(
                            'player_name' => $this->player_name,
                            )
                            );

                        letsgotojapan::$instance->giveExtraTime($this->player_id);
                        letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
                    }

                    if($calculhappy>=2)
                    {
                        letsgotojapan::$instance->addPending($this->player_id, "BonusChoose", $calculhappy);
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








    /////////////////////// PHASE 2 //////////////////////////



    /////////////////////// BONUS JOURNEE //////////////////////////

    function argBonusChoose($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
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

        if ($varg1 === 'bonusjournee_1_' . $this->player_id) 
        {
            letsgotojapan::$instance->Smile(1,$this->player_id);

            letsgotojapan::$instance->notifyAllPlayers('message',clienttranslate( '${player_name} gains smile' ), array(
                'player_name' => $this->player_name,
                )
                );

            letsgotojapan::$instance->giveExtraTime($this->player_id);
            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');

        }

        else
        {
            letsgotojapan::$instance->giveExtraTime($this->player_id);
            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');

        }
        
        

    }
































}