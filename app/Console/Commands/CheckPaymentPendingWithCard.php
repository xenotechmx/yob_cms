<?php

namespace MetodikaTI\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use MetodikaTI\AppUser;
use MetodikaTI\Http\Controllers\API\APIController;
use MetodikaTI\Library\Pastora;
use MetodikaTI\PackagesBuyedByUser;

require_once(base_path().'/public/PayU/lib/PayU.php');

class CheckPaymentPendingWithCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkpendingpayment:card';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        \PayU::$apiKey = env("PAYU_APIKEY");
        \PayU::$apiLogin = env("PAYU_APILOGIN");
        \PayU::$merchantId = env("PAYU_MERCHANTID");
        \PayU::$language = \SupportedLanguages::ES;
        \PayU::$isTest = env("PAYU_ISTEST");

        \Environment::setPaymentsCustomUrl(env("setPaymentsCustomUrl"));
        \Environment::setReportsCustomUrl(env("setReportsCustomUrl"));
        \Environment::setSubscriptionsCustomUrl(env("setSubscriptionsCustomUrl"));

        $response = array();
        $response["error"] = true;
        $response["data"] = "";

        $today_date = Carbon::now();

        //Obtenemos todas las ordenes pendientes que hallan sido con TARJETA
        $pending_orders = PackagesBuyedByUser::where("status", "PENDING")->where("type", "CARD")->get();
        foreach ($pending_orders as $pending_order) {

            try {

                $order_created_at = Carbon::createFromFormat("Y-m-d H:i:s", $pending_order->created_at);

                //Si ya pasaron mas de 7 minutos desde que se creo la orden, podemos revisar si ya fue pagado
                if ($order_created_at->diffInMinutes($today_date) > 7) {

                    //Consultadmos el status de cada orden pendiente
                    $parameters = array(\PayUParameters::REFERENCE_CODE => $pending_order->reference_code);
                    $response = \PayUReports::getOrderDetailByReferenceCode($parameters);

                    //Si el status es CAPTURED o APPROVED significa que el pago fue recibido correctamente
                    //Podemos el paquete como pagado y asignamos la fecha de caducidad
                    if ($response[0]->transactions[0]->transactionResponse->state == "APPROVED") {
                    //if (true) {
                        $today_date = Carbon::now();
                        $pending_order = PackagesBuyedByUser::find($pending_order->id);
                        $pending_order->package_disbaled_at = $today_date->addDays($pending_order->original_duration_plan_in_days)->format("Y-m-d H:i:s");
                        $pending_order->status = "APPROVED";
                        $pending_order->save();

                        $app_user = AppUser::find($pending_order->app_user_id);

                        $notification = array();
                        $notification["UUID"] = $app_user->getUuids();
                        $notification["TEXTO_NOTIFICACION"] = "Hola " . $app_user->business_name . ", tu pago para el paquete '" . $pending_order->package_name . "' se ha procesado correctamente, ahora cuentas con créditos activos para usar dentro de Yob";
                        $notification["TITLE"] = "Pago aprobado";
                        $notification["ACTION"] = "";

                        Pastora::sendPushNotification($notification);

                        //Generamos la factura en caso de que lo requiera y no se halla generado
                        if ($pending_order->is_require_invoice == 1 && $pending_order->is_invoice_generated == 0) {
                            Pastora::generateInvoice($pending_order->id);
                        }

                    }

                }


            } catch (\PayUException $e) {

                $response["error"] = true;
                $response["data"] = $e->getMessage();
            }

        }

    }

}
