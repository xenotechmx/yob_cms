<?php

namespace MetodikaTI\Http\Controllers\Back\Dashboard\Catalog;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use MetodikaTI\Clients;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Http\Requests\Back\Catalog\Client\CreateClientRequest;
use MetodikaTI\Http\Requests\Back\Catalog\Client\EditClientRequest;
use MetodikaTI\Http\Requests\Back\Catalogo\Offers\CreateOfferRequest;
use MetodikaTI\Http\Requests\Back\Catalogo\Offers\EditOfferRequest;
use MetodikaTI\Library\URI;
use MetodikaTI\SystemModule;
use MetodikaTI\UserProfile;

class ClientsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


//        $module_permited_to_view = URI::getModulesPermitedToView();
//        $parents = SystemModule::where('parent', 0)->whereIn("id", $module_permited_to_view)->get();
//        $data = array('parents'=>$parents,);
//        foreach ($parents as $kParent => $parent) {
//            $children = SystemModule::where('parent', $parent->id)->whereIn("id", $module_permited_to_view)->orderBy('id')->get();
//            $data[$parent->id]['children'] = $children;
//        }

//        dd($data);





        $data = Clients::get();
        return view('back.dashboard.catalog.clients.index', array('data'=>$data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('back.dashboard.catalog.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request)
    {

        //name
        //type
        //reservacion_percent_deal
        //amenidades_include
        //date_start_deal
        //date_finish_deal


        $response = [
            'status' => false,
            'message' => 'No se ha podido crear el registro'
        ];

        DB::beginTransaction();

        $data = new Clients();
        $data->business_name = $request->business_name;
        $data->address       = $request->address;
        $data->name     = $request->user_name;
        $data->email         = $request->email;
        $data->phone         = $request->phone;
        $data->password      = bcrypt($request->password);
        $data->user_profile_id      = 2;


        if($data->save()){

            DB::commit();

            $response = [
                'status' => true,
                'message' => 'Se ha creado el registro con exito.',
                'url' => url("cms/dashboard/catalogo/clientes/")
            ];

        }else{

            DB::rollBack();

            $response = [
                'status' => false,
                'message' => 'No se ha podido crear el registro, intentalo nuevamente'
            ];

        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \MetodikaTI\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function show(Pdf $pdf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \MetodikaTI\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $id = base64_decode($id);

        $data = Clients::find($id);

        return view('back.dashboard.catalog.clients.edit', ['id' => $id, 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \MetodikaTI\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function update(EditClientRequest $request, $id)
    {


        $response = [
            'status' => false,
            'message' => 'No se ha podido editar el registro'
        ];

        DB::beginTransaction();

        $data = Clients::find($id);
        $data->business_name = $request->business_name;
        $data->address       = $request->address;
        $data->name     = $request->user_name;
        $data->email         = $request->email;
        $data->phone         = $request->phone;

        if( $request->password != "" ){
            $data->password      = bcrypt($request->password);
        }

        if($data->save()){

            DB::commit();

            $response = [
                'status' => true,
                'message' => 'Se ha editado el registro con exito.',
                'url' => url("cms/dashboard/catalogo/clientes/")
            ];

        }else{

            DB::rollBack();

            $response = [
                'status' => false,
                'message' => 'No se ha podido editar el registro, intentalo nuevamente'
            ];

        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \MetodikaTI\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $id = base64_decode($id);

        $response = [
            'status' => false,
            'message' => 'No se ha podido eliminar el registro.'
        ];

        $data = Clients::find($id);

        if ($data->delete()) {

            $response = [
                'status' => true,
                'message' => 'Se ha eliminado con éxito el registro.',
                'url' => url('cms/dashboard/catalogo/clientes')
            ];
        }

        return response()->json($response);
    }



}
