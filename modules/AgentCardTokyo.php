<?php 
        
  
    class AgentCardTokyo extends APP_GameClass
{
    
    
    public static function AgentTokyo_1($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
                
        if(($ret[8] >= 2)||($lvl>=2))
        {
            $score = 2*min($ret[3], $ret[4]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_2($player_id, $day)
    {
        
        
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        
        if(($ret[3] >= 3)||($lvl>=2))
        {
            $score = 3 + $ret[3];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_3($player_id, $day)
    {
        
        
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[3] >= 2)&&($ret[0] >= 2))||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_4($player_id, $day)
    {
        
        
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 3)||($lvl>=2))
        {
            $score =7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_5($player_id, $day)
    {
        
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[1] >= 2)&&($ret[0] >= 2))||($lvl>=2))
        {
            $score = 3 + $ret[1];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_6($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 2)||($lvl>=2))
        {
            $score = 2*min($ret[0], $ret[1]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_7($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[2] >= 2)&&($ret[0] >= 2))||($lvl>=2))
        {
            $trip = letsgotojapan::$instance->CountTrip($player_id);
            $list = ["lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"];
            $position = array_search($day, $list);
            $found = 0;

            for ($i=0; $i<=$position; $i++)
            {
                $d = $i+1;
                $tokyo = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$player_id} AND finallocation = 1 AND card_location LIKE 'cardposition_{$d}%'", true ));
                $kyoto = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$player_id} AND finallocation = 1 AND card_location LIKE 'cardposition_{$d}%'", true ));
                $count = $tokyo + $kyoto;

                if( $count == $trip[$i])
                {
                    $found = $found+1;
                }
                
                
            }

            $score = 3*$found;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_8($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[0], $ret[2]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_9($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 4)||($lvl>=2))
        {
            $score = 2*min($ret[0], $ret[3]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_10($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_11($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[1], $ret[8]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_12($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 2)||($lvl>=2))
        {
            $score = 7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_13($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 4)||($lvl>=2))
        {
            $score = 14;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_14($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[6] >= 2)||($lvl>=2))
        {
            $score = 6;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("y",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function AgentTokyo_15($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[10] >= 2)||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("b",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function AgentTokyo_16($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 2)||($lvl>=2))
        {
            $score = 6;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("b",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function AgentTokyo_17($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[1] >= 1)&&($ret[0] >= 2))||($lvl>=2))
        {
            $score = 4 + $ret[1];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_18($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 2)||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("y",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_19($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 6;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_20($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 2)||($lvl>=2))
        {
            $score = 6;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_21($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[3] >= 3)&&($ret[2] >= 3))||($lvl>=2))
        {
            $score = 11;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_22($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[3] >= 3)&&($ret[1] >= 3))||($lvl>=2))
        {
            $score = 10;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_23($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[3], $ret[1]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_24($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[5] >= 2)||($lvl>=2))
        {
            $score = 3 + $ret[2];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_25($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 2)||($lvl>=2))
        {
            $score = 2*min($ret[3], $ret[2]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_26($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[5] >= 2)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_27($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[3], $ret[0]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_28($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 2)||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_29($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 2)||($lvl>=2))
        {
            $score = 4 + $ret[2];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_30($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[6] >= 2)||($lvl>=2))
        {
            $score = 7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("y",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_31($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 4)||($lvl>=2))
        {
            $score = 3 + $ret[3];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_32($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 2)||($lvl>=2))
        {
            $score = 4;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("r",$player_id);
            letsgotojapan::$instance->Gain("p",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_33($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[5] >= 1)||($lvl>=2))
        {
            $score = 3;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("r",$player_id);
            letsgotojapan::$instance->Gain("r",$player_id);
            letsgotojapan::$instance->Gain("h2",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_34($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 3)||($lvl>=2))
        {
            $score = 5 + $ret[7];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_35($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[5] >= 3)||($lvl>=2))
        {
            $score = 4 + $ret[2];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_36($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[6] >= 3)||($lvl>=2))
        {
            $score = 6;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("y",$player_id);
            
            $newetat = letsgotojapan::$instance->EtatToken($player_id);
            $premieresValeurs = array_slice($newetat, 0, 5);  // Extraire les 5 premières valeurs
            $maxValue = max($premieresValeurs); // Trouver la valeur maximale parmi les 5 premières
            $indexMax = array_search($maxValue, $newetat); // Trouver l'index de cette valeur dans le tableau original
            if ($indexMax == 0)
            {
                letsgotojapan::$instance->Gain("r",$player_id);
            }
            if ($indexMax == 1)
            {
                letsgotojapan::$instance->Gain("g",$player_id);
            }
            if ($indexMax == 2)
            {
                letsgotojapan::$instance->Gain("p",$player_id);
            }
            if ($indexMax == 3)
            {
                letsgotojapan::$instance->Gain("y",$player_id);
            }
            if ($indexMax == 4)
            {
                letsgotojapan::$instance->Gain("b",$player_id);
            }
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_37($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 3)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("b",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_38($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 2)||($lvl>=2))
        {
            $score = 6;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("g",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_39($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[1] >= 2)&&($ret[4] >= 2))||($lvl>=2))
        {
            $score = 5 + $ret[4];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_40($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] == 0)||($lvl>=2))
        {
            $score = 4 + $ret[1];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_41($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 1)||($lvl>=2))
        {
            $score = 5 + $ret[4];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_42($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[6] >= 4)||($lvl>=2))
        {
            $score = 2*$ret[6];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_43($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[10] >= 3)||($lvl>=2))
        {
            $score = 5 + $ret[4];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_44($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[3], $ret[4]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_45($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
        {
            $score = 3*min($ret[1], $ret[3], $ret[2], $ret[0]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_46($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[3] >= 2)&&($ret[0] >= 2))||($lvl>=2))
        {
            $score = 3 + $ret[0];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_47($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 2)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("y",$player_id);
            letsgotojapan::$instance->Gain("y",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_48($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 2)||($lvl>=2))
        {
            $score = 7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_49($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 1)||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("a1",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_50($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 4)||($lvl>=2))
        {
            $score = 5 + $ret[4];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_51($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
        {
            $score = 7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_52($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 2)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_53($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[3], $ret[1]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_54($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = $ret[0];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_55($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 3)||($lvl>=2))
        {
            $score = 7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_56($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 2)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("h1",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_57($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 2)||($lvl>=2))
        {
            $score = 5 + $ret[5];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_58($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 4)||($lvl>=2))
        {
            $score = 3;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_59($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
        {
            $score = 5 + $ret[8];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_60($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[2], $ret[1]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function AgentTokyo_61($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
        {
            $score = 3 + $ret[1];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_62($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[6] >= 3)||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_63($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 2)||($lvl>=2))
        {
            $score = 6;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_64($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[0] >= 1)&&($ret[5] >= 1))||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("r",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }
    
    public static function AgentTokyo_65($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[0] >= 3)&&($ret[1] >= 3))||($lvl>=2))
        {
            $score = 11;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_66($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[4] >= 2)&&($ret[3] >= 2))||($lvl>=2))
        {
            $score = 2*min($ret[0], $ret[3]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_67($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[9] >= 2)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("y",$player_id);
            letsgotojapan::$instance->Gain("y",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_68($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
        {
            $score = 7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("y",$player_id);
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_69($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 4)||($lvl>=2))
        {
            $score = 2*min($ret[2], $ret[1]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_70($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 2)||($lvl>=2))
        {
            $score = 6;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("g",$player_id);
            letsgotojapan::$instance->Gain("g",$player_id);
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_71($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[0] >= 1)&&($ret[1] >= 1)&&($ret[4] >= 1))||($lvl>=2))
        {
            $score = 7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_72($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[0], $ret[1]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_73($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[9] >= 2)||($lvl>=2))
        {
            $score = 7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("p",$player_id);
            
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_74($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 2)||($lvl>=2))
        {
            $score = 7;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("p",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_75($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
        {
            $score = 3 + $ret[1];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_76($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[3] >= 1)&&($ret[1] >= 1))||($lvl>=2))
        {
            $score = 3 + $ret[0];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_77($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[3], $ret[2]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_78($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 2)||($lvl>=2))
        {
            $score = 9;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("a2",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_79($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 4)||($lvl>=2))
        {
            $score = 3 + $ret[1];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentTokyo_80($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 4)||($lvl>=2))
        {
            $score = 6 + $ret[4];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }











    
    
    
    
}

   
    
    
    
    
