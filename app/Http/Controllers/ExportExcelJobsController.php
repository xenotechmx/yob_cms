<?php

namespace MetodikaTI\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use MetodikaTI\Imports\UsersImport;

class ExportExcelJobsController extends Controller
{

    public function export_jobs(Request $request)
    {


        \Excel::import(new UsersImport(), 'empleos_exportar.xlsx');


    }

}
