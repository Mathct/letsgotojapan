<?php 
        
  
    class CardKyoto extends APP_GameClass
{
    
    
    public static function Kyoto_71($player_id, $day)
    {
        
        $g = self::getUniqueValueFromDB( "SELECT g FROM player WHERE player_id = {$player_id}");
        if($g >= 2)
        {
            self::DbQuery( "UPDATE player set {$day} = {$day} + 7  WHERE player_id = {$player_id}" );
        }
        
        
    }
    
    
    
    
}
