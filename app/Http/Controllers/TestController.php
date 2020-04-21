<?php

namespace MetodikaTI\Http\Controllers;

use Auth;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
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

        $notification = array();
        $notification["UUID"] = "diQnn-pXn40:APA91bFzTAE7LA-zNoEeWhLVOXgH0rzhVjE7aIhJMuxKMR6GPQ_ePEOFgjWpcTjP-Wgnm2AvFYpFl2IHM-rkIfEr2fKmsKqE7AoZtK6P7bSpMYbunnZvL6xuoh_KOjVxF_uRtKgTFAMF";
        $notification["TEXTO_NOTIFICACION"] = "Tienes un nuevo candidato en tu vacante Ingresa a la aplicación para más información.";
        $notification["TITLE"] = "Tienes un candidato postulado a tu vacante";
        
        $API_ACCESS_KEY = env('SERVER_KEY_FIREBASE');

        $instructions = array();
        $instructions["action"] = (isset($notification["ACTION"]) ? $notification["ACTION"] : "");

        $fcmMsg = array(
            'body' => $notification["TEXTO_NOTIFICACION"],
            'title' => $notification["TITLE"],
            'subtitle' => "Yob",
            'sound' => "default",
            'action' => 'some value',
        );

     
        $fcmFields = array(
            'to' => $notification["UUID"],
            'priority' => 'normal',
            'data' => $instructions,
        );

        $headers = array(
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch);
        dump('resultado2: ',$result);
        curl_close($ch);

        $result = json_decode($result);

        dump('resultado2: ',$result);
    }
}
