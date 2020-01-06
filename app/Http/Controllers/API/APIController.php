<?php

namespace MetodikaTI\Http\Controllers\API;

use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use LaravelQRCode\Facades\QRCode;
use MetodikaTI\AppUser;
use MetodikaTI\AppUserInvoice;
use MetodikaTI\AppUserNotification;
use MetodikaTI\BussinesAddress;
use MetodikaTI\BussinesInformation;
use MetodikaTI\BussinesInvoice;
use MetodikaTI\Category;
use MetodikaTI\ChatRoom;
use MetodikaTI\CodigosPostales;
use MetodikaTI\Experience;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Http\Requests\API\CreateAccountRequest;
use MetodikaTI\Http\Requests\API\CreateEmployeRequest;
use MetodikaTI\Http\Requests\API\EditEmployeRequest;
use MetodikaTI\Http\Requests\API\CreateUserRequest;
use MetodikaTI\Http\Requests\API\EditExperienciaRequest;
use MetodikaTI\Http\Requests\API\EditStudiesRequest;
use MetodikaTI\Http\Requests\API\LoginRequest;
use MetodikaTI\Http\Requests\API\LoginUserRequest;
use MetodikaTI\Http\Requests\API\MakePaymentCardRequest;
use MetodikaTI\Http\Requests\API\PostJobRequest;
use MetodikaTI\Http\Requests\API\RecoverPasswordRequest;
use MetodikaTI\Http\Requests\API\SaveExperienciaRequest;
use MetodikaTI\Http\Requests\API\SaveJobRequest;
use MetodikaTI\Http\Requests\API\SavePerfilRequest;
use MetodikaTI\Http\Requests\API\SearchCandidatesRequest;
use MetodikaTI\Http\Requests\API\SearchJobByBusinessIdRequest;
use MetodikaTI\Http\Requests\API\SearchJobRequest;
use MetodikaTI\Http\Requests\API\SendMessageRequest;
use MetodikaTI\Http\Requests\API\UpdateInvoiceInformationRequest;
use MetodikaTI\Http\Requests\SaveJobExperienceRequest;
use MetodikaTI\Http\Requests\SaveProfileRequest;
use MetodikaTI\Http\Requests\SaveStudyExperienceRequest;
use MetodikaTI\Invoice;
use MetodikaTI\Job;
use MetodikaTI\JobCatalog;
use MetodikaTI\JobExperience;
use MetodikaTI\Jobs;
use MetodikaTI\JobUserApply;
use MetodikaTI\Language;
use MetodikaTI\LanguageCatalog;
use MetodikaTI\Library\Pastora;
use MetodikaTI\MessagesToUser;
use MetodikaTI\Notification;
use MetodikaTI\PackagesBuyedByUser;
use MetodikaTI\PackageSell;
use MetodikaTI\PostalCode;
use MetodikaTI\ProfileUserBuyed;
use MetodikaTI\PushNotification;
use MetodikaTI\SchoolGrade;
use MetodikaTI\Study;
use DB;
use MetodikaTI\StudyExperience;
use MetodikaTI\UserRequestJob;
use MetodikaTI\UUID;
use MetodikaTI\UuidDevice;
use File;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;


if (file_exists('PayU/lib/PayU.php')) {
    require_once('PayU/lib/PayU.php');
}

class APIController extends Controller
{

