<?php

namespace MetodikaTI;

use Illuminate\Database\Eloquent\Model;

class JobUserApply extends Model
{

    public $appends = ['post_time_apply'];

    public function getPostTimeApplyAttribute(){

        $created_at = Carbon::createFromFormat("Y-m-d H:i:s", $this->created_at);
        $now = Carbon::now();


        //dd( $created_at->diffInYears($now) );

        //Primero revisamos años de antiguedad
        if($created_at->diffInYears($now) > 0){
            $dif = $created_at->diffInYears($now);
            if( $dif == 1 ){
                return "Hace " . $dif . " año";
            }else{
                return "Hace " . $dif . " años";
            }
        }

        if($created_at->diffInMonths($now) > 0){
            $dif = $created_at->diffInMonths($now);
            if( $dif == 1 ){
                return "Hace " . $dif . " mes";
            }else{
                return "Hace " . $dif . " meses";
            }
        }

        if($created_at->diffInDays($now) > 0){
            $dif = $created_at->diffInDays($now);
            if( $dif == 1 ){
                return "Hace " . $dif . " día";
            }else{
                return "Hace " . $dif . " días";
            }
        }

        if($created_at->diffInHours($now) > 0){
            $dif = $created_at->diffInHours($now);
            if( $dif == 1 ){
                return "Hace " . $dif . " hora";
            }else{
                return "Hace " . $dif . " horas";
            }
        }

        if($created_at->diffInMinutes($now) > 0){
            $dif = $created_at->diffInMinutes($now);
            if( $dif == 1 ){
                return "Hace " . $dif . " minuto";
            }else{
                return "Hace " . $dif . " minutos";
            }
        }

        if($created_at->diffInSeconds($now) > 0){
            $dif = $created_at->diffInSeconds($now);
            if( $dif == 1 ){
                return "Hace " . $dif . " segundo";
            }else{
                return "Hace " . $dif . " segundos";
            }
        }

    }

}
