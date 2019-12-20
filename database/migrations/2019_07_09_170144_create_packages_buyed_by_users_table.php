<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesBuyedByUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages_buyed_by_users', function (Blueprint $table) {
            $table->increments('id');

            $table->integer("app_user_id");
            $table->integer("package_id");
            $table->integer("original_duration_plan_in_days");
            $table->integer("original_total_jobs_to_post");
            $table->integer("original_total_profiles_to_view");
            $table->integer("original_duration_in_days");
            $table->integer("original_destacable");
            $table->integer("original_price");
            $table->integer("count_total_jobs_to_post");
            $table->integer("count_total_profiles_to_view");
            $table->integer("count_destacable");
            $table->dateTime("package_disbaled_at");

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
        Schema::dropIfExists('packages_buyed_by_users');
    }
}
