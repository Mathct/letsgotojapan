<?php 
        
  
    class AgentCardKyoto extends APP_GameClass
{
    
    
    public static function AgentKyoto_1($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
                
        if(($ret[3] == 0)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("p",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_2($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_3($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 1)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("h1",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_4($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 2*$ret[5];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_5($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 4)||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("p",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }
    
    public static function AgentKyoto_6($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 2)||($lvl>=2))
        {
            $score = 5+$ret[4];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_7($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[3] >= 2)&&($ret[1] >= 2))||($lvl>=2))
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

    public static function AgentKyoto_8($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 4)||($lvl>=2))
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

    public static function AgentKyoto_9($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[5] >= 1)||($lvl>=2))
        {
            $score = 4;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("r",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_10($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 2)||($lvl>=2))
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


    public static function AgentKyoto_11($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[9] >= 2)||($lvl>=2))
        {
            $score = 2*min($ret[0], $ret[4]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_12($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[5] >= 2)||($lvl>=2))
        {
            $score = 3+$ret[0];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_13($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_14($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_15($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[0] >= 2)&&($ret[2] >= 2))||($lvl>=2))
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

    public static function AgentKyoto_16($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[4], $ret[1]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_17($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_18($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] == 0)||($lvl>=2))
        {
            $score = 4 + $ret[3];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_19($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_20($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 3)||($lvl>=2))
        {
            $score = 5;
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

    public static function AgentKyoto_21($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[5] >= 2)||($lvl>=2))
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
    
    public static function AgentKyoto_22($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_23($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] == 0)||($lvl>=2))
        {
            $score = 4 + $ret[3];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_24($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_25($player_id, $day)
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


    public static function AgentKyoto_26($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[9] >= 2)||($lvl>=2))
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


    public static function AgentKyoto_27($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 4)||($lvl>=2))
        {
            $score = 2*min($ret[2], $ret[4]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_28($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 2)||($lvl>=2))
        {
            $score = 5;
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

    public static function AgentKyoto_29($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_30($player_id, $day)
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
                $tokyo = count(self::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$player_id} AND finallocation = 2 AND card_location LIKE 'cardposition_{$d}%'", true ));
                $kyoto = count(self::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$player_id} AND finallocation = 2 AND card_location LIKE 'cardposition_{$d}%'", true ));
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

    public static function AgentKyoto_31($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
        {
            $score = 2*min($ret[2], $ret[0]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_32($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
        {
            $score = 4;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
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


    public static function AgentKyoto_33($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 4)||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
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

    public static function AgentKyoto_34($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[10] >= 2)||($lvl>=2))
        {
            $score = 5 + 2*$ret[10];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_35($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[10] >= 3)||($lvl>=2))
        {
            $score = 9;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_36($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_37($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 3)||($lvl>=2))
        {
            $score = $ret[4];
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

    public static function AgentKyoto_38($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_39($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_40($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_41($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 3)||($lvl>=2))
        {
            $score = 2*min($ret[0], $ret[4]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_42($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 3)||($lvl>=2))
        {
            $score = 4;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("h2",$player_id);
            letsgotojapan::$instance->Gain("r",$player_id);
            letsgotojapan::$instance->Gain("g",$player_id);
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_43($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] == 0)||($lvl>=2))
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

    public static function AgentKyoto_44($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[5] >= 1)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("h2",$player_id);
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_45($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_46($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 3)||($lvl>=2))
        {
            $score = 2*$ret[8];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function AgentKyoto_47($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 2)||($lvl>=2))
        {
            $score = 6;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("h1",$player_id);
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_48($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[0] >= 1)&&($ret[1] >= 1)&&($ret[2] >= 1)&&($ret[3] >= 1)&&($ret[4] >= 1))||($lvl>=2))
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

    public static function AgentKyoto_49($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_50($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[0] >= 2)&&($ret[1] >= 2)&&($ret[3] >= 2))||($lvl>=2))
        {
            $score = 12;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_51($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_52($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[9] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_53($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_54($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[2] >= 2)&&($ret[10] >= 1))||($lvl>=2))
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

    public static function AgentKyoto_55($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[2] >= 2)&&($ret[0] >= 2))||($lvl>=2))
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

    public static function AgentKyoto_56($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_57($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[5] >= 2)||($lvl>=2))
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

    
    public static function AgentKyoto_58($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_59($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[0] >= 2)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("r",$player_id);
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_60($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 4)||($lvl>=2))
        {
            $score = 2*min($ret[2], $ret[4]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_61($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_62($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 1)||($lvl>=2))
        {
            $score = 0;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("p",$player_id);
            letsgotojapan::$instance->Gain("p",$player_id);
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_63($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[9] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_64($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 1)||($lvl>=2))
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

    public static function AgentKyoto_65($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[9] >= 2)||($lvl>=2))
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


    public static function AgentKyoto_66($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if((($ret[3] >= 3)&&($ret[1] >= 3))||($lvl>=2))
        {
            $score = 9;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_67($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[6] >= 4)||($lvl>=2))
        {
            $score = 12;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_68($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[6] >= 2)||($lvl>=2))
        {
            $score = 4 + $ret[3];
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_69($player_id, $day)
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

    public static function AgentKyoto_70($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[7] >= 4)||($lvl>=2))
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

    public static function AgentKyoto_71($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[1] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_72($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 2)||($lvl>=2))
        {
            $score = 5;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            
            $newetat = letsgotojapan::$instance->EtatToken($player_id);
            $premieresValeurs = array_slice($newetat, 0, 5);  // Extraire les 5 premières valeurs
            $maxValue = max($premieresValeurs); // Trouver la valeur maximale parmi les 5 premières
            $indexMax = array_search($maxValue, $newetat); // Trouver l'index de cette valeur dans le tableau original
            if ($indexMax == 0)
            {
                letsgotojapan::$instance->Gain("r",$player_id);
                letsgotojapan::$instance->Gain("r",$player_id);
            }
            if ($indexMax == 1)
            {
                letsgotojapan::$instance->Gain("g",$player_id);
                letsgotojapan::$instance->Gain("g",$player_id);
            }
            if ($indexMax == 2)
            {
                letsgotojapan::$instance->Gain("p",$player_id);
                letsgotojapan::$instance->Gain("p",$player_id);
            }
            if ($indexMax == 3)
            {
                letsgotojapan::$instance->Gain("y",$player_id);
                letsgotojapan::$instance->Gain("y",$player_id);
            }
            if ($indexMax == 4)
            {
                letsgotojapan::$instance->Gain("b",$player_id);
                letsgotojapan::$instance->Gain("b",$player_id);
            }
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_73($player_id, $day)
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

    public static function AgentKyoto_74($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[8] >= 2)||($lvl>=2))
        {
            $score = 2*min($ret[2], $ret[4]);
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_75($player_id, $day)
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

    public static function AgentKyoto_76($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[2] >= 2)||($lvl>=2))
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

    public static function AgentKyoto_77($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
        {
            $score = 8;
            self::DbQuery( "UPDATE agent set {$day} = {$day} + {$score}  WHERE name = 'agent'" );
            letsgotojapan::$instance->Gain("y",$player_id);
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function AgentKyoto_78($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[3] >= 3)||($lvl>=2))
        {
            $score = 5;
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

    public static function AgentKyoto_79($player_id, $day)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        $lvl = self::getUniqueValueFromDB("SELECT sololvl FROM agent WHERE name = 'agent'");
        
        if(($ret[4] >= 3)||($lvl>=2))
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

    public static function AgentKyoto_80($player_id, $day)
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
    
    
    
    
}
