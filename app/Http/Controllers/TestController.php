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

        $API_ACCESS_KEY = 'AAAAEe2eHOE:APA91bF-_KM1CNWYNdTXTvdPkNcwFY_WmZICpwfsWunfHga1RoGzBto9znVEN_Q1KfBm7Cf8UKvzUJjOYeazkxUuZnkMbcK3v7a51pthHxTHgvjXluASOJ90nJJTzCr4ZZx7PGTr8al3';

        $notification = array();
        $notification["UUID"] = "diQnn-pXn40:APA91bFzTAE7LA-zNoEeWhLVOXgH0rzhVjE7aIhJMuxKMR6GPQ_ePEOFgjWpcTjP-Wgnm2AvFYpFl2IHM-rkIfEr2fKmsKqE7AoZtK6P7bSpMYbunnZvL6xuoh_KOjVxF_uRtKgTFAMF";
        $notification["TEXTO_NOTIFICACION"] = "Tienes un nuevo candidato en tu vacante Ingresa a la aplicación para más información.";
        $notification["TITLE"] = "Tienes un candidato postulado a tu vacante";
        
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


        // $access_token = 'AAAAEe2eHOE:APA91bF-_KM1CNWYNdTXTvdPkNcwFY_WmZICpwfsWunfHga1RoGzBto9znVEN_Q1KfBm7Cf8UKvzUJjOYeazkxUuZnkMbcK3v7a51pthHxTHgvjXluASOJ90nJJTzCr4ZZx7PGTr8al3';

        // $reg_id = 'diQnn-pXn40:APA91bFzTAE7LA-zNoEeWhLVOXgH0rzhVjE7aIhJMuxKMR6GPQ_ePEOFgjWpcTjP-Wgnm2AvFYpFl2IHM-rkIfEr2fKmsKqE7AoZtK6P7bSpMYbunnZvL6xuoh_KOjVxF_uRtKgTFAMF';

        // $message = [
        //     'notification' => [
        //         'title' => 'Test Message',
        //         'body' => "This is a test!",
        //         "text" => "Text"
        //     ],
        //     'to' => $reg_id,
        //     "priority"=> "high",
        // ];

        // $client = new GuzzleHttp\Client([
        //     'headers' => [
        //         'Content-Type' => 'application/json',
        //         'Authorization' => 'key='.$access_token,
        //     ]
        // ]);

        // $response = $client->post('https://fcm.googleapis.com/fcm/send',
        //     ['body' => json_encode($message)]
        // );

        // echo $response->getBody();
    }
}
