<?php

namespace MetodikaTI\Http\Controllers\Back\Dashboard\System;

use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Http\Requests\Back\System\User\CreateRequest;
use MetodikaTI\Http\Requests\Back\System\User\EditRequest;
use MetodikaTI\Http\Requests\Back\System\User\EditUniqueRequest;
use MetodikaTI\Library\URI;
use MetodikaTI\User;
use MetodikaTI\UserProfile;

class UserController extends Controller
{


    public function index()
    {

        $data = User::where('id', '!=', 1)->get();

        return view('back.dashboard.system.user.index', array('data'=>$data, 'permitions' => URI::checkPermitions()));
    }


    public function create()
    {
        $profiles = UserProfile::where('id', '!=', 1)->get();
        return view('back.dashboard.system.user.create', array('profiles'=>$profiles));
    }


    public function store(CreateRequest $request)
    {
        $response = array('status' => false);

        $user = new User();
        $user->name = $request->nombre;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->user_profile_id =  $request->perfil;

        if($user->save()) {
            $response['status'] = true;
            $response["message"] = "El usuario se ha registrado correctamente.";
            $response['url'] = route('user_index');
        }

        return response()->json($response);

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {

        $user = User::find(base64_decode($id));

        if ($user != null) {
            $profiles = UserProfile::where('id', '!=', 1)->get();
            return view('back.dashboard.system.user.edit', ['user' => $user, 'profiles' => $profiles]);
        } else {
            return redirect()->route('user_index');
        }

    }


    public function update(EditRequest $request, $id)
    {
        $response = array('status'=>false);
        $user = User::find(base64_decode($id));
        $user->name = $request->nombre;
        $user->email = $request->email;
        $user->user_profile_id = $request->perfil;

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->save()) {
            $response = [
                'status' => true,
                'url' => route('user_index'),
                'message' => "Se ha editado el usuario correctamente."
            ];
        }

        return response()->json($response);
    }


    public function destroy($id)
    {
        $response = array(
            'status' => true,
            'message' => 'El usuario ha sido eliminado correctamente.',
            'url' => route('user_index'),
        );

        $profile = User::find(base64_decode($id));
        if($profile != null) {
            if(!$profile->delete()) {
                $response = [
                    'message' => 'El usuario no se encuentra dado de alta en el sistema.',
                    'status' => false
                ];
            }
        } else {
            $response = [
                'message' => 'El usuario no se encuentra dado de alta en el sistema.',
                'status' => false
            ];
        }

        return response()->json($response);
    }







    public function edit_unique($id_user){

        $user = User::find(base64_decode($id_user));

        if ($user != null) {
            $profiles = UserProfile::where('id', '!=', 1)->get();
            return view('back.dashboard.system.user.edit_unique', ['user' => $user, 'profiles' => $profiles]);
        } else {
            return redirect()->route('user_index');
        }

    }


    public function update_unique(EditUniqueRequest $request, $id)
    {

        $response = array('status'=>false);
        $user = User::find(base64_decode($id));
        $user->name = $request->nombre;
        $user->email = $request->email;
        //$user->user_profile_id = $request->perfil;

        if ($request->password != "") {
            $user->password = bcrypt($request->password);
        }

        if($request->hasFile("profile_image")){
            $file_name = md5(date("Y-m-d H:i:s")).".".$request->file('profile_image')->getClientOriginalExtension();
            $request->file('profile_image')->move("assets/images/users/", $file_name );

            if( file_exists($user->profile_image) ){
                unlink($user->profile_image);
            }

            $user->profile_image = "assets/images/users/".$file_name;
        }

        if ($user->save()) {
            $response = [
                'status' => true,
                'url' => route('user_unique_edit', $id),
                'message' => "Se ha editado tu perfil correctamente."
            ];
        }

        return response()->json($response);
    }


}
