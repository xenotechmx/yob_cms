<?php

namespace MetodikaTI\Providers;

use MetodikaTI\Library\Pastora;
use MetodikaTI\Library\URI;
use MetodikaTI\SystemModule;
use Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SystemLayoutProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        //Breadcums
        View::composer('back.layout.dashboard', function ($view) {

            $html = "";
            $current_module = null;
            $parent_of_urrent_module = null;

            $current_route = Route::current()->uri;

            //Verificamos si esta dentro de un catalogo
            $catalog = "";
            if (\strpos($current_route, '/create') !== false) {
                $catalog = 'Alta';
                $current_route = str_replace("/create", "", $current_route);
            }else if (\strpos($current_route, '/edit') !== false) {
                $catalog = 'Edición';
                $current_route = str_replace("/edit", "", $current_route);
            }

            $current_route = str_replace("/{id}", "", $current_route);

            if($current_route == "cms/dashboard"){
                $current_route = "/";
            }else{
                $current_route = str_replace("cms/dashboard/", "", $current_route);
            }

            $current_module = SystemModule::where("url", $current_route)->first();

            if($current_module != null) {

                if ($current_module->parent != 0) {
                    $parent_of_urrent_module = SystemModule::find($current_module->parent);
                }


                //Armamos el breadcum
                if($current_module != null && $parent_of_urrent_module != null && $catalog != ""){
                    $html .= '<ol class="breadcrumb">';
                    $html .= '    <li class="breadcrumb-item"><a>' . $parent_of_urrent_module->name . '</a></li>';
                    $html .= '    <li class="breadcrumb-item">' . $current_module->name . '</li>';
                    $html .= '    <li class="breadcrumb-item active">' . $catalog . '</li>';
                    $html .= '</ol>';
                } else if($current_module != null && $parent_of_urrent_module == null && $catalog != ""){
                    $html .= '<ol class="breadcrumb">';
                    $html .= '    <li class="breadcrumb-item">' . $current_module->name . '</li>';
                    $html .= '    <li class="breadcrumb-item active">' . $catalog . '</li>';
                    $html .= '</ol>';
                } else if ($current_module != null && $parent_of_urrent_module != null) {
                    $html .= '<ol class="breadcrumb">';
                    $html .= '    <li class="breadcrumb-item"><a>' . $parent_of_urrent_module->name . '</a></li>';
                    $html .= '    <li class="breadcrumb-item active">' . $current_module->name . '</li>';
                    $html .= '</ol>';
                } else if ($current_module != null && $parent_of_urrent_module == null) {
                    $html .= '<ol class="breadcrumb">';
                    $html .= '    <li class="breadcrumb-item active">' . $current_module->name . '</li>';
                    $html .= '</ol>';
                }

            }else{
                $html = "";
            }

            $view->with('breadcums',$html);
        });


        //Permisos
        View::composer('back.layout.dashboard', function ($view) {

            $permitions = URI::checkPermitions();

            $view->with('permitions',$permitions);
        });


    }





    public function register()
    {
        //
    }
}
