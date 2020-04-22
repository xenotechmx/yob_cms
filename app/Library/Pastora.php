<?php namespace MetodikaTI\Library;

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


require_once('/var/www/yob_cms/public/PayU/lib/PayU.php');

class Pastora
{

    public static function in_relation($object, $field_id, $field)
    {
        if (!is_null($object)) {
            if (!is_null($object->$field_id)) {
                if (!is_null($object->$field_id->$field)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Metodo que devuelve verdadero si una propiedad se encuentra en un arreglo
     *
     * @return Boolean
     */
    public static function in_object($value, $object)
    {
        if (is_object($object)) {
            foreach ($object as $key => $item) {
                if ($value == $key) return true;
            }
        }
        return false;
    }

    /**
     * Metodo que devuelve los permisos que tiene el usuario
     *
     * @return JSON
     */
    public static function userProfile()
    {

        return User::find(Auth::user()->id)->userProfile->permits;
    }

    /**
     * Metodo que convierte un Json a Array
     *
     * @return Array
     */
    public static function jsonToArray($json)
    {
        $json = (array)json_decode($json);
        $response = [];
        foreach ($json as $key => $value) {
            $response[(int)$key] = (int)$value;
        }
        return $response;
    }

    /**
     * This method convert the array to object
     *
     * @param $array array to convert to object
     * @return mixed return the array on object
     */
    public static function arrayToObject($array)
    {
        return json_decode(json_encode($array));
    }


    /**
     *
     *
     */
    public function strongMeter($password)
    {
        $rank = 0;
        $rank += (strlen(trim($password)) > 7) ? 5 : 0;
        $rank += (strlen(trim($password)) > 11 && strlen(trim($password)) < 16) ? 10 : 0;
        $rank += (preg_match("/([A-Z])/", $password)) ? 10 : 0;
        $rank += (preg_match("/([0-9])/", $password)) ? 10 : 0;
    }

    /**
     * Metodo que construye el arbol de modulos del sistema
     *
     * @var $parent integer. ID del papa del módulo
     *
     * @return array
     */
    public static function moduleTree($parent = 0)
    {

        $response = [];

        foreach (SystemModule::where('parent', '=', $parent)->orderBy('order')->get() as $module) {

            $response[] = [
                'id' => $module->id,
                'name' => $module->name,
                'url' => $module->url,
                'icon' => $module->icon,
                'parent_as_child' => $module->parent_as_child,
                'child' => self::moduleTree($module->id)
            ];

        }

        return $response;

    }


    /**
     *
     *
     */
    public static function cleanPhone($phone)
    {
        $mapper = [
            '/',
            '(',
            ')',
            '-',
            ' '
        ];

        foreach ($mapper as $key => $value) {

            $phone = str_replace($value, "", $phone);

        }

        return $phone;
    }

    public static function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 4; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }

    public function getRandomWord($len = 5)
    {
        $word = array_merge(range('0', '9'), range('A', 'Z'));
        shuffle($word);
        return substr(implode($word), 0, $len);
    }


    public static function make_sku()
    {

        $reservation = null;
        $sku = "";

        do {

            $sku = "YOB-" . rand(1000, 9999) . "-" . chr(rand(65, 90)) . chr(rand(65, 90));
            $reservation = PackagesBuyedByUser::where("reference_code", $sku)->count();

        } while ($reservation >= 1);

        return $sku;
    }


    //UUID
    //TEXTO_NOTIFICACION
    //TITLE
    //ACTION
    public static function sendPushNotification($notification)
    {

        $API_ACCESS_KEY = 'AAAAEe2eHOE:APA91bF-_KM1CNWYNdTXTvdPkNcwFY_WmZICpwfsWunfHga1RoGzBto9znVEN_Q1KfBm7Cf8UKvzUJjOYeazkxUuZnkMbcK3v7a51pthHxTHgvjXluASOJ90nJJTzCr4ZZx7PGTr8al3';

        $instructions = array();
        $instructions["action"] = (isset($notification["ACTION"]) ? $notification["ACTION"] : "");

        if (is_array($notification["UUID"])) {

            foreach($notification["UUID"] as $uuid){
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
            return $response->getBody();
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


    /* Payments functions */
    public static function setEnvirotmentPayU()
    {

        \PayU::$apiKey = 'A8Ry6B4wY6Nsh22wMGUSGz8Slf';
        \PayU::$apiLogin = '62vtqgIZOMAaq05';
        \PayU::$merchantId = '808159';
        \PayU::$language = \SupportedLanguages::ES;
        \PayU::$isTest = 'false';

        \Environment::setPaymentsCustomUrl(env("setPaymentsCustomUrl"));
        \Environment::setReportsCustomUrl(env("setReportsCustomUrl"));
        \Environment::setSubscriptionsCustomUrl(env("setSubscriptionsCustomUrl"));

    }


    public static function generateTokenCard($PAYER_ID, $PAYER_NAME, $CREDIT_CARD_NUMBER, $CREDIT_CARD_EXPIRATION_DATE, $PAYMENT_METHOD)
    {

        self::setEnvirotmentPayU();

        $response = array();
        $response["error"] = true;
        $response["data"] = "";


        try {

            $parameters = array(
                //Ingrese aquí el nombre del pagador.
                \PayUParameters::PAYER_NAME => $PAYER_NAME,
                //Ingrese aquí el identificador del pagador.
                \PayUParameters::PAYER_ID => $PAYER_ID,
                //Ingrese aquí el documento de identificación del comprador.
                \PayUParameters::PAYER_DNI => "",
                //Ingrese aquí el número de la tarjeta de crédito
                \PayUParameters::CREDIT_CARD_NUMBER => $CREDIT_CARD_NUMBER,
                //Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
                \PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $CREDIT_CARD_EXPIRATION_DATE,
                //Ingrese aquí el nombre de la tarjeta de crédito
                \PayUParameters::PAYMENT_METHOD => $PAYMENT_METHOD
            );

            $result = \PayUTokens::create($parameters);

            if ($result->code == "SUCCESS") {
                $response["error"] = false;
                $response["data"] = $result->creditCardToken->creditCardTokenId;
            } else {
                $response["error"] = true;
                $response["data"] = "No hemos podido identificar la tarjeta ingresada, intentalo nuevamente.";
            }

        } catch (\PayUException $e) {
            $response["error"] = true;
            $response["data"] = $e->getMessage();
        }

        return $response;
    }


    public static function makePaymentWithToken($ACCOUNT_ID, $REFERENCE_CODE, $DESCRIPTION, $PAYER_EMAIL, $VALUE, $TOKEN_ID, $APP_USER)
    {

        self::setEnvirotmentPayU();

        $response = array();
        $response["error"] = true;
        $response["data"] = "";


        try {

            //Consultamos la informacion del token
            $card_info = self::getCardInfoByToken($APP_USER->id, $TOKEN_ID);

            if (!$card_info["error"]) {

                $parameters = array(
                    //Ingrese aquí el identificador de la cuenta.
                    \PayUParameters::ACCOUNT_ID => $ACCOUNT_ID,
                    //Ingrese aquí el código de referencia.
                    \PayUParameters::REFERENCE_CODE => $REFERENCE_CODE,
                    //Ingrese aquí la descripción.
                    \PayUParameters::DESCRIPTION => $DESCRIPTION,
                    //Ingrese aquí el email del comprador.
                    \PayUParameters::PAYER_EMAIL => $PAYER_EMAIL,
                    //Ingrese aquí el valor.
                    \PayUParameters::VALUE => $VALUE,
                    //Ingrese aquí la moneda.
                    \PayUParameters::CURRENCY => "MXN",
                    // DATOS DEL TOKEN
                    \PayUParameters::TOKEN_ID => $TOKEN_ID,
                    \PayUParameters::PAYMENT_METHOD => $card_info["data"]->paymentMethod,
                    //Ingrese aquí el nombre del pais.
                    \PayUParameters::COUNTRY => \PayUCountries::MX,
                    //Ingrese aquí el número de cuotas.
                    \PayUParameters::INSTALLMENTS_NUMBER => "1",

                    ////Session id del device.
                    //\PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
                    ////IP del pagadador
                    //\PayUParameters::IP_ADDRESS => "127.0.0.1",
                    ////Cookie de la sesión actual.
                    //\PayUParameters::PAYER_COOKIE=>"pt1t38347bs6jc9ruv2ecpv7o2",
                    ////Cookie de la sesión actual.
                    //\PayUParameters::USER_AGENT=>"Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
                );

                $result = \PayUPayments::doAuthorizationAndCapture($parameters);

                if ($result->code == "SUCCESS") {
                    $response["error"] = false;
                    $response["data"] = $result->transactionResponse;
                } else {
                    $response["error"] = true;
                    $response["data"] = "No hemos podido generar el cobro, intentalo nuevamente.";
                }

            } else {
                $response["error"] = true;
                $response["data"] = $card_info["data"];
            }

        } catch (\PayUException $e) {
            $response["error"] = true;
            $response["data"] = $e->getMessage()." CODIGO ZHT-A";
        }

        return $response;
    }


    public static function getCardInfoByToken($APP_USER_ID, $TOKEN_ID)
    {

        self::setEnvirotmentPayU();

        $response = array();
        $response["error"] = true;
        $response["data"] = "";


        try {

            $parameters = array(
                //Ingresa aquí el identificador del pagador.
                \PayUParameters::PAYER_ID => $APP_USER_ID,
                //Ingresa aquí el identificador del token.
                \PayUParameters::TOKEN_ID => $TOKEN_ID,
            );

            $result = \PayUTokens::find($parameters);

            if ($result->code == "SUCCESS") {
                $response["error"] = false;
                $response["data"] = $result->creditCardTokenList[0];
            } else {
                $response["error"] = true;
                $response["data"] = "No hemos podido identificar la tarjeta ingresada, intentalo nuevamente.";
            }

        } catch (\PayUException $e) {
            $response["error"] = true;
            $response["data"] = $e->getMessage();
        }

        return $response;
    }


    public static function generateOxxoPayment($ACCOUNT_ID, $REFERENCE_CODE, $DESCRIPTION, $VALUE, $APP_USER, $PAYMENT_STORE)
    {

        //$PAYMENT_STORE => 
        //OXXO
        //SEVEN_ELEVEN
        //OTHERS_CASH_MX

        self::setEnvirotmentPayU();

        $response = array();
        $response["error"] = true;
        $response["data"] = "";

        try {

            $expiration_date = Carbon::now()->addDays("7")->format("Y-m-d");

            $parameters = array(
                //Ingrese aquí el identificador de la cuenta.
                \PayUParameters::ACCOUNT_ID => $ACCOUNT_ID,
                //Ingrese aquí el código de referencia.
                \PayUParameters::REFERENCE_CODE => $REFERENCE_CODE,
                //Ingrese aquí la descripción.
                \PayUParameters::DESCRIPTION => $DESCRIPTION,

                // -- Valores --
                //Ingrese aquí el valor.
                \PayUParameters::VALUE => $VALUE,
                //Ingrese aquí la moneda.
                \PayUParameters::CURRENCY => "MXN",

                //Ingrese aquí el email del comprador.
                \PayUParameters::BUYER_EMAIL => $APP_USER->email,
                //Ingrese aquí el nombre del pagador.
                \PayUParameters::PAYER_NAME => $APP_USER->name . " " . $APP_USER->father_last_name . " " . $APP_USER->mother_last_name,
                //Ingrese aquí el documento de contacto del pagador.
                \PayUParameters::PAYER_DNI => $APP_USER->id,

                //Ingrese aquí el nombre del método de pago
                //"SANTANDER"||"SCOTIABANK"||"BANCOMER"||"OXXO"||"SEVEN_ELEVEN"||"OTHERS_CASH_MX"
                \PayUParameters::PAYMENT_METHOD => $PAYMENT_STORE,

                //Ingrese aquí el nombre del pais.
                \PayUParameters::COUNTRY => \PayUCountries::MX,

                //Ingrese aquí la fecha de expiración. Sólo para OXXO y SEVEN_ELEVEN
                \PayUParameters::EXPIRATION_DATE => $expiration_date . "T00:00:00",
            );

            $result = \PayUPayments::doAuthorizationAndCapture($parameters);

            if ($result->code == "SUCCESS") {
                $response["error"] = false;
                $response["data"] = $result->transactionResponse;
            } else {
                $response["error"] = true;
                $response["data"] = "No hemos podido generar la orden de compra, intentalo nuevamente." . $result->transactionResponse;
            }

        } catch (\PayUException $e) {
            $response["error"] = true;
            $response["data"] = $e->getMessage();
        }

        return $response;
    }


    public static function checkStatusPayment()
    {

    }


    public static function generateSpeiPayment($ACCOUNT_ID, $REFERENCE_CODE, $DESCRIPTION, $VALUE, $APP_USER)
    {

        self::setEnvirotmentPayU();

        $response = array();
        $response["error"] = true;
        $response["data"] = "";

        try {

            $expiration_date = Carbon::now()->addDays("7")->format("Y-m-d");

            $parameters = array(
                //Ingrese aquí el identificador de la cuenta.
                \PayUParameters::PAYMENT_METHOD => "PSE",
                //Ingrese aquí el nombre del pais.
                \PayUParameters::COUNTRY => \PayUCountries::MX,
            );

            $array = \PayUPayments::getPSEBanks($parameters);

            dd($array);

//            if ($result->code == "SUCCESS") {
//                $response["error"] = false;
//                $response["data"] = $result->transactionResponse;
//            } else {
//                $response["error"] = true;
//                $response["data"] = "No hemos podido generar la orden de compra, intentalo nuevamente.";
//            }

        } catch (\PayUException $e) {
            $response["error"] = true;
            $response["data"] = $e->getMessage();
        }

        return $response;
    }


    public static function generateInvoice($packages_buyed_by_users_id)
    {

        try {

            $packages_buyed_by_users = PackagesBuyedByUser::find($packages_buyed_by_users_id);

            //self::milmillon(349250.50);
            $number = explode(".", strval($packages_buyed_by_users->original_price));
            $pesos = $number[0];
            $centavos = $number[1];

            if (strlen($centavos) == 1) {
                $centavos = $centavos . "0";
            }

            $price_with_letter = self::milmillon($pesos) . " PESOS " . $centavos . "/100 M.N";


            $wsseHeader = '<wsse:Security env:mustUnderstand="1"   xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" ' . ' xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" ' . ' xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"' . ' xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"> ' . ' <wsse:UsernameToken><wsse:Username>' .
                env("wsseUser") .
                '</wsse:Username> ' . ' <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-' . 'wss-username-token-profile-1.0#PasswordText">' .
                env("wssePassword") .
                '</wsse:Password></wsse:UsernameToken></wsse:Security>';


            $wsseHeader = new \SoapVar($wsseHeader, XSD_ANYXML);
            $wsseHeader = new \SoapHeader('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'Security', $wsseHeader, true);

            $soapClient = "";

            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]);

            $soapClient = new \SoapClient(env("wsInsignaUrl"), array(
                'soap_version' => SOAP_1_2,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'ssl_method' => SOAP_SSL_METHOD_TLS,
                'stream_context' => $context
            ));

            $soapClient->__setSoapHeaders($wsseHeader);

            $param = array();
            $parametros = array();

            $invoice_xml = view("app.invoice_template", compact("packages_buyed_by_users"))->render();
            $invoice_xml = base64_encode($invoice_xml);

            $parametros[] = new \SoapVar($invoice_xml, XSD_STRING, null, null, 'ns1:cfdi');
            $param[] = new \SoapVar($parametros, SOAP_ENC_OBJECT, null, null, 'ns1:cfdiSignWrapper');

            //Colocamos la compra como factura generada, pero esto no indica que fue _todo correcto
            $packages_buyed_by_users->is_invoice_generated = 1;
            $packages_buyed_by_users->save();


            //Firmamos el invoice
            $response = $soapClient->signCfdi(new \SoapVar($param, SOAP_ENC_OBJECT));

            //dd($response);

            if ($response->return->responseCode == 1000) {

                $invoice = new Invoice();
                $invoice->packages_buyed_by_users_id = $packages_buyed_by_users_id;
                $invoice->responseCode = $response->return->responseCode;
                $invoice->responseDescription = $response->return->responseDescription;
                $invoice->serverTransactionId = $response->return->serverTransactionId;
                $invoice->requestDate = $response->return->requestDate;
                $invoice->responseDate = $response->return->responseDate;
                $invoice->executionTime = $response->return->executionTime;
                $invoice->signedXml = $response->return->signedXml;
                $invoice->uuid = $response->return->uuid;
                $invoice->save();

                //Generamos el pdf del invoice
                $cfdi_signed = base64_decode($invoice->signedXml);
                $cfdi_signed = str_replace("cfdi:", "", $cfdi_signed);
                $cfdi_signed = str_replace("tfd:", "", $cfdi_signed);
                $cfdi_signed = simplexml_load_string($cfdi_signed);
                $cfdi_signed = json_encode($cfdi_signed);
                $cfdi_signed = json_decode($cfdi_signed, true);

                //Generamos una carpeta para guardar la factura en PDF y XML
                if (!is_dir(public_path("assets/invoices/" . $invoice->id))) {
                    mkdir(public_path("assets/invoices/" . $invoice->id), 0777);
                }


                ini_set('memory_limit', '256M');

                //************************ PDF ************************
                $name_invoice = date("dmYHis") . "_" . $invoice->id;
                $qr_image = public_path("assets/qr_invoices/" . $name_invoice . ".png");
                QRCode::url($invoice->url_for_qr($cfdi_signed))->setSaveAndPrint(false)->setOutfile($qr_image)->png();


                $pdf = \PDF::loadView('app.invoice_pdf_template', compact("cfdi_signed", "qr_image", "price_with_letter"));
                $pdf->save("assets/invoices/" . $invoice->id . "/" . $name_invoice . ".pdf");

                $invoice->pdf_invoice = "assets/invoices/" . $invoice->id . "/" . $name_invoice . ".pdf";
                $invoice->save();


                //************************ XML ************************
                $txt = fopen("assets/invoices/" . $invoice->id . "/" . $name_invoice . ".xml", "w");
                fwrite($txt, base64_decode($response->return->signedXml));
                fclose($txt);

                $invoice->xml_invoice = "assets/invoices/" . $invoice->id . "/" . $name_invoice . ".xml";
                $invoice->save();


                //Enviamos la factura en pdf y xml al usuario
                \Mail::send("app.invoices_mail", ["invoice" => $invoice], function ($message) use ($invoice) {
                    $message->to($invoice->get_packaged_buyed_by_user->get_invoice_information["email_send_invoice"])->subject('Factura de Yob');
                    $message->attach($invoice->pdf_invoice);
                    $message->attach($invoice->xml_invoice);
                });

            } else {

                $invoice = new Invoice();
                $invoice->packages_buyed_by_users_id = $packages_buyed_by_users_id;
                $invoice->responseCode = $response->return->responseCode;
                $invoice->responseDescription = $response->return->responseDescription;
                $invoice->serverTransactionId = $response->return->serverTransactionId;
                $invoice->requestDate = $response->return->requestDate;
                $invoice->responseDate = $response->return->responseDate;
                $invoice->executionTime = $response->return->executionTime;
                $invoice->signedXml = "";
                $invoice->uuid = "";
                $invoice->cfdi = base64_decode($invoice_xml);
                $invoice->save();

            }


        } catch (\Throwable $e) {
            dd($e);
        }

    }


    public static function get_name_seo($file_object)
    {

        $name = "";
        $name = $file_object;
        $name = str_replace(" ", "-", $name);
        $name = str_replace("_", "-", $name);
        $name = $name . "-" . date("His");
        return $name;
    }


    public static function milmillon($nummierod)
    {
        if ($nummierod >= 1000000000 && $nummierod < 2000000000) {
            $num_letrammd = "MIL " . (self::cienmillon($nummierod % 1000000000));
        }
        if ($nummierod >= 2000000000 && $nummierod < 10000000000) {
            $num_letrammd = self::unidad(Floor($nummierod / 1000000000)) . " MIL " . (self::cienmillon($nummierod % 1000000000));
        }
        if ($nummierod < 1000000000)
            $num_letrammd = self::cienmillon($nummierod);

        return $num_letrammd;
    }


    public static function cienmillon($numcmeros)
    {
        if ($numcmeros == 100000000)
            $num_letracms = "CIEN MILLONES";
        if ($numcmeros >= 100000000 && $numcmeros < 1000000000) {
            $num_letracms = self::centena(Floor($numcmeros / 1000000)) . " MILLONES " . (self::millon($numcmeros % 1000000));
        }
        if ($numcmeros < 100000000)
            $num_letracms = self::decmillon($numcmeros);
        return $num_letracms;
    }


    public static function decmillon($numerodm)
    {
        if ($numerodm == 10000000)
            $num_letradmm = "DIEZ MILLONES";
        if ($numerodm > 10000000 && $numerodm < 20000000) {
            $num_letradmm = self::decena(Floor($numerodm / 1000000)) . "MILLONES " . (self::cienmiles($numerodm % 1000000));
        }
        if ($numerodm >= 20000000 && $numerodm < 100000000) {
            $num_letradmm = self::decena(Floor($numerodm / 1000000)) . " MILLONES " . (self::millon($numerodm % 1000000));
        }
        if ($numerodm < 10000000)
            $num_letradmm = self::millon($numerodm);

        return $num_letradmm;
    }


    public static function millon($nummiero)
    {
        if ($nummiero >= 1000000 && $nummiero < 2000000) {
            $num_letramm = "UN MILLON " . (self::cienmiles($nummiero % 1000000));
        }
        if ($nummiero >= 2000000 && $nummiero < 10000000) {
            $num_letramm = self::unidad(Floor($nummiero / 1000000)) . " MILLONES " . (self::cienmiles($nummiero % 1000000));
        }
        if ($nummiero < 1000000)
            $num_letramm = self::cienmiles($nummiero);

        return $num_letramm;
    }


    public static function cienmiles($numcmero)
    {
        if ($numcmero == 100000)
            $num_letracm = "CIEN MIL";
        if ($numcmero >= 100000 && $numcmero < 1000000) {
            $num_letracm = self::centena(Floor($numcmero / 1000)) . " MIL " . (self::centena($numcmero % 1000));
        }
        if ($numcmero < 100000)
            $num_letracm = self::decmiles($numcmero);
        return $num_letracm;
    }


    public static function decmiles($numdmero)
    {
        if ($numdmero == 10000)
            $numde = "DIEZ MIL";
        if ($numdmero > 10000 && $numdmero < 20000) {
            $numde = self::decena(Floor($numdmero / 1000)) . "MIL " . (self::centena($numdmero % 1000));
        }
        if ($numdmero >= 20000 && $numdmero < 100000) {
            $numde = self::decena(Floor($numdmero / 1000)) . " MIL " . (self::miles($numdmero % 1000));
        }
        if ($numdmero < 10000)
            $numde = self::miles($numdmero);

        return $numde;
    }


    public static function miles($nummero)
    {
        if ($nummero >= 1000 && $nummero < 2000) {
            $numm = "MIL " . (self::centena($nummero % 1000));
        }
        if ($nummero >= 2000 && $nummero < 10000) {
            $numm = self::unidad(Floor($nummero / 1000)) . " MIL " . (self::centena($nummero % 1000));
        }
        if ($nummero < 1000)
            $numm = self::centena($nummero);

        return $numm;
    }


    public static function centena($numc)
    {
        if ($numc >= 100) {
            if ($numc >= 900 && $numc <= 999) {
                $numce = "NOVECIENTOS ";
                if ($numc > 900)
                    $numce = $numce . (self::decena($numc - 900));
            } else if ($numc >= 800 && $numc <= 899) {
                $numce = "OCHOCIENTOS ";
                if ($numc > 800)
                    $numce = $numce . (self::decena($numc - 800));
            } else if ($numc >= 700 && $numc <= 799) {
                $numce = "SETECIENTOS ";
                if ($numc > 700)
                    $numce = $numce . (self::decena($numc - 700));
            } else if ($numc >= 600 && $numc <= 699) {
                $numce = "SEISCIENTOS ";
                if ($numc > 600)
                    $numce = $numce . (self::decena($numc - 600));
            } else if ($numc >= 500 && $numc <= 599) {
                $numce = "QUINIENTOS ";
                if ($numc > 500)
                    $numce = $numce . (self::decena($numc - 500));
            } else if ($numc >= 400 && $numc <= 499) {
                $numce = "CUATROCIENTOS ";
                if ($numc > 400)
                    $numce = $numce . (self::decena($numc - 400));
            } else if ($numc >= 300 && $numc <= 399) {
                $numce = "TRESCIENTOS ";
                if ($numc > 300)
                    $numce = $numce . (self::decena($numc - 300));
            } else if ($numc >= 200 && $numc <= 299) {
                $numce = "DOSCIENTOS ";
                if ($numc > 200)
                    $numce = $numce . (self::decena($numc - 200));
            } else if ($numc >= 100 && $numc <= 199) {
                if ($numc == 100)
                    $numce = "CIEN ";
                else
                    $numce = "CIENTO " . (self::decena($numc - 100));
            }
        } else
            $numce = self::decena($numc);

        return $numce;
    }


    public static function decena($numdero)
    {

        if ($numdero >= 90 && $numdero <= 99) {
            $numd = "NOVENTA ";
            if ($numdero > 90)
                $numd = $numd . "Y " . (self::unidad($numdero - 90));
        } else if ($numdero >= 80 && $numdero <= 89) {
            $numd = "OCHENTA ";
            if ($numdero > 80)
                $numd = $numd . "Y " . (self::unidad($numdero - 80));
        } else if ($numdero >= 70 && $numdero <= 79) {
            $numd = "SETENTA ";
            if ($numdero > 70)
                $numd = $numd . "Y " . (self::unidad($numdero - 70));
        } else if ($numdero >= 60 && $numdero <= 69) {
            $numd = "SESENTA ";
            if ($numdero > 60)
                $numd = $numd . "Y " . (self::unidad($numdero - 60));
        } else if ($numdero >= 50 && $numdero <= 59) {
            $numd = "CINCUENTA ";
            if ($numdero > 50)
                $numd = $numd . "Y " . (self::unidad($numdero - 50));
        } else if ($numdero >= 40 && $numdero <= 49) {
            $numd = "CUARENTA ";
            if ($numdero > 40)
                $numd = $numd . "Y " . (self::unidad($numdero - 40));
        } else if ($numdero >= 30 && $numdero <= 39) {
            $numd = "TREINTA ";
            if ($numdero > 30)
                $numd = $numd . "Y " . (self::unidad($numdero - 30));
        } else if ($numdero >= 20 && $numdero <= 29) {
            if ($numdero == 20)
                $numd = "VEINTE ";
            else
                $numd = "VEINTI" . (self::unidad($numdero - 20));
        } else if ($numdero >= 10 && $numdero <= 19) {
            switch ($numdero) {
                case 10:
                    {
                        $numd = "DIEZ ";
                        break;
                    }
                case 11:
                    {
                        $numd = "ONCE ";
                        break;
                    }
                case 12:
                    {
                        $numd = "DOCE ";
                        break;
                    }
                case 13:
                    {
                        $numd = "TRECE ";
                        break;
                    }
                case 14:
                    {
                        $numd = "CATORCE ";
                        break;
                    }
                case 15:
                    {
                        $numd = "QUINCE ";
                        break;
                    }
                case 16:
                    {
                        $numd = "DIECISEIS ";
                        break;
                    }
                case 17:
                    {
                        $numd = "DIECISIETE ";
                        break;
                    }
                case 18:
                    {
                        $numd = "DIECIOCHO ";
                        break;
                    }
                case 19:
                    {
                        $numd = "DIECINUEVE ";
                        break;
                    }
            }
        } else
            $numd = self::unidad($numdero);
        return $numd;
    }


    public static function unidad($numuero)
    {
        switch ($numuero) {
            case 9:
                {
                    $numu = "NUEVE";
                    break;
                }
            case 8:
                {
                    $numu = "OCHO";
                    break;
                }
            case 7:
                {
                    $numu = "SIETE";
                    break;
                }
            case 6:
                {
                    $numu = "SEIS";
                    break;
                }
            case 5:
                {
                    $numu = "CINCO";
                    break;
                }
            case 4:
                {
                    $numu = "CUATRO";
                    break;
                }
            case 3:
                {
                    $numu = "TRES";
                    break;
                }
            case 2:
                {
                    $numu = "DOS";
                    break;
                }
            case 1:
                {
                    $numu = "UN";
                    break;
                }
            case 0:
                {
                    $numu = "";
                    break;
                }
        }
        return $numu;
    }


}


















