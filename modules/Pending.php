<?php
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
    
    function argNormalTurn($parg1, $parg2)
    {
        
        $ret = array();
        $ret["selectable"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a card to place');


        
       

        
        $ret['buttons'][]='pass';

        
        
        return $ret;
    }

    function NormalTurn($parg1, $parg2, $varg1, $varg2)
    {

        
        
        if($varg1 == "cancel")
        {
            letsgotojapan::$instance->addPending($this->player_id, "NormalTurn");
        }
        elseif ($varg1 == "pass")
        {
            letsgotojapan::$instance->addPendingFirst($this->player_id, "NormalTurn");
            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
        }

        else

        {
            letsgotojapan::$instance->addPending($this->player_id, "Step2");
        }

        

            
    }

    function argStep2($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} must choose a location in your trip');

        
       

        $ret['buttons'][]='cancel';
        $ret['buttons'][]='pass';


        
        return $ret;
    }

    function Step2($parg1, $parg2, $varg1, $varg2)
    {
        
        if($varg1 == "cancel")
        {
            letsgotojapan::$instance->addPending($this->player_id, "NormalTurn");
        }
        elseif ($varg1 == "pass")
        {
            letsgotojapan::$instance->addPendingFirst($this->player_id, "NormalTurn");
            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
            
        }

        else

        {
            
            letsgotojapan::$instance->addPending($this->player_id, "Step3");
            
            
        }

    }

    function argStep3($parg1, $parg2)
    {
        $ret = array();
        $ret["selectable"] = array();
        $ret['buttons'] = array();
        $ret['titleyou'] = clienttranslate('${you} devez cliquer sur cancel');

        //$ret['buttons'][]='cancel';

        return $ret;
    }

    function Step3($parg1, $parg2, $varg1, $varg2)
    {
               
        

            letsgotojapan::$instance->addPendingFirst($this->player_id, "NormalTurn");
            letsgotojapan::$instance->gamestate->setPlayerNonMultiactive($this->player_id, 'stop');
            
            
        

    }




}