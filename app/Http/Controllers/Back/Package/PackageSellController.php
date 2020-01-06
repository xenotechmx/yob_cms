<?php

namespace MetodikaTI\Http\Controllers\Back\Package;

use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Http\Requests\Back\Package\CreateRequest;
use MetodikaTI\Http\Requests\Back\Package\EditRequest;
use MetodikaTI\Library\URI;
use MetodikaTI\PackageSell;

class PackageSellController extends Controller
{

    public function index(){

        $data = PackageSell::get();
        return view("back.package.index", ["data" => $data, "permitions" => URI::checkPermitions()]);
    }


    public function create(){

        return view("back.package.create");

    }


    public function store(CreateRequest $request){

        $response = array();
        $response["status"] = false;
        $response["message"] = "";
        $response["url"] = "";

        $package = new PackageSell();
        $package->name = $request->name;
        $package->duration_plan_in_days = $request->duration_plan_in_days;

        if( $request->ilimited_total_jobs_to_post == null ){
            $package->total_jobs_to_post = $request->total_jobs_to_post;
        }else{
            $package->total_jobs_to_post = -1;
        }

        if( $request->ilimited_total_profiles_to_view == null ){
            $package->total_profiles_to_view = $request->total_profiles_to_view;
        }else{
            $package->total_profiles_to_view = -1;
        }

        $package->duration_in_days = $request->duration_in_days;

        if( $request->ilimited_jobs_destacados == null ){
            $package->destacable = $request->jobs_destacados;
        }else{
            $package->destacable = -1;
        }

        $package->price = $request->price;

        if( $package->save() ){
            $response["status"] = true;
            $response["message"] = "El registro se ha dado de alta correctamente.";
            $response["url"] = route("paquetes.index");
        }else{
            $response["status"] = false;
            $response["message"] = "No hemos podido dar de alta el registro, intentalo nuevamente.";
        }

        return response()->json($response);
    }


    public function edit($id){

        $id = base64_decode($id);

        $data = PackageSell::find($id);

        return view("back.package.edit", ["data" => $data]);

    }


    public function update(EditRequest $request, $id){

        $response = array();
        $response["status"] = false;
        $response["message"] = "";
        $response["url"] = "";

        $id = base64_decode($id);

        $package = PackageSell::find($id);
        $package->name = $request->name;
        $package->duration_plan_in_days = $request->duration_plan_in_days;

        if( $request->ilimited_total_jobs_to_post == null ){
            $package->total_jobs_to_post = $request->total_jobs_to_post;
        }else{
            $package->total_jobs_to_post = -1;
        }

        if( $request->ilimited_total_profiles_to_view == null ){
            $package->total_profiles_to_view = $request->total_profiles_to_view;
        }else{
            $package->total_profiles_to_view = -1;
        }

        $package->duration_in_days = $request->duration_in_days;

        if( $request->ilimited_jobs_destacados == null ){
            $package->destacable = $request->jobs_destacados;
        }else{
            $package->destacable = -1;
        }

        $package->price = $request->price;

        if( $package->save() ){
            $response["status"] = true;
            $response["message"] = "El registro se ha editado correctamente.";
            $response["url"] = route("paquetes.index");
        }else{
            $response["status"] = false;
            $response["message"] = "No hemos podido editar el registro, intentalo nuevamente.";
        }

        return response()->json($response);

    }


    public function destroy($id){

        $id = base64_decode($id);

        $data = PackageSell::find($id);

        if( $data != null ){

            if( $data->delete() ){
                $response["status"] = true;
                $response["message"] = "Se ha eliminado el registro correctamente.";
                $response["url"] = route("paquetes.index");
            }else{
                $response["status"] = false;
                $response["message"] = "No se ha podido eliminar el registro, intentalo nuevamente.";
            }

        }else{
            $response["status"] = false;
            $response["message"] = "No se ha podido eliminar el registro, intentalo nuevamente.";
        }

        return response()->json($response);
    }


}
