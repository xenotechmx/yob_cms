<?php

namespace MetodikaTI\Http\Controllers\Back\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use MetodikaTI\AppUserInvoice;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Invoice;
use MetodikaTI\Library\Pastora;
use MetodikaTI\Library\URI;
use MetodikaTI\PackagesBuyedByUser;
use MetodikaTI\PackageSell;

class PurchasesController extends Controller
{

    public function index()
    {

        //Datos para grafica
        $packages = PackageSell::withTrashed()->get();
        $data_graph = array();

        foreach ($packages as $package) {

            $single_data = array();
            $single_data["name"] = $package->name;
            $single_data["total"] = PackagesBuyedByUser::where("package_id", $package->id)->where("status", "APPROVED")->count();

            $data_graph[] = $single_data;

        }

        //Datos para tabla
        $data = PackagesBuyedByUser::with(["get_user"])->orderBy("created_at", "DESC")->withTrashed()->get();

        //Approved vs no aprooved
        $approved_vs_pending = DB::select(DB::RAW("SELECT status, count(status) as total FROM packages_buyed_by_users GROUP BY status"));


        return view("back.reports.purchases.index", ["data" => $data, "data_graph" => $data_graph, "approved_vs_pending" => $approved_vs_pending, "permitions" => URI::checkPermitions()]);
    }


    public function create()
    {

        return view("back.reports.purchases.create");

    }


    public function store(CreateRequest $request)
    {

        $response = array();
        $response["status"] = false;
        $response["message"] = "";
        $response["url"] = "";

        $package = new PackageSell();
        $package->name = $request->name;
        $package->duration_plan_in_days = $request->duration_plan_in_days;

        if ($request->ilimited_total_jobs_to_post == null) {
            $package->total_jobs_to_post = $request->total_jobs_to_post;
        } else {
            $package->total_jobs_to_post = -1;
        }

        if ($request->ilimited_total_profiles_to_view == null) {
            $package->total_profiles_to_view = $request->total_profiles_to_view;
        } else {
            $package->total_profiles_to_view = -1;
        }

        $package->duration_in_days = $request->duration_in_days;

        if ($request->ilimited_jobs_destacados == null) {
            $package->destacable = $request->jobs_destacados;
        } else {
            $package->destacable = -1;
        }

        $package->price = $request->price;

        if ($package->save()) {
            $response["status"] = true;
            $response["message"] = "El registro se ha dado de alta correctamente.";
            $response["url"] = route("paquetes.index");
        } else {
            $response["status"] = false;
            $response["message"] = "No hemos podido dar de alta el registro, intentalo nuevamente.";
        }

        return response()->json($response);
    }


    public function edit($id)
    {

        $id = base64_decode($id);

        $data = PackageSell::find($id);

        return view("back.reports.purchases.edit", ["data" => $data]);

    }


    public function update(EditRequest $request, $id)
    {

        $response = array();
        $response["status"] = false;
        $response["message"] = "";
        $response["url"] = "";

        $id = base64_decode($id);

        $package = PackageSell::find($id);
        $package->name = $request->name;
        $package->duration_plan_in_days = $request->duration_plan_in_days;

        if ($request->ilimited_total_jobs_to_post == null) {
            $package->total_jobs_to_post = $request->total_jobs_to_post;
        } else {
            $package->total_jobs_to_post = -1;
        }

        if ($request->ilimited_total_profiles_to_view == null) {
            $package->total_profiles_to_view = $request->total_profiles_to_view;
        } else {
            $package->total_profiles_to_view = -1;
        }

        $package->duration_in_days = $request->duration_in_days;

        if ($request->ilimited_jobs_destacados == null) {
            $package->destacable = $request->jobs_destacados;
        } else {
            $package->destacable = -1;
        }

        $package->price = $request->price;

        if ($package->save()) {
            $response["status"] = true;
            $response["message"] = "El registro se ha editado correctamente.";
            $response["url"] = route("paquetes.index");
        } else {
            $response["status"] = false;
            $response["message"] = "No hemos podido editar el registro, intentalo nuevamente.";
        }

        return response()->json($response);

    }


    public function destroy($id)
    {

        $id = base64_decode($id);

        $data = PackageSell::find($id);

        if ($data != null) {

            if ($data->delete()) {
                $response["status"] = true;
                $response["message"] = "Se ha eliminado el registro correctamente.";
                $response["url"] = route("paquetes.index");
            } else {
                $response["status"] = false;
                $response["message"] = "No se ha podido eliminar el registro, intentalo nuevamente.";
            }

        } else {
            $response["status"] = false;
            $response["message"] = "No se ha podido eliminar el registro, intentalo nuevamente.";
        }

        return response()->json($response);
    }


    public function view_invoices($packaged_buyed_by_user_id)
    {
        
        $data = Invoice::where("packages_buyed_by_users_id", $packaged_buyed_by_user_id)->get();

        $packages_buyed_by_users = PackagesBuyedByUser::find($packaged_buyed_by_user_id);
        
        $invoice_data = AppUserInvoice::where("app_user_id", $packages_buyed_by_users->app_user_id)->first();


        return view("back.reports.purchases.view", ["data" => $data, "invoice_data" => $invoice_data, "packages_buyed_by_users" => $packages_buyed_by_users, "permitions" => URI::checkPermitions()]);

    }


    public function download_pdf($invoice_id)
    {

        $invoice = Invoice::find($invoice_id);

        $headers = array(
            'Content-Type: application/pdf',
        );

        $file_name = explode("/", $invoice->pdf_invoice);
        $file_name = $file_name[count($file_name) - 1];

        return Response::download($invoice->pdf_invoice, $file_name, $headers);

    }


    public function download_xml($invoice_id)
    {

        $invoice = Invoice::find($invoice_id);

        $headers = array(
            'Content-Type: application/xml',
        );

        $file_name = explode("/", $invoice->xml_invoice);
        $file_name = $file_name[count($file_name) - 1];

        return Response::download($invoice->xml_invoice, $file_name, $headers);

    }


    public function download_wrong_xml($invoice_id)
    {

        $invoice = Invoice::find($invoice_id);

        $file_name = "cfdi_mal_formado_" . $invoice_id . "_" . $invoice->packages_buyed_by_users_id . ".xml";

        return response($invoice->cfdi)
            ->withHeaders([
                'Content-Type' => 'application/xml',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'attachment; filename="' . $file_name . '"',
            ]);


    }


    public function generate_invoice($packages_buyed_by_users_id)
    {

        $response = array();
        $response["status"] = true;
        $response["message"] = "Se ha enviado la solicitud para generar la factura.";
        $response["url"] = route("purchasesreport.view", $packages_buyed_by_users_id);

        Pastora::generateInvoice($packages_buyed_by_users_id);

        return response()->json($response);
    }

}
