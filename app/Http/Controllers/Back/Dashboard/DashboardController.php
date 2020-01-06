<?php

namespace MetodikaTI\Http\Controllers\Back\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MetodikaTI\AppUser;
use MetodikaTI\Http\Controllers\Controller;
use MetodikaTI\Job;

class DashboardController extends Controller
{

    public function index(){

        $total_jobs_published = Job::where("status", "publish")->count();
        $total_app_users = AppUser::where("type", "user")->count();
        $total_busines_users = AppUser::where("type", "employer")->count();

        $categories_job_count = DB::select(DB::raw("SELECT categories.category, count(categories.id) as total FROM categories JOIN jobs ON categories.id = jobs.category_id  GROUP BY categories.id LIMIT 5"));

        $last_users = AppUser::where("type", "user")->orderBy("created_at", "DESC")->limit(10)->get();
        $last_employers_users = AppUser::where("type", "employer")->orderBy("created_at", "DESC")->limit(10)->get();

        $jobs_apply_by_month = array();
        $current_year = date("Y");
        for ($i = 1; $i <= 12; $i++){

            $total_apply = DB::select(DB::raw("SELECT count(id) as total FROM job_user_applies WHERE YEAR(updated_at) = ".$current_year." AND MONTH(updated_at) = ".$i));

            $job_apply = array();
            $job_apply["Postulaciones"] = $total_apply[0]->total;
            $job_apply["period"] = $current_year."-".(($i < 10) ? "0".$i : $i);

            $jobs_apply_by_month[] = $job_apply;

        }

        return view("back.dashboard.dashboard", compact(["total_jobs_published", "total_app_users", "total_busines_users", "categories_job_count", "jobs_apply_by_month", "last_users", "last_employers_users"]));

    }

}
