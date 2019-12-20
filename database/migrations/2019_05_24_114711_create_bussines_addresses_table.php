<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBussinesAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bussines_addresses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer("app_user_id");
            $table->text("address");
            $table->text("interior_exterior_number");
            $table->text("postal_code");
            $table->text("country");
            $table->text("state");
            $table->text("municipaly");
            $table->text("colony");

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
        Schema::dropIfExists('bussines_addresses');
    }
}
