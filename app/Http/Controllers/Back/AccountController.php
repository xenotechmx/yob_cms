<?php

namespace MetodikaTI\Http\Controllers\Back;

use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Http\Requests\Back\Account\LoginRequest;
use MetodikaTI\Http\Requests\Back\Account\ResetPasswordRequest;
use MetodikaTI\Library\Pastora;
use MetodikaTI\PasswordResets;
use MetodikaTI\User;
use Session;
use Illuminate\Support\Facades\Mail;


class AccountController extends Controller
{
    use ResetsPasswords;
    protected $tokens;

    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->subject = 'Recuperación de contraseña';
    }

    /**
     * [getHome description]
     * @return [type] [description]
     */
    public function getHome()
    {
        return view('back.account.home');
    }

//    public function getHomeAdmin()
//    {
//        return view('back.account.home_admin');
//    }



    /**
     * [postLogin description]
     * @param  LoginRequest $request [description]
     * @return [type]                [description]
     */
    public function postLogin(LoginRequest $request)
    {

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->intended('cms/dashboard');
        } else {
            Session::flash('loginError', true);
            Session::flash('loginMsg', 'Cuenta de correo y/o contraseña incorrectos.');
            return redirect()->intended('cms');
        }

    }

    protected function guard()
    {
        return Auth::guard('clients');
    }


    public function getLogout()
    {
        Auth::logout();

        return redirect("cms");
    }



    public function getRecovery()
    {
        return view('back.account.recovery');
    }


    public function postReset(Request $request){

        $response = array();
        $response["status"] = false;
        $response["message"] = "";

        $new_password = Pastora::randomPassword();

        $user = User::where("email", $request->email)->first();

        if( $user != null ){

            $user->password = bcrypt($new_password);

            if( $user->save() ){

                \Mail::send("mail.recover_password", ["user" => $user, "new_password" => $new_password], function ($message) use($user) {
                    $message->to($user->email)->subject('Recuperación de contraseña');
                });

                $response["status"] = true;
                $response["message"] = "Se ha restablecido correctamente tu contraseña de acceso. Te hemos enviado un correo electrónico con tu nueva contraseña.";
                $response["url"] = url("cms");

            }else{
                $response["status"] = false;
                $response["message"] = "El correo electrónico no se encuentra registrado, intentalo nuevamente.";
            }

        }else{
            $response["status"] = false;
            $response["message"] = "El correo electrónico no se encuentra registrado, intentalo nuevamente.";
        }

        return response()->json($response);
    }






 }