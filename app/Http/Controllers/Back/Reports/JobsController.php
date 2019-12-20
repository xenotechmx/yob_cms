<?php

namespace MetodikaTI\Http\Controllers\Back\Reports;

use Illuminate\Http\Request;
use MetodikaTI\AppUser;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Job;
use MetodikaTI\Library\Pastora;
use MetodikaTI\Library\URI;
use MetodikaTI\PackagesBuyedByUser;

class JobsController extends Controller
{

    public function index()
    {

        //Datos para grafica
        $data = Job::with(["categories", "employer", "school_grade"])->where("publish", 1)->where("status", "publish")->get();
        $data_pending = Job::with(["categories", "employer", "school_grade"])->where("publish", 0)->where("status", "publish")->get();

        return view("back.reports.jobs.index", ["data" => $data, "data_pending" => $data_pending, "permitions" => URI::checkPermitions()]);
    }


    public function view($job_id)
    {

        $job_id = base64_decode($job_id);
        $job = Job::with(["categories", "employer", "school_grade"])->where("id", $job_id)->withTrashed()->first();

        $languages = $job->languages;
        $lang = "";
        foreach ($languages as $language) {
            $lang .= $language["language"] . ", ";
        }

        $lang = substr($lang, 0, strlen($lang) - 2);

        $job->lan = $lang;

        return view("back.reports.jobs.view", compact("job"))->render();
    }


    public function publish_job($job_id)
    {

        $response = [
            'status' => true,
            'message' => 'Se ha eliminado con éxito el registro.',
        ];

        $job = Job::find(base64_decode($job_id));
        $job->publish = 1;

        $empresa = AppUser::find($job->app_user_employe_id);

        if ($job->save()) {

            //Enviamos la notificacion push informativa
            $notification = array();
            $notification["UUID"] = $empresa->getUuids();
            $notification["TEXTO_NOTIFICACION"] = "Se ha publicado la vacante '" . $job->job_title . "' en Yob.";
            $notification["TITLE"] = "Se ha publicado tu vacante";
            $notification["ACTION"] = "";
            Pastora::sendPushNotification($notification);

            $response = [
                'status' => true,
                'message' => 'Se ha publicado con éxito el empleo.',
                'url' => url('cms/dashboard/resports/jobs')
            ];

        } else {

            $response = [
                'status' => false,
                'message' => 'No hemos podido publicar el empleo, intentalo nuevamente.',
            ];

        }

        return response()->json($response);
    }


    public function unpublish_job(Request $request, $job_id)
    {

        //$request->reason

        $response = [
            'status' => true,
            'message' => 'Se ha eliminado con éxito el registro.',
            'url' => "",
        ];

        //Colocamos el empleo como borrador
        $job = Job::find(base64_decode($job_id));
        $job->publish = 0;
        $job->unpublish_reason = $request->reason;
        $job->status = "eraser";
        $job->deleted_at = null;

        $empresa = AppUser::find($job->app_user_employe_id);

        if ($job->save()) {

            //Enviamos la notificacion push informativa
            $notification = array();
            $notification["UUID"] = $empresa->getUuids();
            $notification["TEXTO_NOTIFICACION"] = "Motivo de rechazo: " . $job->unpublish_reason . ". Te hemos reembolsado los créditos usados, edita la vacante y vuelve a publicarla.";
            $notification["TITLE"] = "Se ha rechazado la publicación de tu vacante";
            $notification["ACTION"] = array("edit_job" => $job->id);
            Pastora::sendPushNotification($notification);

            //Le regresamos los creditos del empleo
            //Obtenemos el paquete mas reciente para devolverle los creditos
            $packaged_buyed = PackagesBuyedByUser::where("id", $job->packages_buyed_by_users_id)->first();
            
            if ($packaged_buyed != null) {

                if ($packaged_buyed->count_total_jobs_to_post != -1) {
                    $packaged_buyed->increment("count_total_jobs_to_post");
                }

                if ($job->highlight_job == 1) {
                    if ($packaged_buyed->count_destacable != -1) {
                        $packaged_buyed->increment("count_destacable");
                    }
                }

                $packaged_buyed->save();
            }


            $response = [
                'status' => true,
                'message' => 'Se ha notificado al empleador el motivo del rechazo de la publicación.',
                'url' => url('cms/dashboard/resports/jobs')
            ];

        } else {

            $response = [
                'status' => false,
                'message' => 'No hemos podido publicar el empleo, intentalo nuevamente.',
            ];

        }

        return response()->json($response);
    }


}
