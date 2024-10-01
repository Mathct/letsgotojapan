<?php 
        
  
    class CardKyoto extends APP_GameClass
{
    
    
    public static function Kyoto_1($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] == 0)||($force ==1))
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

    public static function Kyoto_2($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
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

    public static function Kyoto_3($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 1)||($force ==1))
        {
            $score = 5;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("h1",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_4($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 2*$ret[5];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_5($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 4)||($force ==1))
        {
            $score = 8;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("p",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }
    
    public static function Kyoto_6($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 2)||($force ==1))
        {
            $score = 5+$ret[4];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_7($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[3] >= 2)&&($ret[1] >= 2))||($force ==1))
        {
            $score = 2*min($ret[0], $ret[2]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_8($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 4)||($force ==1))
        {
            $score = 8;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_9($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 1)||($force ==1))
        {
            $score = 4;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("r",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_10($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 2)||($force ==1))
        {
            $score = 2*$ret[6];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function Kyoto_11($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[9] >= 2)||($force ==1))
        {
            $score = 2*min($ret[0], $ret[4]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_12($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 2)||($force ==1))
        {
            $score = 3+$ret[0];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_13($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[1]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_14($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 2)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[1]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_15($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[0] >= 2)&&($ret[2] >= 2))||($force ==1))
        {
            $score = 7;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_16($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 2*min($ret[4], $ret[1]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_17($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 2)||($force ==1))
        {
            $score = 6;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_18($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] == 0)||($force ==1))
        {
            $score = 4 + $ret[3];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_19($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 3)||($force ==1))
        {
            $score = 2*min($ret[0], $ret[2]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_20($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 3)||($force ==1))
        {
            $score = 5;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_21($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 2)||($force ==1))
        {
            $score = 6;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            return 1;
        }

        else
        {
            return 2;
        }
    }
    
    public static function Kyoto_22($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 3)||($force ==1))
        {
            $score = 8;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_23($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] == 0)||($force ==1))
        {
            $score = 4 + $ret[3];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_24($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 2)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[1]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_25($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 3)||($force ==1))
        {
            $score = 7;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function Kyoto_26($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[9] >= 2)||($force ==1))
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


    public static function Kyoto_27($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 4)||($force ==1))
        {
            $score = 2*min($ret[2], $ret[4]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_28($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 2)||($force ==1))
        {
            $score = 5;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_29($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 2)||($force ==1))
        {
            $score = 5 + $ret[4];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_30($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[2] >= 2)&&($ret[0] >= 2))||($force ==1))
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
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_31($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 2*min($ret[2], $ret[0]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_32($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 4;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
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


    public static function Kyoto_33($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 4)||($force ==1))
        {
            $score = 8;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            self::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->MajPannel($player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_34($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[10] >= 2)||($force ==1))
        {
            $score = 5 + 2*$ret[10];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_35($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[10] >= 3)||($force ==1))
        {
            $score = 9;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_36($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 3)||($force ==1))
        {
            $score = 2*min($ret[2], $ret[1]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_37($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 3)||($force ==1))
        {
            $score = $ret[4];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("g",$player_id);
            letsgotojapan::$instance->Gain("g",$player_id);
            
            
            
            
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_38($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 3)||($force ==1))
        {
            $score = 2*min($ret[0], $ret[3]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_39($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 3)||($force ==1))
        {
            $score = 7;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_40($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 3)||($force ==1))
        {
            $score = 5 + $ret[4];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_41($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 3)||($force ==1))
        {
            $score = 2*min($ret[0], $ret[4]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_42($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 3)||($force ==1))
        {
            $score = 4;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
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

    public static function Kyoto_43($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] == 0)||($force ==1))
        {
            $score = 3 + $ret[0];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
           
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_44($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 1)||($force ==1))
        {
            $score = 5;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("h2",$player_id);
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_45($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
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

    public static function Kyoto_46($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 3)||($force ==1))
        {
            $score = 2*$ret[8];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function Kyoto_47($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 2)||($force ==1))
        {
            $score = 6;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            letsgotojapan::$instance->Gain("h1",$player_id);
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_48($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[0] >= 1)&&($ret[1] >= 1)&&($ret[2] >= 1)&&($ret[3] >= 1)&&($ret[4] >= 1))||($force ==1))
        {
            $score = 10;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_49($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 2)||($force ==1))
        {
            $score = 6;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_50($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[0] >= 2)&&($ret[1] >= 2)&&($ret[3] >= 2))||($force ==1))
        {
            $score = 12;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_51($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 3)||($force ==1))
        {
            $score = 3 + $ret[0];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_52($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[9] >= 2)||($force ==1))
        {
            $score = 2*min($ret[2], $ret[1]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_53($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 3)||($force ==1))
        {
            $score = 7;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_54($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[2] >= 2)&&($ret[10] >= 1))||($force ==1))
        {
            $score = 8;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_55($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[2] >= 2)&&($ret[0] >= 2))||($force ==1))
        {
            $score = 7;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_56($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 3)||($force ==1))
        {
            $score = 8;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_57($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 2)||($force ==1))
        {
            $score = 2*min($ret[2], $ret[1]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    
    public static function Kyoto_58($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 8;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_59($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 2)||($force ==1))
        {
            $score = 5;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("r",$player_id);
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_60($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 4)||($force ==1))
        {
            $score = 2*min($ret[2], $ret[4]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_61($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 2)||($force ==1))
        {
            $score = 5 + $ret[5];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_62($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 1)||($force ==1))
        {
            $score = 0;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
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

    public static function Kyoto_63($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[9] >= 2)||($force ==1))
        {
            $score = 4 + $ret[1];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_64($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 1)||($force ==1))
        {
            $score = 6;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_65($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[9] >= 2)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[1]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function Kyoto_66($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[3] >= 3)&&($ret[1] >= 3))||($force ==1))
        {
            $score = 9;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_67($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[6] >= 4)||($force ==1))
        {
            $score = 12;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_68($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[6] >= 2)||($force ==1))
        {
            $score = 4 + $ret[3];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_69($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 3*min($ret[1], $ret[3], $ret[2], $ret[0]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_70($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 4)||($force ==1))
        {
            $score = 11;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_71($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 2)||($force ==1))
        {
            $score = 7;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_72($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 5;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            self::DbQuery( "UPDATE player set wild = wild +2  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->MajPannel($player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_73($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 2)||($force ==1))
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

    public static function Kyoto_74($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 2)||($force ==1))
        {
            $score = 2*min($ret[2], $ret[4]);
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_75($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 3)||($force ==1))
        {
            $score = 5;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_76($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 2)||($force ==1))
        {
            $score = 3 + $ret[0];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_77($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 8;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("y",$player_id);
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_78($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 3)||($force ==1))
        {
            $score = 5;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_79($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 3 + $ret[1];
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Kyoto_80($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 8;
            self::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
            
                        
            return 1;
        }

        else
        {
            return 2;
        }
    }
    
    
    
    
}
