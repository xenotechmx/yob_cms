<?php

namespace MetodikaTI;

use Illuminate\Database\Eloquent\Model;

class JobExperience extends Model
{

    public $appends = ['duration_translate'];

    function getDurationTranslateAttribute(){
        if( $this->duration == "menos_1" ){
            return "Menos de 1 año";
        }else if( $this->duration == "entre_1_2" ){
            return "Entre 1 y 2 años";
        }else if( $this->duration == "entre_2_3" ){
            return "Entre 2 y 3 años";
        }else if( $this->duration == "mas_3" ){
            return "Más de 3 años";
        }

    }

}
