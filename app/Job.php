<?php

namespace MetodikaTI;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{

    use SoftDeletes;

    public $appends = ['profile_image', 'post_time', 'languages', 'time_available'];


    public function categories(){
        return $this->hasOne(Category::class, "id", "category_id");
    }


    public function employer(){
        return $this->hasOne(AppUser::class, "id", "app_user_employe_id");
    }


    public function getProfileImageAttribute(){

        if( $this->employer["photo"] == "" ){
            return url("bussines_profile_picture/generic_user.svg");
        }else{
            return url($this->employer["photo"]);
        }

    }


    public function getPostTimeAttribute(){

        if($this->updated_at != null) {

            $created_at = Carbon::createFromFormat("Y-m-d H:i:s", $this->updated_at);
            $now = Carbon::now();


            //dd( $created_at->diffInYears($now) );

            //Primero revisamos años de antiguedad
            if ($created_at->diffInYears($now) > 0) {
                $dif = $created_at->diffInYears($now);
                if ($dif == 1) {
                    return "Hace " . $dif . " año";
                } else {
                    return "Hace " . $dif . " años";
                }
            }

            if ($created_at->diffInMonths($now) > 0) {
                $dif = $created_at->diffInMonths($now);
                if ($dif == 1) {
                    return "Hace " . $dif . " mes";
                } else {
                    return "Hace " . $dif . " meses";
                }
            }

            if ($created_at->diffInDays($now) > 0) {
                $dif = $created_at->diffInDays($now);
                if ($dif == 1) {
                    return "Hace " . $dif . " día";
                } else {
                    return "Hace " . $dif . " días";
                }
            }

            if ($created_at->diffInHours($now) > 0) {
                $dif = $created_at->diffInHours($now);
                if ($dif == 1) {
                    return "Hace " . $dif . " hora";
                } else {
                    return "Hace " . $dif . " horas";
                }
            }

            if ($created_at->diffInMinutes($now) > 0) {
                $dif = $created_at->diffInMinutes($now);
                if ($dif == 1) {
                    return "Hace " . $dif . " minuto";
                } else {
                    return "Hace " . $dif . " minutos";
                }
            }

            if ($created_at->diffInSeconds($now) > 0) {
                $dif = $created_at->diffInSeconds($now);
                if ($dif == 1) {
                    return "Hace " . $dif . " segundo";
                } else {
                    return "Hace " . $dif . " segundos";
                }
            }

        }else{
            return "";
        }

    }


    public function school_grade(){
        return $this->hasOne(SchoolGrade::class, "id", "school_grade_id");
    }


    public function getLanguagesAttribute(){
        return Language::whereIn("id", explode(",", $this->languages_id))->get();
        //return $this->hasMany(Language::class)->whereIn("id", explode(",", $this->languages_id));
    }


    public function getTimeAvailableAttribute(){

        if($this->disbaled_at != null) {

            $disabled_at = Carbon::createFromFormat("Y-m-d H:i:s", $this->disbaled_at);
            $now = Carbon::now();

            setlocale(LC_ALL, 'es_ES');

            if( $disabled_at->format("d-m-Y") == $now->format("d-m-Y") ){
                return "Finaliza hoy a las " . $disabled_at->formatLocalized('%H:%M hrs');
            }else{
                return "Finaliza el " . $disabled_at->formatLocalized('%d de %B del %Y %H:%M hrs');
            }


//            if ($disabled_at->diffInDays($now) > 0) {
//                $dif = $disabled_at->diffInDays($now);
//                if ($dif == 1) {
//                    return "Publicación finaliza en " . $dif . " día";
//                } else {
//                    return "Publicación finaliza en " . $dif . " días";
//                }
//            }
//
//            if ($disabled_at->diffInHours($now) > 0) {
//                $dif = $disabled_at->diffInHours($now);
//                if ($dif == 1) {
//                    return "Publicación finaliza en " . $dif . " hora";
//                } else {
//                    return "Publicación finaliza en " . $dif . " horas";
//                }
//            }
//
//            if ($disabled_at->diffInMinutes($now) > 0) {
//                $dif = $disabled_at->diffInMinutes($now);
//                if ($dif == 1) {
//                    return "Publicación finaliza en " . $dif . " minuto";
//                } else {
//                    return "Publicación finaliza en " . $dif . " minutos";
//                }
//            }
//
//            if ($disabled_at->diffInSeconds($now) > 0) {
//                $dif = $disabled_at->diffInSeconds($now);
//                if ($dif == 1) {
//                    return "Publicación finaliza en " . $dif . " segundo";
//                } else {
//                    return "Publicación finaliza en " . $dif . " segundos";
//                }
//            }

        }else{
            return "";
        }

    }





}