    public function create_user(CreateUserRequest $request)
    {

        $response = array();
        $response["error"] = true;
        $response["message"] = "";
        $response["user_id"] = 0;


        //Validamos que el correo electronico no exista registrado
        $is_email_used = AppUser::where("email", $request->email);
        if ($is_email_used->count() > 0) {
            $is_email_used = $is_email_used->first();
            if ($is_email_used->type == "user") {
                $response["error"] = false;
                $response["message"] = "El correo electrónico ingresado ya se encuentra registrado en otro usuario. Utiliza un correo electrónico diferente al que ya hayas registrado previamente en la aplicación.";
                return response()->json($response, 504);
            } else {
                $response["error"] = false;
                $response["message"] = "El correo electrónico ingresado ya se encuentra registrado como empleador. Utiliza un correo electrónico diferente al que ya hayas registrado previamente en la aplicación.";
                return response()->json($response, 504);
            }
        }


        $data = new AppUser();
        $data->name = $request->name;
        $data->father_last_name = $request->father_last_name;
        $data->mother_last_name = $request->mother_last_name;
        $data->email = $request->email;
        $data->responsable_name = "";
        $data->phone = $request->phone;
        $data->sign_up_type = "email";
        $data->password = md5($request->password);
        $data->type = "user";

        if ($data->save()) {
            $response["error"] = false;
            $response["message"] = "Tu cuenta ha sido creada correctamente.";
            $response["user_id"] = $data->id;
            $response["name"] = $data->name . " " . $data->father_last_name . " " . $data->mother_last_name;
            return response()->json($response);
        } else {
            $response["error"] = false;
            $response["message"] = "No hemos podido crear tu cuenta, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function do_login_user(LoginUserRequest $request)
    {

        $response = array();
        $response["error"] = true;
        $response["message"] = "";
        $response["user_id"] = 0;

        $data = AppUser::where("email", $request->email)->where("password", md5($request->password))->where("type", "user");

        if ($data->count() == 1) {

            $data = $data->first();

            $response["error"] = false;
            $response["message"] = "";
            $response["user_id"] = $data->id;
            $response["name"] = $data->name . " " . $data->father_last_name . " " . $data->mother_last_name;
            return response()->json($response);

        } else {
            $response["error"] = true;
            $response["message"] = "Usuario y/o contraseña incorrectos.";
            return response()->json($response, 504);
        }

    }


    public function crear_employer(CreateEmployeRequest $request)
    {

        $response = array();
        $response["error"] = true;
        $response["message"] = "";
        $response["user_id"] = 0;


        //Validamos que el correo electronico no exista registrado
        $is_email_used = AppUser::where("email", $request->general_information["email"]);
        if ($is_email_used->count() > 0) {
            $is_email_used = $is_email_used->first();
            if ($is_email_used->type == "user") {
                $response["error"] = false;
                $response["message"] = "El correo electrónico ingresado ya se encuentra registrado como usuario. Utiliza un correo electrónico diferente al que ya hayas registrado previamente en la aplicación.";
                return response()->json($response, 504);
            } else {
                $response["error"] = false;
                $response["message"] = "El correo electrónico ingresado ya se encuentra registrado en otro empleador. Utiliza un correo electrónico diferente al que ya hayas registrado previamente en la aplicación.";
                return response()->json($response, 504);
            }
        }


        $data = new AppUser();
        $data->name = "";
        $data->father_last_name = "";
        $data->mother_last_name = "";
        $data->email = $request->general_information["email"];
        $data->responsable_name = "";
        $data->phone = "";
        $data->sign_up_type = "email";
        $data->password = md5($request->general_information["password"]);
        $data->type = "employer";
        $data->business_name = $request->business_name;


        if ($data->save()) {

            //Generamos el codigo QR
            $qr_image = "assets/qr_employes/" . Pastora::get_name_seo($data->business_name) . ".png";
            QRCode::text($data->id)->setSaveAndPrint(false)->setSize(20)->setOutfile(public_path($qr_image))->png();

            $data->qr_path = $qr_image;
            $data->save();


            $bussines_information = new BussinesInformation();
            $bussines_information->app_user_id = $data->id;

            if ($request->type == "moral") {
                $bussines_information->type = "moral";
                $bussines_information->razon_social = $request->moral["razon_social"];
                $bussines_information->commercial_denomination = $request->moral["commercial_denomination"];
                $bussines_information->rfc = $request->moral["rfc"];
                $bussines_information->responsable_name = $request->moral["responsable_name"];
                $bussines_information->name = "";
                $bussines_information->father_last_name = "";
                $bussines_information->mother_last_name = "";
            } else {
                $bussines_information->type = "fisica";
                $bussines_information->razon_social = "";
                $bussines_information->commercial_denomination = "";
                $bussines_information->rfc = "";
                $bussines_information->responsable_name = "";
                $bussines_information->name = $request->fisica["name"];
                $bussines_information->father_last_name = $request->fisica["father_last_name"];
                $bussines_information->mother_last_name = $request->fisica["mother_last_name"];
            }

            $bussines_information->save();

            $bussines_address = new BussinesAddress();
            $bussines_address->app_user_id = $data->id;
            $bussines_address->address = $request->address["address"];
            $bussines_address->interior_exterior_number = $request->address["interior_exterior_number"];
            $bussines_address->postal_code = $request->address["postal_code"];
            $bussines_address->country = $request->address["country"];
            $bussines_address->state = $request->address["state"];
            $bussines_address->municipaly = $request->address["municipaly"];
            $bussines_address->colony = $request->address["colony"];
            $bussines_address->email = $request->address["email"];
            $bussines_address->phone = $request->address["phone"];
            $bussines_address->save();


            //Enviamos la invitacion con el codigo QR
            \Mail::send("app.register_business", ["user" => $data, "nueva_contrasena" => $request->general_information["password"]], function ($message) use ($data) {
                $message->to($data->email)->subject('¡Bienvenido a Yob!');
            });


            $response["error"] = false;
            $response["message"] = "Tu cuenta ha sido creada correctamente.";
            $response["user_id"] = $data->id;
            $response["name"] = $request->business_name;
            $response["image"] = $data->photo_user;
            return response()->json($response);
        } else {
            $response["error"] = false;
            $response["message"] = "No hemos podido crear tu cuenta, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function do_login_employer(LoginUserRequest $request)
    {

        $response = array();
        $response["error"] = true;
        $response["message"] = "";
        $response["user_id"] = 0;

        $data = AppUser::where("email", $request->email)->where("password", md5($request->password))->where("type", "employer");

        if ($data->count() == 1) {

            $data = $data->first();

            $response["error"] = false;
            $response["message"] = "";
            $response["user_id"] = $data->id;
            $response["name"] = $data->business_name;
            $response["image"] = $data->photo_user;
            return response()->json($response);
        } else {
            $response["error"] = true;
            $response["message"] = "Usuario y/o contraseña incorrectos.";
            return response()->json($response, 504);
        }

    }


    public function get_create_user()
    {

        echo json_encode(1);

    }


    public function recover_password(RecoverPasswordRequest $request)
    {

        $response = array();
        $response["error"] = true;
        $response["message"] = "";

        $user = AppUser::where("email", $request->email);

        if ($user->count() == 1) {

            $new_password = Pastora::randomPassword();

            $user = $user->first();
            $user->password = md5($new_password);
            $user->save();

            \Mail::send("app.recover_password", ["user" => $user, "nueva_contrasena" => $new_password], function ($message) use ($user) {
                $message->to($user->email)->subject('Restablecimiento de contraseña');
            });

            $response["error"] = false;
            $response["message"] = "Hemos restablecido tu contraseña correctamente. <br> Te hemos enviado un correo electronico con tu nueva contraseña.";
            return response()->json($response);

        } else {
            $response["error"] = true;
            $response["message"] = "Correo electrónico no registrado.";
            return response()->json($response, 504);
        }

    }


    public function create_user_with_facebook(Request $request)
    {

        $response = array();
        $response["error"] = true;
        $response["message"] = "";
        $response["user_id"] = 0;

        //Primero revisamos si existe el usuario en la BD, si ya existe solamente devolvemos el user_id
        $user = AppUser::where("fb_id", $request->id);

        if ($user->count() == 1) {

            $user = $user->first();
            $response["error"] = false;
            $response["message"] = "Login con facebook correctamente";
            $response["user_id"] = $user->id;
            $response["name"] = $user->name . " " . $user->father_last_name . " " . $user->mother_last_name;
            return response()->json($response);

        } else {

            //Si no existe lo registramos
            $data = new AppUser();
            $data->name = $request->name;
            $data->father_last_name = $request->first_name;
            $data->mother_last_name = "";
            $data->email = $request->email;
            $data->responsable_name = "";
            $data->phone = "";
            $data->sign_up_type = "facebook";
            $data->password = "";
            $data->type = "user";
            $data->fb_id = $request->id;

            if ($data->save()) {
                $response["error"] = false;
                $response["message"] = "Tu cuenta ha sido creada correctamente.";
                $response["user_id"] = $data->id;
                $response["name"] = $data->name . " " . $data->father_last_name . " " . $data->mother_last_name;
                return response()->json($response);
            } else {
                $response["error"] = true;
                $response["message"] = "No hemos podido crear tu cuenta, intentalo nuevamente.";
                return response()->json($response, 504);
            }

        }

    }


    public function get_states()
    {

        $data = PostalCode::groupBy("Estado")->pluck("Estado")->toArray();

        return response()->json($data);
    }


    public function get_municipaly_by_state(Request $request)
    {

        $data = PostalCode::groupBy("Municipio")->where("Estado", $request->state)->pluck("Municipio")->toArray();

        return response()->json($data);
    }


    public function get_colony_by_municipaly(Request $request)
    {

        $data = PostalCode::groupBy("Colonia")->where("Municipio", $request->municipaly)->pluck("Colonia")->toArray();

        return response()->json($data);
    }


    public function get_profile_information(Request $request)
    {

        $data = AppUser::find($request->user_id);

        //Obtenemos todos los estados, municipios y colonias
//        $states     = PostalCode::groupBy("Estado")->get(["Estado"])->toArray();
//        $municipaly = PostalCode::groupBy("Municipio")->where("Estado", $data->state)->get(["Municipio"])->toArray();
//        $colony     = PostalCode::groupBy("Colonia")->where("Municipio", $data->municipaly)->get(["Colonia"])->toArray();

        if ($data->photo != "" || $data->photo != null) {
            $data->photo = url($data->photo);
        } else {
            $data->photo = url("assets/images/profile_image.jpg");
        }

        $object = array();
        $object["user"] = $data;

        return response()->json($object);
    }


    public function save_profile(SaveProfileRequest $request)
    {

        $response = array();
        $response["error"] = true;
        $response["message"] = "";

        $data = AppUser::find($request->user_id);
        $data->address = $request->address;
        $data->speciality_area = implode(",", $request->area_speciality);
        $data->colony = $request->colony;
        $data->disability = $request->disability;
        $data->email = $request->email;
        $data->father_last_name = $request->father_last_name;
        $data->mother_last_name = $request->mother_last_name;
        $data->municipaly = $request->municipaly;
        $data->name = $request->name;
        $data->notification_by_speciality = $request->notification_by_speciality;
        $data->notification_near_address = $request->notification_near_address;
        $data->phone = $request->phone;
        $data->postal_code = $request->postal_code;
        $data->state = $request->state;
        $data->birthday = date("Y-m-d", strtotime($request->birthday));
        $data->genere = $request->genere;


        if ($data->save()) {
            $response["error"] = false;
            $response["message"] = "Tu perfil ha sido actualizado correctamente.";
            return response()->json($response);
        } else {
            $response["error"] = true;
            $response["message"] = "No hemos podido crear tu cuenta, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function update_photo(Request $request)
    {

        $response = array();
        $response["error"] = true;
        $response["message"] = "";
        $response["photo"] = "";

        $app_user = AppUser::find($request->user_id);

        //Subimos la foto
        if (!is_dir("assets/photo_users")) {
            mkdir("assets/photo_users", 755);
        }

        $photo_name = $app_user->id . "" . md5(date("Y-m-d H:i:s")) . "." . $request->file("file")->getClientOriginalExtension();

        if ($request->file("file")->move("assets/photo_users", $photo_name)) {

            if ($app_user->photo != "") {
                if (file_exists($app_user->photo)) {
                    unlink($app_user->photo);
                }
            }

            $app_user->photo = "assets/photo_users/" . $photo_name;
            $app_user->save();

            $response["error"] = false;
            $response["message"] = "Fotografía de perfil cargada correctamente.";
            $response["photo"] = url($app_user->photo);
            return response(url($app_user->photo));
        } else {
            $response["error"] = true;
            $response["message"] = "No hemos podido cargar tu fotografía de perfil, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function save_job_experience(SaveJobExperienceRequest $request)
    {

        //place
        //duration
        //position
        //actual_job
        //user_id

        $response = array();
        $response["error"] = true;
        $response["message"] = "";

        if ($request->job_experience_id == null) {
            $data = new JobExperience();
            $response["message"] = "Tu experiencia laboral se ha guardado correctamente.";
        } else {
            $data = JobExperience::find($request->job_experience_id);
            $response["message"] = "Tu experiencia laboral se ha editado correctamente.";
        }

        if (isset($request->no_working)) {

            if ($request->no_working == true) {
                $data->app_user_id = $request->user_id;
                $data->place = "";
                $data->duration = "";
                $data->position = "";
                $data->actual_job = false;
                $data->laboral_function = "";
                $data->no_working = true;
            } else {
                $data->app_user_id = $request->user_id;
                $data->place = $request->place;
                $data->duration = $request->duration;
                $data->position = $request->position;
                $data->actual_job = $request->actual_job;
                $data->laboral_function = $request->laboral_function;
                $data->no_working = false;
            }

        } else {
            $data->app_user_id = $request->user_id;
            $data->place = $request->place;
            $data->duration = $request->duration;
            $data->position = $request->position;
            $data->actual_job = $request->actual_job;
            $data->laboral_function = $request->laboral_function;
        }

        if ($data->save()) {
            $response["error"] = false;
            $response["user_id"] = $data->id;
            return response()->json($response);
        } else {
            $response["error"] = true;
            $response["message"] = "No hemos podido guardar tu experiencia laboral, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function get_job_experiences(Request $request)
    {

        $data = JobExperience::where("app_user_id", $request->app_user_id)->get();

        foreach ($data as $key => $value) {
            $data[$key]["duration_label"] = $value->duration_translate;
        }

        $data = $data->toArray();

        return response()->json($data);
    }


    public function delete_job_experience(Request $request)
    {

        $response = array();
        $response["message"] = "";

        $data = JobExperience::where("id", $request->job_experience_id);

        if ($data->delete()) {
            $response["message"] = "La experiencia laboral se ha eliminado correctamente.";
            return response()->json($response);
        } else {
            $response["message"] = "No hemos podido eliminar la experiencia laboral, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function save_study_experience(SaveStudyExperienceRequest $request)
    {

        //study_level
        //description
        //

        $response = array();
        $response["error"] = true;
        $response["message"] = "";

        if ($request->study_experience_id == null) {
            $data = new StudyExperience();
            $response["message"] = "Tu experiencia de estudio se ha guardado correctamente.";
        } else {
            $data = StudyExperience::find($request->study_experience_id);
            $response["message"] = "Tu experiencia de estudio se ha editado correctamente.";
        }


        if (isset($request->no_study)) {

            if ($request->no_study == true) {
                $data->app_user_id = $request->user_id;
                $data->school_name = "";
                $data->study_level = "";
                $data->description = "";
                $data->study_currently = "";
                $data->no_study = true;
            } else {
                $data->app_user_id = $request->user_id;
                $data->school_name = $request->school_name;
                $data->study_level = $request->study_level;
                $data->description = $request->description;
                $data->study_currently = $request->study_currently;
                $data->no_study = false;
            }

        } else {
            $data->app_user_id = $request->user_id;
            $data->school_name = $request->school_name;
            $data->study_level = $request->study_level;
            $data->description = $request->description;
            $data->study_currently = $request->study_currently;
        }


        if ($data->save()) {
            $response["error"] = false;
            $response["user_id"] = $data->id;
            return response()->json($response);
        } else {
            $response["error"] = true;
            $response["message"] = "No hemos podido guardar tu experiencia de estudio, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function get_study_experiences(Request $request)
    {

        $data = StudyExperience::where("app_user_id", $request->app_user_id)->get();

        $data = $data->toArray();

        return response()->json($data);
    }


    public function delete_study_experience(Request $request)
    {

        $response = array();
        $response["message"] = "";

        $data = StudyExperience::where("id", $request->study_experience_id);

        if ($data->delete()) {
            $response["message"] = "La experiencia de estudio se ha eliminado correctamente.";
            return response()->json($response);
        } else {
            $response["message"] = "No hemos podido eliminar la experiencia de estudio, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function search_jobs(SearchJobRequest $request)
    {

        //puesto_area
        //empresa
        //municipio

        $response = array();
        $response["data"] = "";
        $response["message"] = "";

        $jobs = new Job();

        if ($request->puesto_area != "") {
            $jobs = $jobs->where("jobs.job_title", "LIKE", "%" . $request->puesto_area . "%");
        }

        if ($request->empresa != "") {
            $jobs = $jobs->whereHas("employer", function ($query) use ($request) {
                $query->where("app_users.business_name", "like", "%" . $request->empresa . "%");
            });
        }

        if ($request->municipio != "") {
            $jobs = $jobs->whereRaw("( jobs.colony LIKE '%" . $request->municipio . "%' OR jobs.municipaly LIKE '%" . $request->municipio . "%' OR jobs.state LIKE '%" . $request->municipio . "%' )");
        }

        $jobs = $jobs->where("status", "publish")->where("publish", 1);


        if ($jobs->count() > 0) {
            $jobs = $jobs->with(["categories", "employer"])->orderBy("disbaled_at", "DESC")->get()->toArray();
            return response()->json($jobs);
        } else {
            $response["message"] = "No existen empleos con los criterios de busqueda ingresados.";
            return response()->json($response, 504);
        }

    }


    public function get_jobs_paginated(Request $request)
    {

        //puesto_area
        //empresa
        //municipio

        $response = array();
        $response["data"] = "";
        $response["message"] = "";

        $jobs = new Job();
        $limit = 8;
        $offset = $request->count_get_jobs * $limit;

        if ($request->search_job["puesto_area"] != "") {
            $jobs = $jobs->where("jobs.job_title", "LIKE", "%" . $request->search_job["puesto_area"] . "%");
        }

        if ($request->search_job["empresa"] != "") {
            $jobs = $jobs->whereHas("employer", function ($query) use ($request) {
                $query->where("app_users.business_name", "like", "%" . $request->search_job["empresa"] . "%");
            });
        }

        if ($request->search_job["municipio"] != "") {
            $jobs = $jobs->whereRaw("( jobs.colony LIKE '%" . $request->search_job["municipio"] . "%' OR jobs.municipaly LIKE '%" . $request->search_job["municipio"] . "%' OR jobs.state LIKE '%" . $request->search_job["municipio"] . "%' )");
        }

        $jobs = $jobs->with(["categories", "employer"])
            ->limit($limit)->offset($offset)
            ->where("status", "publish")->where("publish", 1)
            ->orderBy("highlight_job", "DESC")
            ->orderBy("updated_at", "DESC")
            ->get()->toArray();

        return response()->json($jobs);
    }


    public function get_job(Request $request)
    {

        $jobs = Job::with(["categories", "employer", "school_grade"])->where("id", $request->job_id)->first();

        $how_to_go = $jobs->how_to_go;
        $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
        $string = preg_replace($url, '<p>$0</p>', $how_to_go);
        $jobs->how_to_go = $string;

        //Revisamos si el usuario ya aplico anteriormente a eta vacante
        $already_apply = JobUserApply::where("job_id", $request->job_id)->where("app_user_id", $request->app_user_id);
        if ($already_apply->count() > 0) {
            $jobs->already_apply = true;
        } else {
            $jobs->already_apply = false;
        }

        return response()->json($jobs);
    }


    public function user_apply_job(Request $request)
    {

        $response = array();
        $response["message"] = "";

        $user_apply_job = new JobUserApply();
        $user_apply_job->job_id = $request->job_id;
        $user_apply_job->app_user_id = $request->app_user_id;

        if ($user_apply_job->save()) {
            $response["message"] = "Se han enviado tus datos correctamente.<br>En caso de ser seleccionado como candidato, el empleador se comunicará contigo.";

            $job = Job::find($request->job_id);
            $empresa = AppUser::find($job->app_user_employe_id);
            $candidato = AppUser::find($request->app_user_id);

            //Enviamos la notificacion push a la empresa
            $notification = array();
            $notification["UUID"] = $empresa->getUuids();
            $notification["TEXTO_NOTIFICACION"] = "Tienes un nuevo candidato en tu vacante '" . $job->job_title . "'. Ingresa a la aplicación para más información.";
            $notification["TITLE"] = "Tienes un candidato postulado a tu vacante";
            $notification["ACTION"] = array("open_profile" => $candidato->id);
            Pastora::sendPushNotification($notification);


            //Podemos el perfil como comprado
            $is_buyed = ProfileUserBuyed::where("app_user_employe_id", $job->app_user_employe_id)->where("app_user_id", $job->app_user_id);
            if ($is_buyed->count() <= 0) {
                $profile_user_buyed = new ProfileUserBuyed();
                $profile_user_buyed->app_user_employe_id = $job->app_user_employe_id;
                $profile_user_buyed->app_user_id = $request->app_user_id;
                $profile_user_buyed->save();
            }

            return response()->json($response);
        } else {
            $response["message"] = "No hemos podido registrar tu solicitud a la vacante, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function user_cancel_job(Request $request)
    {

        $response = array();
        $response["message"] = "";

        $user_apply_job = JobUserApply::where("job_id", $request->job_id)->where("app_user_id", $request->app_user_id);
        $job = Job::find($request->job_id);

        if ($user_apply_job->delete()) {

            //Eliminamos la compra del perfil ya que el usuario se despostulo
            ProfileUserBuyed::where("app_user_employe_id", $job->app_user_employe_id)->where("app_user_id", $request->app_user_id)->delete();

            $response["message"] = "Se ha cancelado tu postulación a la vacante correctamente.";
            return response()->json($response);

        } else {
            $response["message"] = "No hemos podido cancelar tu postulación a la vacante, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function search_jobs_by_business_id(SearchJobByBusinessIdRequest $request)
    {

        //business_id

        $response = array();
        $response["data"] = "";
        $response["message"] = "";

        $jobs = Job::where("app_user_employe_id", $request->business_id)->where("status", "publish")->where("publish", 1);

        if ($jobs->count() > 0) {

            $business = AppUser::find($request->business_id);

            return response()->json($business->business_name);
        } else {
            $response["message"] = "No existen empleos con el QR de la empresa escaneada.";
            return response()->json($response, 504);
        }

    }


    public function get_notification_by_user(Request $request)
    {

        $notifications = Notification:: join("app_user_notifications", "notifications.id", "=", "app_user_notifications.notification_id")
            ->where("app_user_notifications.app_user_id", $request->app_user_id)
            ->orderBy("notifications.created_at", "DESC")
            ->get(["notifications.*"])->toArray();

        return response()->json($notifications);
    }


    public function get_jobs_postulated_by_user(Request $request)
    {

        $response = array();
        $response["data"] = "";
        $response["message"] = "";

        $jobs = Job::join("job_user_applies", "job_user_applies.job_id", "=", "jobs.id")
            ->where("job_user_applies.app_user_id", $request->app_user_id)
            ->orderBy("job_user_applies.created_at", "DESC")
            ->with(["categories", "employer"])->get()->toArray();

        return response()->json($jobs);
    }


    public function save_push_notification(Request $request)
    {

        //token
        //app_user_id
        //platform

        $uuid = "";

        //Si no existe el uuid lo agregamos
        $uuid_id = UuidDevice::where("uuid", $request->token)->where("app_user_id", $request->app_user_id);
        if ($uuid_id->count() <= 0) {
            $uuid = new UuidDevice();
        } else {
            $uuid = $uuid_id->first();
        }

        $uuid->app_user_id = $request->app_user_id;
        $uuid->uuid = $request->token;
        $uuid->platform = $request->platform;
        $uuid->save();

        return response()->json(true);
    }


    public function remove_push_notification(Request $request)
    {

        //token
        //app_user_id

        $uuid_id = UuidDevice::where("uuid", $request->token)->where("app_user_id", $request->app_user_id)->delete();
        return response()->json(true);
    }


    //Agrupamos los mensajes mostrando el ultimo por empresa
    public function get_message_to_user(Request $request)
    {

        $chat_rooms = ChatRoom::where("user_1", $request->app_user_id)->orWhere("user_2", $request->app_user_id)->get();

        $messages = array();
        foreach ($chat_rooms as $chat_room) {
            $data = MessagesToUser::where("chat_room_id", $chat_room->id)->with("get_from")->with("get_to")->orderBy("read_message", "ASC")->orderBy("created_at", "DESC")->first();

            $user_chat = null;
            if ($chat_room->user_1 == $request->app_user_id) {
                $data["user_chat"] = AppUser::find($chat_room->user_2);
            } else {
                $data["user_chat"] = AppUser::find($chat_room->user_1);
            }

            $messages[] = $data;
        }

        return response()->json($messages);
    }


    public function get_business_information(Request $request)
    {

        $data = AppUser::find($request->user_id);
        $bussines_addresses = BussinesAddress::where("app_user_id", $request->user_id)->first();
        $bussines_informations = BussinesInformation::where("app_user_id", $request->user_id)->first();


        //Obtenemos todos los estados, municipios y colonias
//        $states     = PostalCode::groupBy("Estado")->get(["Estado"])->toArray();
//        $municipaly = PostalCode::groupBy("Municipio")->where("Estado", $bussines_addresses->state)->get(["Municipio"])->toArray();
//        $colony     = PostalCode::groupBy("Colonia")->where("Municipio", $bussines_addresses->municipaly)->get(["Colonia"])->toArray();

        $data->photo = $data->photo_user;

        $object = array();
        $object["user"] = $data;
//        $object["states"] = $states;
//        $object["municipaly"] = $municipaly;
//        $object["colony"] = $colony;
        $object["bussines_addresses"] = $bussines_addresses;
        $object["bussines_informations"] = $bussines_informations;

        return response()->json($object);
    }


    public function save_profile_business(EditEmployeRequest $request)
    {

        $response = array();
        $response["error"] = true;
        $response["message"] = "";
        $response["user_id"] = 0;

        $data = AppUser::find($request->app_user_id);
        $data->name = "";
        $data->father_last_name = "";
        $data->mother_last_name = "";
        $data->email = $request->general_information["email"];
        $data->responsable_name = "";
        $data->phone = "";
        $data->sign_up_type = "email";
        $data->type = "employer";
        $data->business_name = $request->business_name;

        if ($request->general_information["password"] != "") {
            $data->password = md5($request->general_information["password"]);
        }


        if ($data->save()) {

            $bussines_information = BussinesInformation::where("app_user_id", $request->app_user_id)->first();
            //$bussines_information->app_user_id                          = $data->id;

            if ($request->type == "moral") {
                $bussines_information->type = "moral";
                $bussines_information->razon_social = $request->moral["razon_social"];
                $bussines_information->commercial_denomination = $request->moral["commercial_denomination"];
                $bussines_information->rfc = $request->moral["rfc"];
                $bussines_information->responsable_name = $request->moral["responsable_name"];
                $bussines_information->name = "";
                $bussines_information->father_last_name = "";
                $bussines_information->mother_last_name = "";
            } else {
                $bussines_information->type = "fisica";
                $bussines_information->razon_social = "";
                $bussines_information->commercial_denomination = "";
                $bussines_information->rfc = "";
                $bussines_information->responsable_name = "";
                $bussines_information->name = $request->fisica["name"];
                $bussines_information->father_last_name = $request->fisica["father_last_name"];
                $bussines_information->mother_last_name = $request->fisica["mother_last_name"];
            }

            $bussines_information->save();

            $bussines_address = BussinesAddress::where("app_user_id", $request->app_user_id)->first();
            $bussines_address->address = $request->address["address"];
            $bussines_address->interior_exterior_number = $request->address["interior_exterior_number"];
            $bussines_address->postal_code = $request->address["postal_code"];
            $bussines_address->country = $request->address["country"];
            $bussines_address->state = $request->address["state"];
            $bussines_address->municipaly = $request->address["municipaly"];
            $bussines_address->colony = $request->address["colony"];
            $bussines_address->email = $request->address["email"];
            $bussines_address->phone = $request->address["phone"];
            $bussines_address->save();

            $response["error"] = false;
            $response["message"] = "Tu cuenta ha sido actualizada correctamente.";
            $response["user_id"] = $data->id;
            $response["name"] = $request->business_name;
            $response["image"] = $data->photo_user;
            return response()->json($response);
        } else {
            $response["error"] = false;
            $response["message"] = "No hemos podido actualizar tu cuenta, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function get_job_plans(Request $request)
    {

        $data = PackageSell::orderBy("price", "ASC")->get();

        return response()->json($data);
    }


    public function get_job_plan(Request $request)
    {

        $data = PackageSell::find($request->plan_id);

        return response()->json($data);
    }


    public function get_last_card_payment(Request $request)
    {

        //app_user_id

        $card_payment = array();
        $card_payment["error"] = false;
        $card_payment["data"] = "";

        $app_user = AppUser::find($request->app_user_id);
        if ($app_user->token_card != "") {
            $card_payment = Pastora::getCardInfoByToken($app_user->id, $app_user->token_card);

            if ($card_payment["data"] != "") {
                $card_payment["data"]->maskedNumber = chunk_split($card_payment["data"]->maskedNumber, 4, ' ');
                $card_payment["data"]->card_type_method = $app_user->card_type;
            }


        }

        return response()->json($card_payment);
    }


    public function add_package_to_user($app_user, $package, $reference_code, $status, $boucher = "", $tipo = "", $store_name = "", $required_invoice = false, $card_type = "")
    {

        $today_date = new Carbon();

        $package_buyed_by_user = new PackagesBuyedByUser();
        $package_buyed_by_user->app_user_id = $app_user->id;
        $package_buyed_by_user->package_id = $package->id;
        $package_buyed_by_user->type = $tipo;
        $package_buyed_by_user->card_type = $card_type;
        $package_buyed_by_user->status = $status;
        $package_buyed_by_user->package_name = $package->name;
        $package_buyed_by_user->reference_code = $reference_code;
        $package_buyed_by_user->original_duration_plan_in_days = $package->duration_plan_in_days;
        $package_buyed_by_user->original_total_jobs_to_post = $package->total_jobs_to_post;
        $package_buyed_by_user->original_total_profiles_to_view = $package->total_profiles_to_view;
        $package_buyed_by_user->original_duration_in_days = $package->duration_in_days;
        $package_buyed_by_user->original_destacable = $package->destacable;
        $package_buyed_by_user->original_price = $package->price;
        $package_buyed_by_user->count_total_jobs_to_post = $package->total_jobs_to_post;
        $package_buyed_by_user->count_total_profiles_to_view = $package->total_profiles_to_view;
        $package_buyed_by_user->count_destacable = $package->destacable;
        $package_buyed_by_user->package_disbaled_at = $today_date->addDays($package->duration_plan_in_days)->format("Y-m-d H:i:s");
        $package_buyed_by_user->pdf_boucher = $boucher;
        $package_buyed_by_user->store_name = $store_name;
        $package_buyed_by_user->is_require_invoice = ($required_invoice) ? 1 : 0;
        $package_buyed_by_user->is_invoice_generated = 0;
        $package_buyed_by_user->save();

        //Solamente generara la factura cuando el usuario lo requiera y el pago se halla procesado correctamente
        if ($required_invoice && $status == "APPROVED") {
            Pastora::generateInvoice($package_buyed_by_user->id);
        }

        return $package_buyed_by_user->id;
    }


    public function get_packaged_buyed(Request $request)
    {

        $packaged_buyed = PackagesBuyedByUser:: where("app_user_id", $request->app_user_id)
            ->where("status", "APPROVED")
            ->orderBy("created_at", "DESC")
            //->orderBy("status", "DESC")
            ->get();

        return response()->json($packaged_buyed);
    }


    public function get_job_by_employer(Request $request)
    {

        $this->check_job_disabled($request->app_user_id);

        $jobs = Job::where("app_user_employe_id", $request->app_user_id)
            ->orderByRaw(\DB::raw("FIELD(status, 'publish', 'eraser' )"))
            ->orderBy("created_at")->with("school_grade")->get();

        return response()->json($jobs);
    }


    public function check_job_disabled($app_user_id)
    {

        $jobs = Job::where("app_user_employe_id", $app_user_id)->get();

        foreach ($jobs as $job) {
            $job = Job::find($job->id);

            if ($job->disbaled_at != null) {

                $disabled_at = Carbon::createFromFormat("Y-m-d H:i:s", $job->disbaled_at);
                $now = Carbon::now();

                if ($disabled_at->lessThan($now)) {
                    $job->delete();
                }

            }

        }

    }


    public function get_job_information(Request $request)
    {

        $response = array();
        $response["job"] = "";
        $response["categories"] = "";
        $response["school_grades"] = "";
        $response["languages"] = "";

        //job_id

        $job = Job::find($request->job_id);

        //Obtenemos todos los estados, municipios y colonias
//        $states     = PostalCode::groupBy("Estado")->get(["Estado"])->toArray();
//        $municipaly = PostalCode::groupBy("Municipio")->where("Estado", $job->state)->get(["Municipio"])->toArray();
//        $colony     = PostalCode::groupBy("Colonia")->where("Municipio", $job->municipaly)->get(["Colonia"])->toArray();

        $response["job"] = $job;
        $response["categories"] = Category::get();
        $response["school_grades"] = SchoolGrade::get();
        $response["languages"] = Language::get();
//        $response["states"] = $states;
//        $response["municipaly"] = $municipaly;
//        $response["colony"] = $colony;


        return response()->json($response);
    }


    public function save_job(SaveJobRequest $request)
    {

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        if ($request->id == "") {
            $job = new Job();
        } else {
            $job = Job::find($request->id);
        }

        $job->id = $request->id;
        $job->app_user_employe_id = $request->app_user_employe_id;
        $job->job_title = $request->job_title;
        $job->category_id = $request->category_id;
        $job->description = $request->description;
        $job->minimun_age = $request->minimun_age;
        $job->maximum_age = $request->maximum_age;
        $job->sex = $request->sex;
        $job->school_grade_id = $request->school_grade_id;
        $job->experience = $request->experience;
        $job->languages_id = implode(",", $request->languages_id);
        $job->functions = $request->functions;
        $job->benefist = $request->benefist;
        $job->street = $request->street;
        $job->number = $request->number;
        $job->postal_code = $request->postal_code;
        $job->state = $request->state;
        $job->municipaly = $request->municipaly;
        $job->colony = $request->colony;
        $job->how_to_go = $request->how_to_go;
        $job->is_private = $request->is_private;
        $job->highlight_job = $request->highlight_job;
        $job->status = "eraser";

        if ($job->save()) {
            $response["error"] = false;
            $response["message"] = "Se ha guardado la vacante como borrador.";
            return response()->json($response);
        } else {
            $response["error"] = true;
            $response["message"] = "";
            return response()->json($response, 504);
        }

    }


    public function get_job_categories()
    {

        $categories = Category::get();

        return response()->json($categories);

    }


    public function get_school_categories()
    {

        $categories = SchoolGrade::get();

        return response()->json($categories);

    }


    public function get_data_new_job()
    {

        $response = array();
        $response["categories"] = "";
        $response["school_grades"] = "";
        $response["languages"] = "";

        //Obtenemos todos los estados, municipios y colonias
        //$states     = PostalCode::groupBy("Estado")->get(["Estado"])->toArray();

        $response["categories"] = Category::get();
        $response["school_grades"] = SchoolGrade::get();
        $response["languages"] = Language::get();
        //$response["states"] = $states;


        return response()->json($response);
    }


    public function save_job_to_post(PostJobRequest $request)
    {

        //job_information
        //package_id_choosed

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        $job = Job::find($request->id);

        $job->id = $request->id;
        $job->app_user_employe_id = $request->app_user_employe_id;
        $job->job_title = $request->job_title;
        $job->category_id = $request->category_id;
        $job->description = $request->description;
        $job->minimun_age = $request->minimun_age;
        $job->maximum_age = $request->maximum_age;
        $job->sex = $request->sex;
        $job->school_grade_id = $request->school_grade_id;
        $job->experience = $request->experience;
        $job->languages_id = implode(",", $request->languages_id);
        $job->functions = $request->functions;
        $job->benefist = $request->benefist;
        $job->street = $request->street;
        $job->number = $request->number;
        $job->postal_code = $request->postal_code;
        $job->state = $request->state;
        $job->municipaly = $request->municipaly;
        $job->colony = $request->colony;
        $job->how_to_go = $request->how_to_go;
        $job->is_private = $request->is_private;
        $job->highlight_job = $request->highlight_job;
        $job->status = "eraser";

        if ($job->save()) {
            $response["error"] = false;
            $response["message"] = "Se ha guardado la vacante correctamente.";
            return response()->json($response);
        } else {
            $response["error"] = true;
            $response["message"] = "";
            return response()->json($response, 504);
        }

    }


    public function validate_fields_of_job(PostJobRequest $request)
    {

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        return response()->json($response);

    }


    public function save_job_to_post_new_object(PostJobRequest $request)
    {

        //job_information
        //package_id_choosed

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        DB::beginTransaction();

        $job = new Job();

        $job->app_user_employe_id = $request->app_user_employe_id;
        $job->job_title = $request->job_title;
        $job->category_id = $request->category_id;
        $job->description = $request->description;
        $job->minimun_age = $request->minimun_age;
        $job->maximum_age = $request->maximum_age;
        $job->sex = $request->sex;
        $job->school_grade_id = $request->school_grade_id;
        $job->experience = $request->experience;
        $job->languages_id = implode(",", $request->languages_id);
        $job->functions = $request->functions;
        $job->benefist = $request->benefist;
        $job->street = $request->street;
        $job->number = $request->number;
        $job->postal_code = $request->postal_code;
        $job->state = $request->state;
        $job->municipaly = $request->municipaly;
        $job->colony = $request->colony;
        $job->how_to_go = $request->how_to_go;
        $job->is_private = $request->is_private;
        $job->highlight_job = $request->highlight_job;
        $job->status = "eraser";

        if ($job->save()) {

            //Si se guardo el empleo correctamente, ahora lo publicamos
            $request_to_post_job = Request();
            $request_to_post_job->setMethod("POST");
            $request_to_post_job->request->add(["package_id_choosed" => $request->package_id_choosed, "job_id" => $job->id]);
            $status_publish_job = $this->post_job($request_to_post_job);
            $status_publish_job = $status_publish_job->getData();

            if (!$status_publish_job->error) {

                DB::commit();

                $this->send_push_notification_by_near_address_and_speciality($job);

                $response["error"] = false;
                $response["message"] = $status_publish_job->message;
                return response()->json($response);

            } else {

                DB::rollBack();

                $response["error"] = true;
                $response["message"] = $status_publish_job->message;
                return response()->json($response, 504);
            }

        } else {
            $response["error"] = true;
            $response["message"] = "";
            return response()->json($response, 504);
        }

    }


    public function get_packaged_buyed_available(Request $request)
    {

        //type_credits
        //app_user_id

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        $packaged_buyed = PackagesBuyedByUser::where("app_user_id", $request->app_user_id)->where("status", "APPROVED")->orderBy("created_at", "DESC");

        if ($packaged_buyed->count() > 0) {
            $packaged_buyed = $packaged_buyed->get();
            return response()->json($packaged_buyed);
        } else {

            //Variable para nueva version
            if (isset($request->type_credits)) {
                if ($request->type_credits == "profile_to_view") {
                    $response["error"] = true;
                    $response["message"] = "No cuentas con suficientes créditos para ver la información del candidato, ingresa a 'Adquirir planes o paquetes' desde el menú principal y adquiere un plan para continuar.";
                    return response()->json($response, 504);
                } else {
                    return response()->json(0);
                }
            } else {
                return response()->json(0);
            }

        }

    }


    public function delete_job(Request $request)
    {

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        $job = Job::find($request->id);

        if ($job->delete()) {
            $response["error"] = false;
            $response["message"] = "La vacante se ha eliminado correctamente.";
            return response()->json($response);
        } else {
            $response["error"] = false;
            $response["message"] = "No hemos podido elimninar la vacante, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function post_job(Request $request)
    {

        //package_id_choosed
        //job_id

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        //Revisamos que creditos se ocupan
        $job = Job::find($request->job_id);
        $package = PackagesBuyedByUser::find($request->package_id_choosed);

        $credits_to_use = array();
        $credits_to_use[] = "job_to_post";

        if ($job->highlight_job) {
            $credits_to_use[] = "destacable";
        }

        //Revisamos si hay suficientes creditos, si los hay se descontarán de forma automatica
        //enough_credits
        //message
        $do_post_job = $this->use_credits($credits_to_use, $request->package_id_choosed);

        //Si se descontaron los creditos
        if ($do_post_job["enough_credits"]) {

            $job_disbaled_at = Carbon::now()->addDays($package->original_duration_in_days);
            $job->disbaled_at = $job_disbaled_at->format("Y-m-d H:i:s");
            $job->status = "publish";
            $job->publish = 0;
            $job->unpublish_reason = null;
            $job->packages_buyed_by_users_id = $request->package_id_choosed;
            $job->save();

            $this->send_push_notification_by_near_address_and_speciality($job);

            $response["error"] = false;
            $response["message"] = "Hemos recibido tu vacante correctamente, podrá ser publicado dentro de las próximas 48 hrs.";
            return response()->json($response);

        } else {
            $response["error"] = true;
            $response["message"] = $do_post_job["message"];
            return response()->json($response, 504);
        }

    }


    public function get_candidates_by_busines_app_user(Request $request)
    {

        $users_postulated = Job::join("job_user_applies", "job_user_applies.job_id", "=", "jobs.id")
            ->join("app_users", "app_users.id", "=", "job_user_applies.app_user_id")
            ->leftJoin("profile_user_buyeds", "profile_user_buyeds.app_user_id", "=", "app_users.id")
            ->where("jobs.app_user_employe_id", $request->app_user_id)
            ->orderBy("job_user_applies.created_at", "DESC")
            ->groupBy("app_users.id")
            ->get(["job_user_applies.created_at as fecha_postulado", "profile_user_buyeds.id as profile_buyed", "jobs.job_title", "app_users.*"]);

        foreach ($users_postulated as $key => $value) {
            if ($value->photo == "") {
                $users_postulated[$key]["photo_user"] = "assets/img/icon_user.png";
            } else {
                $users_postulated[$key]["photo_user"] = url($value->photo);
            }
        }

        return response()->json($users_postulated);
    }


    public function get_profile_information_with_details(Request $request)
    {

        //app_user_id: "50"
        //profile_id: 27

        $app_user = AppUser::with("job_experiences")->with("study_experiences")->where("id", $request->profile_id)->first();
        $profile_user_buyed = ProfileUserBuyed::where("app_user_employe_id", $request->app_user_id)->where("app_user_id", $request->profile_id)->first();

        if ($profile_user_buyed != null) {
            $app_user->buyed = 1;
        } else {
            $app_user->buyed = 0;
        }

        return response()->json($app_user);
    }


    public function buy_view_profile(Request $request)
    {

        //package_id_choosed
        //profile_id

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        //Revisamos que creditos se ocupan
        $package = PackagesBuyedByUser::find($request->package_id_choosed);

        $credits_to_use = array();
        $credits_to_use[] = "profile_to_view";

        //Revisamos si hay suficientes creditos, si los hay se descontarán de forma automatica
        //enough_credits
        //message
        $do_post_job = $this->use_credits($credits_to_use, $request->package_id_choosed);

        //Si se descontaron los creditos
        if ($do_post_job["enough_credits"]) {

            //Insertamos el perfil del usuario que ya fue comprado
            $profile_user_buyed = new ProfileUserBuyed();
            $profile_user_buyed->app_user_employe_id = $package->app_user_id;
            $profile_user_buyed->app_user_id = $request->profile_id;
            $profile_user_buyed->save();

            $response["error"] = false;
            $response["message"] = "";
            return response()->json($response);

        } else {
            $response["error"] = true;
            $response["message"] = $do_post_job["message"];
            return response()->json($response, 504);
        }

    }


    public function search_candidates(SearchCandidatesRequest $request)
    {

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        //Validamos que al menos halla ingresado una palabra a buscar
        if ($request->keywords == null &&
            $request->minimiun_age == null &&
            $request->maximium_age == null &&
            $request->genere == null &&
            $request->school_grades == null &&
            $request->state == null &&
            $request->municipaly == null) {

            $response["error"] = true;
            $response["message"] = "Ingresa al menos un parámetro para buscar candidatos.";

            return response()->json($response, 504);
        }

        $app_users = new AppUser();


        if ($request->genere != "" && $request->genere != "Indistinto") {
            $app_users = $app_users->where("genere", $request->genere);
        }

        if ($request->school_grades != "") {
            $app_users = $app_users->whereHas("study_experiences", function ($query) use ($request) {
                $query->where("study_experiences.study_level", $request->school_grades);
            });
        }

        if ($request->state != "") {
            $app_users = $app_users->where("state", "LIKE", "%" . $request->state . "%");
        }

        if ($request->municipaly != "") {
            $app_users = $app_users->where("municipaly", "LIKE", "%" . $request->municipaly . "%");
        }

        if ($request->priority_candidates_with_disability) {
            $app_users = $app_users->where("disability", "!=", "");
        }

        $app_users = $app_users->where("type", "user");


        if ($request->keywords != null) {

            $keywords = explode(",", $request->keywords);

            //Buscamos por el lugar de trabajo
            $app_users = $app_users->whereHas("job_experiences", function ($query) use ($keywords) {

                $i = 0;
                foreach ($keywords as $keyword) {
                    if ($i == 0) {
                        $query->where("job_experiences.place", "LIKE", "%" . trim($keyword) . "%");
                    } else {
                        $query->orWhere("job_experiences.place", "LIKE", "%" . trim($keyword) . "%");
                    }
                    $i++;
                }

                foreach ($keywords as $keyword) {
                    $query->orWhere("job_experiences.position", "LIKE", "%" . trim($keyword) . "%");
                }

            });

        }


        $app_users = $app_users->leftJoin('profile_user_buyeds', function ($join) use ($request) {
            $join->on("profile_user_buyeds.app_user_id", "=", "app_users.id");
            $join->on('profile_user_buyeds.app_user_employe_id', '=', DB::raw($request->app_user_id));
        });


        $app_users = $app_users->get(["profile_user_buyeds.id as profile_buyed", "app_users.*"]);

        if ($request->minimiun_age != null && $request->maximium_age != null) {
            $app_users = $app_users->filter(function ($item) use ($request) {
                if ($item->age != "") {
                    return ($item->age >= $request->minimiun_age && $item->age <= $request->maximium_age);
                } else {
                    return false;
                }
            });
        }


        if ($app_users->count() > 0) {
            return response()->json($app_users);
        } else {
            $response["message"] = "No existen candidatos con los criterios de busqueda ingresados.";
            return response()->json($response, 504);
        }

    }


    public function send_message_to_user(SendMessageRequest $request)
    {

        //message
        //to_id
        //from_id

        $chat_room = null;

        //Primerpo revisamos si ya existe un chat room para ambos usuarios
        $chatroom_exists_1 = ChatRoom::where("user_1", $request->to_id)->where("user_2", $request->from_id);
        $chatroom_exists_2 = ChatRoom::where("user_1", $request->from_id)->where("user_2", $request->to_id);

        if ($chatroom_exists_1->count() == 1) {
            $chat_room = $chatroom_exists_1->first();
        } else {
            if ($chatroom_exists_2->count() == 1) {
                $chat_room = $chatroom_exists_2->first();
            } else {
                $chat_room = new ChatRoom();
                $chat_room->user_1 = $request->to_id;
                $chat_room->user_2 = $request->from_id;
                $chat_room->save();
            }
        }


        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        $message_to_user = new MessagesToUser();
        $message_to_user->chat_room_id = $chat_room->id;
        $message_to_user->from_message = $request->from_id;
        $message_to_user->to_message = $request->to_id;
        $message_to_user->message = $request->message;

        if ($message_to_user->save()) {

            //Enviamos el mensaje push notification al usuario receptor
            $notification = array();
            $notification["UUID"] = UuidDevice::where("app_user_id", $request->to_id)->pluck('uuid')->toArray();
            $notification["TEXTO_NOTIFICACION"] = $request->message;
            $notification["TITLE"] = "Tienes un nuevo mensaje";
            $notification["ACTION"] = array("open" => "messages-user");

            Pastora::sendPushNotification($notification);

            $response["error"] = false;
            $response["message"] = "El mensaje se ha enviado correctamente.";
            return response()->json($response);
        } else {
            $response["error"] = true;
            $response["message"] = "No hemos podido enviar el mensaje, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function make_payment_oxxo(Request $request)
    {

        //this.confirmPaymentStore("OXXO", "Oxxo");
        //this.confirmPaymentStore("SEVEN_ELEVEN", "7 eleven");
        //this.confirmPaymentStore("OTHERS_CASH_MX", "Farmacia del ahorro");
        //this.confirmPaymentStore("OTHERS_CASH_MX", "Benavides");

        //app_user_id
        //package_job.id
        //type_payment
        //store_name

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        $app_user = "";
        $reference_code = Pastora::make_sku();
        $package_buyed_by_user_id = 0;

        $app_user = AppUser::find($request->app_user_id);
        $package = PackageSell::find($request->package_job["id"]);

        $result = Pastora::generateOxxoPayment(env("PAYU_ACCOUNTID"), $reference_code, "Compra de plan " . $package->name, $package->price, $app_user, $request->type_payment);


        //Si no hubo error
        if (!$result["error"]) {

            //mail("jair.lomas@metodika.mx", "Yob - Solicitud pago en " . $request->store_name, "Se ha solicitado un pago en Yob con status '" . $result["data"]->state . "' Referencia: " . $reference_code);

            if ($result["data"]->state == "DECLINED") {

                if ($result["data"]->responseCode == "DECLINED_TEST_MODE_NOT_ALLOWED") {
                    $response["error"] = true;
                    $response["message"] = "No es posible generar cobros para " . $request->store_name . " en modo de pruebas.";
                    return response()->json($response, 504);
                } else {
                    $response["error"] = true;
                    $response["message"] = "No es hemos podido generar el boucher de pago, intentalo nuevamente.";
                    $response["pasarela"] = $result;
                    return response()->json($response, 504);
                }

            } else if ($result["data"]->state == "PENDING") {

                //Se genero el baucher correctamente
                $package_buyed_by_user_id = $this->add_package_to_user($app_user, $package, $reference_code, "PENDING", $result["data"]->extraParameters->URL_PAYMENT_RECEIPT_PDF, $request->type_payment, $request->store_name, $request->include_invoice, "");
                $this->sendEmail($app_user, $result["data"]->extraParameters->URL_PAYMENT_RECEIPT_PDF, $request->store_name);

                $response["error"] = false;

                //Si viene de un empleo
                if (isset($request->job_id)) {

                    $package_buyed_by_user = PackagesBuyedByUser::where("id", $package_buyed_by_user_id)->first();
                    $package_buyed_by_user->job_id_to_publish = $request->job_id;
                    $package_buyed_by_user->save();

                    $response["message"] = "Te hemos enviado por correo electrónico el baucher de pago del plan, una vez recibido el pago se activará el plan en tu cuenta. La vacante seleccionada se activara de forma automática.";
                } else {
                    $response["message"] = "Te hemos enviado por correo electrónico el baucher de pago del plan, una vez recibido el pago se activará el plan en tu cuenta.";
                }

                return response()->json($response);

            }

        } else {
            $response["error"] = true;
            $response["message"] = $result["data"];
            return response()->json($response, 504);
        }

    }


    public function make_payment(MakePaymentCardRequest $request)
    {

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        $token_card = "";
        $app_user = "";
        $card_type = "";
        $reference_code = Pastora::make_sku();

        $app_user = AppUser::find($request->app_user_id);
        $package = PackageSell::find($request->plan_id_to_purchase);

        //Si es nueva tarjeta y acepta que almacenemos la tarjeta, la tokenizamos
        if ($request->use_new_card) {

            $date_card = substr($request->card_data["date"], 0, 7);
            $date_card = Carbon::createFromFormat("Y-m", $date_card);

            $card_number = $request->card_data["number"];
            $card_number = str_replace(" ", "", $card_number);

            $result = Pastora::generateTokenCard($request->app_user_id, $request->card_data["name"], $card_number, $date_card->format("Y/m"), $request->card_data["card_type"]);

            //Si no hubo error
            if (!$result["error"]) {

                $token_card = $result["data"];

                //Almacenamos el token al usuario
                if ($request->save_card_for_future) {
                    $app_user->token_card = $token_card;
                    $app_user->card_type = $request->card_data["card_type_method"];
                    $card_type = $request->card_data["card_type_method"];
                    $app_user->save();
                }

            } else {
                $response["error"] = true;
                $response["message"] = $result["data"];
                return response()->json($response, 504);
            }

        } else {
            //Si usará una tarjeta anterior hacemos el cobro al token
            $token_card = $request->old_card_data["creditCardTokenId"];
            $card_type = $request->old_card_data["card_type_method"];
        }


        //Hacemos el cobro de tarjeta
        $payment_result = Pastora::makePaymentWithToken(env("PAYU_ACCOUNTID"), $reference_code, "Compra de plan " . $package->name, $app_user->email, $package->price, $token_card, $app_user);

        if (!$payment_result["error"]) {

            //mail("jair.lomas@metodika.mx", "Yob - Pago con tarjeta", "Se ha realizado un pago en Yob con status '" . $payment_result["data"]->state . "' Referencia: " . $reference_code);

            if ($payment_result["data"]->state == "DECLINED") {
                //Pago no procesado
                $response["error"] = true;
                $response["message"] = "No hemos podido generar el cobro el banco emisor ha rechazado la transacción, inténtalo nuevamente o ingresa otra tarjeta valida.";
                return response()->json($response, 504);
            } else if ($payment_result["data"]->state == "APPROVED") {

                $package_buyed_by_user_id = $this->add_package_to_user($app_user, $package, $reference_code, "APPROVED", "", "CARD", $request->card_data["card_type"], $request->include_invoice, $card_type);

                //Pago exitoso
                $response["error"] = false;
                if (isset($request->job_id)) {

                    //Obtenemos el unico paquete que se le asigno al usuario
                    $packages_buyed_by_users = PackagesBuyedByUser::where("app_user_id", $app_user->id)->first();

                    //Publicamos el empleo
                    $request_to_post_job = new Request();
                    $request_to_post_job->setMethod("POST");
                    $request_to_post_job->request->add(['job_id' => $request->job_id, "package_id_choosed" => $packages_buyed_by_users->id]);
                    $this->post_job($request_to_post_job);

                    $response["message"] = "Tu pago se ha procesado correctamente, ahora cuentas con créditos activos para usar dentro de Yob. Hemos recibido tu vacante correctamente, podrá ser publicado dentro de las próximas 48 hrs.";
                } else {
                    $response["message"] = "Tu pago se ha procesado correctamente, ahora cuentas con créditos activos para usar dentro de Yob";
                }

            } else if ($payment_result["data"]->state == "PENDING") {
                //Pago pendiente
                $response["error"] = false;
                $response["message"] = "Tu pago esta pendiente de procesar, el banco emisor aprobará el pago para autorizar tu compra dentro de Yob.";
                $package_buyed_by_user_id = $this->add_package_to_user($app_user, $package, $reference_code, "PENDING", "", "CARD", $request->card_data["card_type"], $request->include_invoice, $card_type);
            }

        } else {

            $response["error"] = true;
            $response["message"] = "No hemos podido generar el cobro, inténtalo nuevamente o ingresa otra tarjeta valida.";
            return response()->json($response, 504);
        }

        return response()->json($response);
    }


    public function sendEmail($app_user, $payment_receipt, $store_name)
    {

        \Mail::send("app.baucher_oxxo", ["user" => $app_user, "payment_receipt" => $payment_receipt, "store_name" => $store_name], function ($message) use ($app_user, $payment_receipt) {
            $message->to($app_user->email)->subject('Baucher de pago - Yob');
            $message->attach($payment_receipt, array(
                    'as' => 'bacuher_de_pago' . date("d_m_Y") . '.pdf',
                    'mime' => 'application/pdf')
            );
        });

    }


    public function confirm_payment(Request $request)
    {

        $body = @file_get_contents('php://input');
        $data = json_decode($body);

        //mail("jair.lomas@metodika.mx", "YOB WEBHOOK ", $body);

        File::put("webhook" . date("Y-m-d-H-i-s") . "_.txt", $body);

    }


    public function send_push_notification_by_near_address_and_speciality($job)
    {

        $users_ids_already_send_notification = array();

        //Empleos cerca del lugar
        $app_users = AppUser::where("municipaly", $job->municipaly)->where("notification_near_address", 1)->get();
        foreach ($app_users as $app_user) {

            //Enviamos la notificacion comentando que se dio de alta un empleo cerca de su municipio
            $notification = array();
            $notification["UUID"] = $app_user->getUuids();
            $notification["TEXTO_NOTIFICACION"] = "Hola " . $app_user->name . ", la empresa " . $job->employer["business_name"] . " ha publicado la vacante '" . $job->job_title . "' cerca de ti. Ingresa a la aplicación para más información.";
            $notification["TITLE"] = "¡Nueva vacante cerca de ti!";
            $notification["ACTION"] = array("open_vacante" => $job->id);

            //Almacenamos la notificacion
            $noti = new Notification();
            $noti->title = $notification["TITLE"];
            $noti->text = $notification["TEXTO_NOTIFICACION"];
            $noti->save();

            $app_user_notification = new AppUserNotification();
            $app_user_notification->notification_id = $noti->id;
            $app_user_notification->app_user_id = $app_user->id;
            $app_user_notification->save();

            Pastora::sendPushNotification($notification);
        }


        //Enviamos la notificacion en caso de que la vacante este entre los intereses del usuario
        $category = $job->categories["category"];
        if ($category != "Otros") {
            $app_users = AppUser::where("speciality_area", "LIKE", "%" . $category . "%")->whereNotIn("id", $users_ids_already_send_notification)->where("notification_by_speciality", 1)->get();
            foreach ($app_users as $app_user) {

                //Enviamos la notificacion comentando que se dio de alta un empleo cerca de su municipio
                $notification = array();
                $notification["UUID"] = $app_user->getUuids();
                $notification["TEXTO_NOTIFICACION"] = "Hola " . $app_user->name . ", la empresa " . $job->employer["business_name"] . " ha publicado la vacante '" . $job->job_title . "'. Ingresa a la aplicación para más información.";
                $notification["TITLE"] = "Tal vez esta vacante te interese";
                $notification["ACTION"] = array("open_vacante" => $job->id);

                //Almacenamos la notificacion
                $noti = new Notification();
                $noti->title = $notification["TITLE"];
                $noti->text = $notification["TEXTO_NOTIFICACION"];
                $noti->save();

                $app_user_notification = new AppUserNotification();
                $app_user_notification->notification_id = $noti->id;
                $app_user_notification->app_user_id = $app_user->id;
                $app_user_notification->save();

                Pastora::sendPushNotification($notification);
            }

        }


    }


    public function get_message_list_by_bussines_and_app_user(Request $request)
    {

        //chat_room_id
        //app_user_id
        //limit

        $response = array();
        $limit = 10;
        $offset = $request->limit * $limit;

        //Actualizamos todos estos mensaje en 1
        MessagesToUser::where("chat_room_id", $request->chat_room_id)->update(["read_message" => 1]);

        $data = MessagesToUser::
        limit($limit)
            ->offset($offset)
            ->where("chat_room_id", $request->chat_room_id)
            ->with("get_from")
            ->orderBy("created_at", "DESC")->get();

        $chat_room = ChatRoom::find($request->chat_room_id);
        if ($chat_room->user_1 == $request->app_user_id) {
            $bussiness = AppUser::find($chat_room->user_2);
        } else {
            $bussiness = AppUser::find($chat_room->user_1);
        }


        $response["messages"] = $data;
        $response["bussiness"] = $bussiness;
        $response["limit"] = $limit;

        return response()->json($response);
    }


    //$type_function => job_to_post | profile_to_view | destacable
    public function use_credits($type_functions, $package_buyed_by_user_id)
    {

        $response = array();
        $response["enough_credits"] = false;
        $response["message"] = "";

        $package_buyed_by_user = PackagesBuyedByUser::where("id", $package_buyed_by_user_id);

        if ($package_buyed_by_user->count() == 1) {

            foreach ($type_functions as $type_function) {
                if ($type_function == "job_to_post") {
                    $package_buyed_by_user = $package_buyed_by_user->whereRaw('(count_total_jobs_to_post > 0 OR count_total_jobs_to_post = -1)');
                } else if ($type_function == "profile_to_view") {
                    $package_buyed_by_user = $package_buyed_by_user->whereRaw('(count_total_profiles_to_view > 0 OR count_total_profiles_to_view = -1)');
                } else if ($type_function == "destacable") {
                    $package_buyed_by_user = $package_buyed_by_user->whereRaw('(count_destacable > 0 OR count_destacable = -1)');
                }
            }

            //Si tiene creditos disponibles, los descontamos
            if ($package_buyed_by_user->count() == 1) {

                foreach ($type_functions as $type_function) {
                    if ($type_function == "job_to_post") {
                        PackagesBuyedByUser::where("id", $package_buyed_by_user_id)->where("count_total_jobs_to_post", "!=", "-1")->decrement("count_total_jobs_to_post", 1);
                    } else if ($type_function == "profile_to_view") {
                        PackagesBuyedByUser::where("id", $package_buyed_by_user_id)->where("count_total_profiles_to_view", "!=", "-1")->decrement("count_total_profiles_to_view", 1);
                    } else if ($type_function == "destacable") {
                        PackagesBuyedByUser::where("id", $package_buyed_by_user_id)->where("count_destacable", "!=", "-1")->decrement("count_destacable", 1);
                    }
                }

                $response["enough_credits"] = true;
                $response["message"] = "";

            } else {

                //No tiene creditos suficientes, vemos que no tiene suficiente para mandar el mensaje
                $message = "";
                $package_buyed_by_user = PackagesBuyedByUser::where("id", $package_buyed_by_user_id)->first();

                foreach ($type_functions as $type_function) {
                    if ($type_function == "job_to_post") {
                        $message .= ($package_buyed_by_user->count_total_jobs_to_post == 0) ? "No cuentas con suficientes créditos para publicar vacantes.<br>" : "";
                    } else if ($type_function == "profile_to_view") {
                        $message .= ($package_buyed_by_user->count_total_profiles_to_view == 0) ? "No cuentas con suficientes créditos para ver perfiles de candidatos.<br>" : "";
                    } else if ($type_function == "destacable") {
                        $message .= ($package_buyed_by_user->count_destacable == 0) ? "No cuentas con suficientes créditos para publicar la vacante como destacada.<br>" : "";
                    }
                }

                $response["enough_credits"] = false;
                $response["message"] = $message;
            }

        } else {
            $response["enough_credits"] = false;
            $response["message"] = "No existe el empleo a publicar, intentalo nuevamente.";
        }

        return $response;
    }


    public function make_payment_spei(Request $request)
    {

        //app_user_id
        //package_job

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        $app_user = "";
        $reference_code = Pastora::make_sku();

        $app_user = AppUser::find($request->app_user_id);
        $package = PackageSell::find($request->package_job["id"]);

        $result = Pastora::generateSpeiPayment(env("PAYU_ACCOUNTID"), $reference_code, "Compra de plan " . $package->name, $package->price, $app_user);


        //Si no hubo error
        if (!$result["error"]) {

            //mail("jair.lomas@metodika.mx", "Yob - Solicitud pago en " . $request->store_name, "Se ha solicitado un pago en Yob con status '" . $result["data"]->state . "' Referencia: " . $reference_code);

            if ($result["data"]->state == "DECLINED") {

                if ($result["data"]->responseCode == "DECLINED_TEST_MODE_NOT_ALLOWED") {
                    $response["error"] = true;
                    $response["message"] = "No es posible generar cobros para " . $request->store_name . " en modo de pruebas.";
                    return response()->json($response, 504);
                } else {
                    $response["error"] = true;
                    $response["message"] = "No es hemos podido generar el boucher de pago, intentalo nuevamente.";
                    return response()->json($response, 504);
                }

            } else if ($result["data"]->state == "PENDING") {

                //Se genero el baucher correctamente
                $response["error"] = false;
                $response["message"] = "Te hemos enviado por correo electrónico el baucher de pago del plan, una vez recibido el pago se activará el plan en tu cuenta.";
                $package_buyed_by_user_id = $this->add_package_to_user($app_user, $package, $reference_code, "PENDING", $result["data"]->extraParameters->URL_PAYMENT_RECEIPT_PDF, $request->type_payment, $request->store_name, $request->include_invoice, "");
                $this->sendEmail($app_user, $result["data"]->extraParameters->URL_PAYMENT_RECEIPT_PDF, $request->store_name);
                return response()->json($response);

            }

        } else {
            $response["error"] = true;
            $response["message"] = $result["data"];
            return response()->json($response, 504);
        }

    }


    public function get_invoice_information(Request $request)
    {

        $invoice_information = AppUserInvoice::where("app_user_id", $request->user_id)->first();

        //Si no tiene cargada la información de facturación, precargamos la informacion con la que cargo al momento de registrarse
        if ($invoice_information == null) {

            $invoice_information = new AppUserInvoice();
            $invoice_information->social_reason = "";
            $invoice_information->comercial_name = "";
            $invoice_information->rfc = "";
            $invoice_information->fiscal_address = "";
            $invoice_information->email_send_invoice = "";
            $invoice_information->cfdi_use = "";
            $invoice_information->payment_method = "";
            $invoice_information->payment_form = "";

            $bussines_informations = BussinesInformation::where("app_user_id", $request->user_id)->first();
            $invoice_information->social_reason = $bussines_informations->razon_social;
            $invoice_information->comercial_name = $bussines_informations->commercial_denomination;
            $invoice_information->rfc = $bussines_informations->rfc;

        }

        return response()->json($invoice_information);
    }


    public function save_invoice_information(UpdateInvoiceInformationRequest $request)
    {

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        //social_reason: "",
        //comercial_name: "",
        //cp: ""
        //rfc: "",
        //fiscal_address: "",
        //email_send_invoice: ""

        $invoice_information = AppUserInvoice::where("app_user_id", $request->user_id)->first();

        if ($invoice_information == null) {
            $invoice_information = new AppUserInvoice();
        }

        $invoice_information->app_user_id = $request->user_id;
        $invoice_information->social_reason = $request->invoice["social_reason"];
        $invoice_information->comercial_name = $request->invoice["comercial_name"];
        $invoice_information->cp = $request->invoice["cp"];
        $invoice_information->rfc = $request->invoice["rfc"];
        $invoice_information->fiscal_address = $request->invoice["fiscal_address"];
        $invoice_information->email_send_invoice = $request->invoice["email_send_invoice"];
        $invoice_information->cfdi_use = "G03";
        $invoice_information->payment_method = "PUE";
        $invoice_information->payment_form = "99";

        if ($invoice_information->save()) {
            $response["error"] = false;
            $response["message"] = "Los datos de facturación se han actualizado correctamente.";
            return response()->json($response);
        } else {
            $response["error"] = true;
            $response["message"] = "No hemos podido actualizar tus datos de facturación, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function check_invoice_information(Request $request)
    {

        $response = array();
        $response["message"] = "";

        $invoice_information = AppUserInvoice::where("app_user_id", $request->user_id)->first();


        if ($invoice_information != null) {
            $response["message"] = "Si tiene datos de facturacion";
            return response()->json($response);
        } else {
            $response["message"] = "No cuentas con datos de facturación. Ingresa tus datos de facturación o deselecciona la opción de incluir factura en tu compra para continuar.";
            return response()->json($response, 504);
        }

    }


    public function testqr()
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
        //$pending_orders = PackagesBuyedByUser::where("status", "PENDING")->where("type", "!=", "CARD")->get();
        $pending_orders = PackagesBuyedByUser::where("reference_code", "YOB-4914-YW")->get();
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
                    //if ($response[0]->transactions[0]->transactionResponse->state == "APPROVED") {
                    if (true) {
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


                        //Si viene de un empleo, lo aprobamos
                        if ($pending_order->job_id_to_publish != 0) {

                            //Publicamos el empleo
                            $request_to_post_job = new Request();
                            $request_to_post_job->setMethod("POST");
                            $request_to_post_job->request->add(['job_id' => $pending_order->job_id_to_publish, "package_id_choosed" => $pending_order->id]);
                            //$this->post_job($request_to_post_job);
                            $api_controller = new APIController();
                            $api_controller->post_job($request_to_post_job);

                            $response["message"] = "Tu pago se ha procesado correctamente, ahora cuentas con créditos activos para usar dentro de Yob. Hemos recibido tu vacante correctamente, podrá ser publicado dentro de las próximas 48 hrs.";
                        }


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


    public function save_job_as_eraser_obligated_fields(PostJobRequest $request)
    {

        //job_information
        //package_id_choosed

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        DB::beginTransaction();

        $job = new Job();

        $job->app_user_employe_id = $request->app_user_employe_id;
        $job->job_title = $request->job_title;
        $job->category_id = $request->category_id;
        $job->description = $request->description;
        $job->minimun_age = $request->minimun_age;
        $job->maximum_age = $request->maximum_age;
        $job->sex = $request->sex;
        $job->school_grade_id = $request->school_grade_id;
        $job->experience = $request->experience;
        $job->languages_id = implode(",", $request->languages_id);
        $job->functions = $request->functions;
        $job->benefist = $request->benefist;
        $job->street = $request->street;
        $job->number = $request->number;
        $job->postal_code = $request->postal_code;
        $job->state = $request->state;
        $job->municipaly = $request->municipaly;
        $job->colony = $request->colony;
        $job->how_to_go = $request->how_to_go;
        $job->is_private = $request->is_private;
        $job->highlight_job = $request->highlight_job;
        $job->status = "eraser";

        if ($job->save()) {

            DB::commit();

            //Si se guardo el empleo como borrador, retornamos el id del mismo
            $response["error"] = false;
            $response["message"] = "";
            $response["job_id"] = $job->id;
            return response()->json($response);

        } else {

            DB::rollBack();

            $response["error"] = true;
            $response["message"] = "No hemos podido almacenar el empleo, intentalo nuevamente.";
            return response()->json($response, 504);
        }

    }


    public function check_if_job_process_with_plan(Request $request)
    {

        //app_user_id
        //plan_id
        //job_id

        $response = array();
        $response["error"] = false;
        $response["message"] = "";

        $job = Job::find($request->job_id);
        $package_sells = PackageSell::where("id", $request->plan_id);

        //El empleo se va a poner como destacado
        if ($job->highlight_job == 1) {
            $package_sells = $package_sells->where("destacable", ">=", 1);
        }

        $package_sells = $package_sells->where("total_jobs_to_post", ">=", 1)->count();

        if ($package_sells > 0) {
            return response()->json(true);
        } else {
            $response["message"] = "El plan seleccionado no cuenta con suficientes creditos para publicar la vacante, selecciona otro plan.";
            return response()->json($response, 504);
        }

    }


 

    public function get_job_title_to_search(Request $request)
    {

        $total_items = 20;
        $page = $request->page * $total_items;

        $items_puesto = array();
        $items_puesto = DB::select(DB::RAW('SELECT job_title FROM jobs WHERE job_title is not null AND status = "publish" AND publish = 1 AND job_title LIKE "%' . $request->job_title . '%" GROUP BY job_title ORDER BY job_title LIMIT ' . $page . ', ' . $total_items . ' '));
        $items_puesto = array_column($items_puesto, "job_title");

        return response()->json($items_puesto);
    }


    public function get_job_business_to_search(Request $request)
    {

        $total_items = 20;
        $page = $request->page * $total_items;

        $items_business = array();
        $items_business = DB::select(DB::RAW('SELECT app_users.business_name FROM jobs  JOIN app_users ON app_users.id = jobs.app_user_employe_id WHERE app_users.business_name is not null AND app_users.business_name LIKE "%' . $request->business_name . '%" AND jobs.status = "publish" AND jobs.publish = 1 GROUP BY app_users.id ORDER BY app_users.business_name LIMIT ' . $page . ', ' . $total_items . ' '));
        $items_business = array_column($items_business, "business_name");

        return response()->json($items_business);
    }


    public function get_job_location_to_search(Request $request)
    {

        $total_items = 20;
        $page = $request->page * $total_items;

        $items_location = array();
        $items_location = DB::select(DB::RAW('  (SELECT colony as location FROM jobs WHERE colony is not null AND status = "publish" AND publish = 1 AND colony LIKE "%' . $request->location_name . '%" GROUP BY colony ORDER BY colony)
                                                UNION
                                                (SELECT municipaly as location FROM jobs WHERE municipaly is not null AND status = "publish" AND publish = 1 AND municipaly LIKE "%' . $request->location_name . '%" GROUP BY municipaly ORDER BY municipaly)
                                                UNION
                                                (SELECT state as location FROM jobs WHERE state is not null AND status = "publish" AND publish = 1 AND state LIKE "%' . $request->location_name . '%" GROUP BY state ORDER BY state)
                                                LIMIT ' . $page . ', ' . $total_items . ''));
        $items_location = array_column($items_location, "location");

        return response()->json($items_location);
    }


}

















