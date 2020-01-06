<?php

namespace MetodikaTI\Http\Controllers\Back\Dashboard\System;

use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Http\Requests\Back\System\Permitions\CreatePermitionsRequest;
use MetodikaTI\Library\Pastora;
use MetodikaTI\Library\URI;
use MetodikaTI\Permission;
use MetodikaTI\SystemModule;
use MetodikaTI\UserProfile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserProfile::where('id', '!=', 1)->get();

        return view('back.dashboard.system.profile.home', array('data' => $data, 'permitions' => URI::checkPermitions()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.dashboard.system.profile.create', array('modules' => Pastora::moduleTree()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePermitionsRequest $request)
    {

        $permits = array();
        foreach ($request->parent as $module_id => $parent){
            //dd($key, $parent);
            if($parent == "1"){
                $permits[$module_id] = array(1,1,1,1);
            }else{
                $permits[$module_id] = array(0,0,0,0);
            }
        }

        foreach ($request->child as $module_id => $parent){

            $view = 0;
            $create = 0;
            $delete = 0;
            $update = 0;
            foreach ($parent as $action => $permited){
                if($action == "view"){        if($permited == "1"){   $view = 1;     }  }
                if($action == "create"){      if($permited == "1"){   $create = 1;   }  }
                if($action == "delete"){      if($permited == "1"){   $delete = 1;   }  }
                if($action == "update"){      if($permited == "1"){   $update = 1;   }  }
            }

            $permits[$module_id] = array($view,$create,$delete,$update);
        }

        $profile = new UserProfile();
        $profile->name = $request->nombre;
        $profile->permits = json_encode($permits);
        $profile->save();


        $response = array(
            'status' => true,
            'message' => 'Se ha guardado con éxito el nuevo perfil.',
            'url' => route('profile_index'),
        );


        return response()->json($response);

    }

    /** This method get the right json for each user's permits
     * @param $modules modules with the permits checkeds
     * @return string return a json with all permise for the profile
     */
    private function jsonPermits($modules) {
        $permissions = Permission::all();
        $json = array();

        foreach (array_keys($modules) as $key => $value) {

            $json[$value] = 0;

            foreach ($modules[$value] as $clave => $valor) {
                foreach ($permissions as $permission) {
                    if($permission->name == $valor) {
                        $json[$value] = $json[$value] + $permission->bit;
                    }
                }
            }

            //Se revisa si tiene papa el modulo
            $parent = SystemModule::where('id', '=', $value)->where('parent', '<>', 0);
            if ($parent->count() > 0) {
                $parent = $parent->first();
                if (!array_key_exists($parent->parent, $json)) {
                    $json[$value] = 15;
                }
            }

        }

        return json_encode($json);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = base64_decode($id);
        $modules = Pastora::moduleTree();
        return view('back.dashboard.system.profile.view', compact('id', 'modules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = base64_decode($id);

        $user_profile = UserProfile::find($id);
        $modules_db = json_decode($user_profile->permits);

        return view('back.dashboard.system.profile.update', ["id" => $id, "modules_user" => $modules_db, "modules" => Pastora::moduleTree(), "user_profile" => $user_profile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $response = [
            'status' => true,
            'message' => 'Se ha guardado con éxito el nuevo perfil.',
            'url' => route('profile_index'),
        ];

        $permits = array();
        foreach ($request->parent as $module_id => $parent){
            //dd($key, $parent);
            if($parent == "1"){
                $permits[$module_id] = array(1,1,1,1);
            }else{
                $permits[$module_id] = array(0,0,0,0);
            }
        }


        foreach ($request->child as $module_id => $parent){
            $view = 0;
            $create = 0;
            $delete = 0;
            $update = 0;
            foreach ($parent as $action => $permited){
                if($action == "view"){        if($permited == "1"){   $view = 1;     }  }
                if($action == "create"){      if($permited == "1"){   $create = 1;   }  }
                if($action == "delete"){      if($permited == "1"){   $delete = 1;   }  }
                if($action == "update"){      if($permited == "1"){   $update = 1;   }  }
            }

            $permits[$module_id] = array($view,$create,$delete,$update);
        }

        ksort($permits);


        $profile = UserProfile::find($request->id);
        $profile->name = $request->nombre;
        $profile->permits = json_encode($permits);
        $profile->save();

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $response = array(
            'status' => true,
            'message' => 'El perfil ha sido eliminado correctamente.',
            'url' => route('profile_index'),
        );

        $profile = UserProfile::find(base64_decode($id));
        if($profile != null) {
            if(!$profile->delete()) {
                $response = [
                    'message' => 'El perfil no se encuentra dado de alta en el sistema.',
                    'status' => false
                ];
            }
        } else {
            $response = [
                'message' => 'El perfil no se encuentra dado de alta en el sistema.',
                'status' => false
            ];
        }

        return response()->json($response);
    }

    public function getData(Request $request)
    {
        $data = UserProfile::find($request->id);
        return response()->json($data);
    }
}
