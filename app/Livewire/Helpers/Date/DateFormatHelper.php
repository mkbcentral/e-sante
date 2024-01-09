<?php

namespace App\Livewire\Helpers\Date;

use Carbon\Carbon;

class DateFormatHelper
{
//Formatter la date dd/mm/yyyy à Y-d-m
    public static function formatDate($date):string{
        return Carbon::createFromFormat('d/m/Y',$date)->format('Y-m-d');
    }
    // Get Age of users
    public static function getUserAge($date){
        $count_month=0;
        $age=date('Y') - Carbon::parse($date)->format('Y');
        if ($age==0) {
            $months=array();
            $month= Carbon::parse($date)->format('m');
            if ($month<10) {
                $month=ltrim($month, "0");
            }
            $current_month=date('m');
            if ($current_month<10) {
                $current_month=ltrim($current_month, "0");
            }
            for ($i=$month; $i <=$current_month ; $i++) {
                $months[$i]=$i;
            }
            $count_month=count($months);
            //Get days number
            $days_numbers= cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
            if ($count_month == 1) {
                if ($days_numbers<31 OR $days_numbers<30) {
                    //$day=Carbon::createFromFormat('d/m/Y', $date)->format('d');
                    $day= Carbon::parse($date)->format('d');
                    $days=array();
                    if($day<9){
                        $day=ltrim($day,"0");
                    }
                    for ($i=$day; $i <= date('d'); $i++) {
                        $days[]=$i;
                    }
                    $days_count=count($days);

                    if ($days_count==7) {
                        return '1 Semaine' ;
                    } elseif($days_count==14) {
                        return '2 Semaines' ;
                    }elseif($days_count==21){
                        return '3 Semaines' ;
                    }elseif($days_count==28){
                        return '7 Semaines' ;
                    }else{
                        return $days_count==1?'1 Jour':$days_count." Jours" ;
                    }
                }

            }else{
                return $count_month.' Mois' ;
            }
        }else{
            return $age==1?$age.' An':$age.' Ans';
        }
    }

    //Get months of year
    public static function getFrMonths():array{
        return [
            ['name'=>'JANVIER','number'=>'01'],
            ['name'=>'FEVRIER','number'=>'02'],
            ['name'=>'MARS','number'=>'03'],
            ['name'=>'AVRIL','number'=>'04'],
            ['name'=>'MAI','number'=>'05'],
            ['name'=>'JUIN','number'=>'06'],
            ['name'=>'JUILLET','number'=>'07'],
            ['name'=>'AOUT','number'=>'08'],
            ['name'=>'SEPTEMBRE','number'=>'09'],
            ['name'=>'OCTOBRE','number'=>'10'],
            ['name'=>'NOVEMBRE','number'=>'11'],
            ['name'=>'DECEMBRE','number'=>'12'],
        ];
    }
    //Get years aléatoires
    public function getYearsAleatoire():array{
        return [
            '2022',
            '2023',
            '2024',
            '2025',
            '2026',
            '2027',
            '2028',
            '2029',
            '2030'
        ];
    }
}
