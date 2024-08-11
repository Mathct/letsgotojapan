<?php 
        
  
    class CardKyoto extends APP_GameClass
{
    
    
    public static function Kyoto_1($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if($ret[3] == 0)
        {
            $score = 5;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("p",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_2($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if($ret[4] >= 2)
        {
            $score = 3 + $ret[2];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }
    






    
    
    
    
}
