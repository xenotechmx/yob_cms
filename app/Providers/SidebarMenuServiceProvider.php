<?php

namespace MetodikaTI\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use MetodikaTI\Library\URI;
use MetodikaTI\SystemModule;
use MetodikaTI\UserProfile;

class SidebarMenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('back.layout.dashboard', function ($view) {

            $module_permited_to_view = URI::getModulesPermitedToView();
            $parents = SystemModule::where('parent', 0)->whereIn("id", $module_permited_to_view)->get();
            $data = array('parents'=>$parents,);
            foreach ($parents as $kParent => $parent) {
                $children = SystemModule::where('parent', $parent->id)->whereIn("id", $module_permited_to_view)->orderBy('id')->get();
                $data[$parent->id]['children'] = $children;
            }

            $view->with('menuItems',$data);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
