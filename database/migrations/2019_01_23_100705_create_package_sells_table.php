<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_sells', function (Blueprint $table) {
            $table->increments('id');

            $table->text("name");
            $table->integer("total_jobs_to_post");          // -1 ilimitado
            $table->integer("total_profiles_to_view");      // -1 ilimitado
            $table->integer("duration_in_days");            // -1 ilimitado
            $table->integer("destacable")->default(0);
            $table->double("price")->default(0);

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
        Schema::dropIfExists('package_sells');
    }
}
