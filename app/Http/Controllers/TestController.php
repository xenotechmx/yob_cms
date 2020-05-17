<?php

namespace MetodikaTI\Http\Controllers;

use Auth;
use Carbon\Carbon;
use GuzzleHttp;
use Illuminate\Support\Facades\Mail;
use LaravelQRCode\Facades\QRCode;
use MetodikaTI\AppUser;
use MetodikaTI\Http\Controllers\API\APIController;
use MetodikaTI\Invoice;
use MetodikaTI\PackagesBuyedByUser;
use MetodikaTI\PackageSell;
use MetodikaTI\Reservation;
use MetodikaTI\SystemModule;
use MetodikaTI\User;
use Permission;
use Session;

class TestController extends Controller
{
    public function test(){

        $job = Job::find(10183);
        $empresa = AppUser::find(3086);
        $candidato = AppUser::find(1453);

        dump("los uuids", $empresa->getUuids());

        //Enviamos la notificacion push a la empresa
        $notification = array();
        $notification["UUID"] = $empresa->getUuids();
        $notification["TEXTO_NOTIFICACION"] = "Tienes un nuevo candidato en tu vacante '" . $job->job_title . "'. Ingresa a la aplicación para más información.";
        $notification["TITLE"] = "Tienes un candidato postulado a tu vacante";
        $notification["ACTION"] = array("open_profile" => $candidato->id);


        $API_ACCESS_KEY = 'AAAAEe2eHOE:APA91bF-_KM1CNWYNdTXTvdPkNcwFY_WmZICpwfsWunfHga1RoGzBto9znVEN_Q1KfBm7Cf8UKvzUJjOYeazkxUuZnkMbcK3v7a51pthHxTHgvjXluASOJ90nJJTzCr4ZZx7PGTr8al3';

        $instructions = array();
        $instructions["action"] = (isset($notification["ACTION"]) ? $notification["ACTION"] : "");

        if (is_array($notification["UUID"])) {
            
            dump("in is array");

            foreach($notification["UUID"] as $uuid){
                dump ("uuid", $uuid);

                $message = [
                    'notification' => [
                        'title' => $notification["TITLE"],
                        'body' => $notification["TEXTO_NOTIFICACION"],
                        "text" => $notification["TEXTO_NOTIFICACION"]
                    ],
                    'to' => $uuid,
                    "priority"=> "high",
                ];
        
                $client = new GuzzleHttp\Client([
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'key='.$API_ACCESS_KEY,
                    ]
                ]);
        
                $response = $client->post('https://fcm.googleapis.com/fcm/send',
                    ['body' => json_encode($message)]
                );
        
                //return $response->getBody();
            }

        } else {
            $message = [
                'notification' => [
                    'title' => $notification["TITLE"],
                    'body' => $notification["TEXTO_NOTIFICACION"],
                    "text" => $notification["TEXTO_NOTIFICACION"]
                ],
                'to' => $notification["UUID"],
                "priority"=> "high",
            ];
    
            $client = new GuzzleHttp\Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'key='.$API_ACCESS_KEY,
                ]
            ]);
    
            $response = $client->post('https://fcm.googleapis.com/fcm/send',
                ['body' => json_encode($message)]
            );
    
            return $response->getBody();
        }
    }
}
