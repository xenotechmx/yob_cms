<?php

namespace MetodikaTI;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{

    public $appends = ['photo_user', 'age'];

    public function getPhotoUserAttribute(){
        if( $this->photo != "" ){
            return url($this->photo);
        }else{
            return "assets/img/icon_user.png";
        }
    }


    public function job_experiences(){
        return $this->hasMany(JobExperience::class, "app_user_id", "id");
    }


    public function study_experiences(){
        return $this->hasMany(StudyExperience::class, "app_user_id", "id");
    }


    public function getAgeAttribute(){

        if($this->birthday != null){
            return Carbon::createFromFormat("Y-m-d", $this->birthday)->age;
        }else{
            return "";
        }

    }


    public function getUuids(){
        return UuidDevice::where("app_user_id", $this->id)->pluck("uuid")->toArray();
    }

}
