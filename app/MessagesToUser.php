<?php

namespace MetodikaTI;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MessagesToUser extends Model
{

    public $appends = ['post_time'];


    public function get_from(){
        return $this->hasOne(AppUser::class, "id", "from_message");
    }


    public function get_to(){
        return $this->hasOne(AppUser::class, "id", "to_message");
    }
    


    public function getPostTimeAttribute(){

        $created_at = Carbon::createFromFormat("Y-m-d H:i:s", $this->created_at);
        $now = Carbon::now();


        //dd( $created_at->diffInYears($now) );

        //Primero revisamos años de antiguedad
//        if($created_at->diffInYears($now) > 0){
//            $dif = $created_at->diffInYears($now);
//            if( $dif == 1 ){
//                return $dif . " año";
//            }else{
//                return $dif . " años";
//            }
//        }
//
//        if($created_at->diffInMonths($now) > 0){
//            $dif = $created_at->diffInMonths($now);
//            if( $dif == 1 ){
//                return $dif . " mes";
//            }else{
//                return $dif . " meses";
//            }
//        }

        if($created_at->isToday()){
            return $created_at->format("H:i");
        }

        setlocale(LC_ALL, 'es_ES');

        return $created_at->formatLocalized('%b %d %H:%M');


//        if($created_at->diffInMinutes($now) > 0){
//            $dif = $created_at->diffInMinutes($now);
//            if( $dif == 1 ){
//                return "Hace " . $dif . " minuto";
//            }else{
//                return "Hace " . $dif . " minutos";
//            }
//        }
//
//        if($created_at->diffInSeconds($now) > 0){
//            $dif = $created_at->diffInSeconds($now);
//            if( $dif == 1 ){
//                return "Hace " . $dif . " segundo";
//            }else{
//                return "Hace " . $dif . " segundos";
//            }
//        }

    }



}
