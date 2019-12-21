<?php

namespace MetodikaTI;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{

    public function checkPermitionByModule($module_id, $type){

        $modules = UserProfile::find($this->id);

        $modules = json_decode($modules->permits, true);

        $permited = "";
        if($type == "view"){
            if( $modules[$module_id][0] == 1 ){
                $permited = 1;
            }else{
                $permited = 0;
            }
        }else if($type == "create"){
            if( $modules[$module_id][1] == 1 ){
                $permited = 1;
            }else{
                $permited = 0;
            }
        }else if($type == "delete"){
            if( $modules[$module_id][2] == 1 ){
                $permited = 1;
            }else{
                $permited = 0;
            }
        }else if($type == "update"){
            if( $modules[$module_id][3] == 1 ){
                $permited = 1;
            }else{
                $permited = 0;
            }
        }

        return $permited;
    }

}
