<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBussinesInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bussines_informations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer("app_user_id");
            $table->text("type");
            $table->text("moral_razon_social");
            $table->text("moral_commercial_denomination");
            $table->text("moral_responsable_name");
            $table->text("moral_email");
            $table->text("moral_phone");
            $table->text("fisica_name");
            $table->text("fisica_father_last_name");
            $table->text("fisica_mother_last_name");
            $table->text("fisica_email");
            $table->text("fisica_phone");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bussines_informations');
    }
}
