<?php

namespace MetodikaTI\Imports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;
use MetodikaTI\Category;
use MetodikaTI\Job;
use MetodikaTI\SchoolGrade;
use MetodikaTI\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $error = false;
        $error_message = "";

        $id_del_empleador = $row[0];
        $titulo_de_la_vacante = $row[1];
        $categoria = $row[2];
        $descripcion = $row[3];
        $edad = $row[4];
        $genero = $row[5];
        $escolaridad = $row[6];
        $idiomas = $row[7];
        $estado = $row[8];
        $municipio = $row[9];
        $colonia = $row[10];
        $inidicaciones = $row[11];
        $vacante_privada = $row[12];


        //Validamos los campos
        if ($titulo_de_la_vacante == "") {
            $error = true;
            $error_message = "Titulo de la vacante vacio";
        }

        if ($categoria == "") {
            $error = true;
            $error_message = "Categoria vacio";
        }

        if ($descripcion == "") {
            $error = true;
            $error_message = "Descripcion vacio";
        }

        if ($edad == "") {
            $error = true;
            $error_message = "Edad vacio";
        }

        if ($escolaridad == "") {
            $error = true;
            $error_message = "Escolaridad vacio";
        }

        if ($idiomas == "") {
            $error = true;
            $error_message = "Idiomas vacio";
        }

        if ($estado == "") {
            $error = true;
            $error_message = "Estado vacio";
        }

        if ($municipio == "") {
            $error = true;
            $error_message = "Municipio vacio";
        }

        if ($colonia == "") {
            $error = true;
            $error_message = "Colonia vacio";
        }


        $edad_aux = trim($edad);
        $edad_aux = strtoupper($edad_aux);
        $edad_aux = str_replace("DE", "", $edad_aux);
        $edad_aux = str_replace("AÑOS", "", $edad_aux);
        $edad_aux = explode("A", $edad_aux);

        if (count($edad_aux) != 2) {
            $error = true;
            $error_message = "Edad con formato incorrecto, formato debe de ser DE 0 A 0 AÑOS";
        }

        $genero_aux = "";
        if (strtolower($genero) == "indistinto") {
            $genero_aux = "Indistinto";
        } else if (strtolower($genero) == "masculino") {
            $genero_aux = "Masculino";
        } else if (strtolower($genero) == "femenino") {
            $genero_aux = "Femenino";
        } else {
            $genero_aux = "Indistinto";
        }
        
        if ($error) {

            echo
                $id_del_empleador . "-abs-" .
                $titulo_de_la_vacante . "-abs-" .
                $categoria . "-abs-" .
                $descripcion . "-abs-" .
                $edad . "-abs-" .
                $genero . "-abs-" .
                $escolaridad . "-abs-" .
                $idiomas . "-abs-" .
                $estado . "-abs-" .
                $municipio . "-abs-" .
                $colonia . "-abs-" .
                $inidicaciones . "-abs-" .
                $vacante_privada . "-abs-" .
                $error_message . "<br>";

        } else {

            $category_id = Category::where("category", "LIKE", $categoria);
            if ($category_id->count() > 0) {
                $category_id = $category_id->first();
            } else {
                $category_id = new Category();
                $category_id->category = ucfirst($categoria);
                $category_id->save();
            }


            $school_id = SchoolGrade::where("school_grade", "LIKE", $escolaridad);
            if ($school_id->count() > 0) {
                $school_id = $school_id->first();
            } else {
                $school_id = new SchoolGrade();
                $school_id->school_grade = ucfirst($escolaridad);
                $school_id->save();
            }

            $disabled_at = Carbon::now()->addMonth(1);
            $created_at = Carbon::now();

            //Insertamos la vacante;
            $job = new Job();
            $job->packages_buyed_by_users_id = 0;
            $job->status = "publish";
            $job->app_user_employe_id = 198;
            $job->job_title = $titulo_de_la_vacante;
            $job->category_id = $category_id->id;
            $job->description = $descripcion;
            $job->minimun_age = trim($edad_aux[0]);
            $job->maximum_age = trim($edad_aux[1]);
            $job->sex = $genero_aux;
            $job->benefist = "";
            $job->school_grade_id = $school_id->id;
            $job->experience = "";
            $job->languages_id = 1;
            $job->functions = "";
            $job->street = "";
            $job->number = "";
            $job->postal_code = "";
            $job->colony = $colonia;
            $job->municipaly = $municipio;
            $job->state = $estado;
            $job->how_to_go = $inidicaciones;
            $job->is_private = ($vacante_privada != "") ? 1 : 0;
            $job->highlight_job = 0;
            $job->publish = 1;
            $job->unpublish_reason = "";
            $job->disbaled_at = $disabled_at->format("Y-m-d H:i:s");
            $job->created_at = $created_at->format("Y-m-d H:i:s");
            $job->updated_at = $created_at->format("Y-m-d H:i:s");
            $job->save();

        }


    }


    public function startRow(): int
    {
        return 2;
    }

}
