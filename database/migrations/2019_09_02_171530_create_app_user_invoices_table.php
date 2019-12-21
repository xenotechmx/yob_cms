<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUserInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user_invoices', function (Blueprint $table) {
            $table->increments('id');

            $table->text("social_reason");
            $table->text("comercial_name");
            $table->text("rfc");
            $table->text("fiscal_address");
            $table->text("email_send_invoice");

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
        Schema::dropIfExists('app_user_invoices');
    }
}
