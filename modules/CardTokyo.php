<?php

use Bga\GameFramework\Table;

    class CardTokyo
{
    
    
    public static function Tokyo_1($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 2)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[4]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_2($player_id, $day, $force=0)
    {
        
        
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 3)||($force ==1))
        {
            $score = 3 + $ret[3];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_3($player_id, $day, $force=0)
    {
        
        
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[3] >= 2)&&($ret[0] >= 2))||($force ==1))
        {
            $score = 8;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_4($player_id, $day, $force=0)
    {
        
        
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 3)||($force ==1))
        {
            $score =7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_5($player_id, $day, $force=0)
    {
        
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[1] >= 2)&&($ret[0] >= 2))||($force ==1))
        {
            $score = 3 + $ret[1];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_6($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 2)||($force ==1))
        {
            $score = 2*min($ret[0], $ret[1]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_7($player_id, $day, $force=0)
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
                $tokyo = count(Table::getObjectListFromDB( "SELECT card_id id FROM tokyo WHERE  card_location_arg = {$player_id} AND finallocation = 1 AND card_location LIKE 'cardposition_{$d}%'", true ));
                $kyoto = count(Table::getObjectListFromDB( "SELECT card_id id FROM kyoto WHERE  card_location_arg = {$player_id} AND finallocation = 1 AND card_location LIKE 'cardposition_{$d}%'", true ));
                $count = $tokyo + $kyoto;

                if( $count == $trip[$i])
                {
                    $found = $found+1;
                }
                
                
            }

            $score = 3*$found;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_8($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 2*min($ret[0], $ret[2]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_9($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 4)||($force ==1))
        {
            $score = 2*min($ret[0], $ret[3]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_10($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 8;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_11($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 3)||($force ==1))
        {
            $score = 2*min($ret[1], $ret[8]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_12($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 2)||($force ==1))
        {
            $score = 7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_13($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 4)||($force ==1))
        {
            $score = 14;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_14($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[6] >= 2)||($force ==1))
        {
            $score = 6;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("y",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function Tokyo_15($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[10] >= 2)||($force ==1))
        {
            $score = 8;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function Tokyo_16($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 2)||($force ==1))
        {
            $score = 6;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function Tokyo_17($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[1] >= 1)&&($ret[0] >= 2))||($force ==1))
        {
            $score = 4 + $ret[1];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_18($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 2)||($force ==1))
        {
            $score = 8;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("y",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_19($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 6;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_20($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 2)||($force ==1))
        {
            $score = 6;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_21($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[3] >= 3)&&($ret[2] >= 3))||($force ==1))
        {
            $score = 11;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_22($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[3] >= 3)&&($ret[1] >= 3))||($force ==1))
        {
            $score = 10;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_23($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[1]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_24($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 2)||($force ==1))
        {
            $score = 3 + $ret[2];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_25($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 2)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[2]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_26($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 2)||($force ==1))
        {
            $score = 5;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_27($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 3)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[0]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_28($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 2)||($force ==1))
        {
            $score = 8;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("h1",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_29($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 2)||($force ==1))
        {
            $score = 4 + $ret[2];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_30($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[6] >= 2)||($force ==1))
        {
            $score = 7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("y",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_31($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 4)||($force ==1))
        {
            $score = 3 + $ret[3];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_32($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 2)||($force ==1))
        {
            $score = 4;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
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

    public static function Tokyo_33($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 1)||($force ==1))
        {
            $score = 3;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
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

    public static function Tokyo_34($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 3)||($force ==1))
        {
            $score = 5 + $ret[7];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_35($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[5] >= 3)||($force ==1))
        {
            $score = 4 + $ret[2];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_36($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[6] >= 3)||($force ==1))
        {
            $score = 6;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("y",$player_id);
            Table::DbQuery( "UPDATE player set wild = wild +1  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->MajPannel($player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_37($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 3)||($force ==1))
        {
            $score = 5;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_38($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 2)||($force ==1))
        {
            $score = 6;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("g",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_39($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[1] >= 2)&&($ret[4] >= 2))||($force ==1))
        {
            $score = 5 + $ret[4];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_40($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] == 0)||($force ==1))
        {
            $score = 4 + $ret[1];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_41($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 1)||($force ==1))
        {
            $score = 5 + $ret[4];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_42($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[6] >= 4)||($force ==1))
        {
            $score = 2*$ret[6];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_43($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[10] >= 3)||($force ==1))
        {
            $score = 5 + $ret[4];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_44($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[4]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_45($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 3*min($ret[1], $ret[3], $ret[2], $ret[0]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_46($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[3] >= 2)&&($ret[0] >= 2))||($force ==1))
        {
            $score = 3 + $ret[0];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
           
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_47($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 2)||($force ==1))
        {
            $score = 5;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("y",$player_id);
            letsgotojapan::$instance->Gain("y",$player_id);
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_48($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 2)||($force ==1))
        {
            $score = 7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_49($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 1)||($force ==1))
        {
            $score = 8;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("a1",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_50($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 4)||($force ==1))
        {
            $score = 5 + $ret[4];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_51($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_52($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 2)||($force ==1))
        {
            $score = 5;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_53($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[3] >= 3)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[1]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_54($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = $ret[0];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("b",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_55($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[0] >= 3)||($force ==1))
        {
            $score = 7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_56($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[7] >= 2)||($force ==1))
        {
            $score = 5;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
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

    public static function Tokyo_57($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 2)||($force ==1))
        {
            $score = 5 + $ret[5];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_58($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 4)||($force ==1))
        {
            $score = 3;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
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

    public static function Tokyo_59($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 5 + $ret[8];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_60($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 2*min($ret[2], $ret[1]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }


    public static function Tokyo_61($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 3 + $ret[1];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_62($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[6] >= 3)||($force ==1))
        {
            $score = 8;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_63($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 2)||($force ==1))
        {
            $score = 6;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_64($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[0] >= 1)&&($ret[5] >= 1))||($force ==1))
        {
            $score = 5;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("r",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }
    
    public static function Tokyo_65($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[0] >= 3)&&($ret[1] >= 3))||($force ==1))
        {
            $score = 11;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_66($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[4] >= 2)&&($ret[3] >= 2))||($force ==1))
        {
            $score = 2*min($ret[0], $ret[3]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_67($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[9] >= 2)||($force ==1))
        {
            $score = 5;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("y",$player_id);
            letsgotojapan::$instance->Gain("y",$player_id);
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_68($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("y",$player_id);
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_69($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[2] >= 4)||($force ==1))
        {
            $score = 2*min($ret[2], $ret[1]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_70($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 2)||($force ==1))
        {
            $score = 6;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("g",$player_id);
            letsgotojapan::$instance->Gain("g",$player_id);
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_71($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[0] >= 1)&&($ret[1] >= 1)&&($ret[4] >= 1))||($force ==1))
        {
            $score = 7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_72($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 2*min($ret[0], $ret[1]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_73($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[9] >= 2)||($force ==1))
        {
            $score = 7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("p",$player_id);
            
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_74($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 2)||($force ==1))
        {
            $score = 7;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("p",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_75($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 2)||($force ==1))
        {
            $score = 3 + $ret[1];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_76($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if((($ret[3] >= 1)&&($ret[1] >= 1))||($force ==1))
        {
            $score = 3 + $ret[0];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_77($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 3)||($force ==1))
        {
            $score = 2*min($ret[3], $ret[2]);
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_78($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[8] >= 2)||($force ==1))
        {
            $score = 9;
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            letsgotojapan::$instance->Gain("a2",$player_id);
            letsgotojapan::$instance->Gain("b",$player_id);
            
            
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_79($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[1] >= 4)||($force ==1))
        {
            $score = 3 + $ret[1];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }

    public static function Tokyo_80($player_id, $day, $force=0)
    {
        $ret = letsgotojapan::$instance->EtatToken($player_id);
        
        if(($ret[4] >= 4)||($force ==1))
        {
            $score = 6 + $ret[4];
            Table::DbQuery( "UPDATE player set {$day} = {$day} + {$score}  WHERE player_id = {$player_id}" );
            
            
        return 1;
        }

        else
        {
            return 2;
        }
    }











    
    
    
    
}

   
    
    
    
    
