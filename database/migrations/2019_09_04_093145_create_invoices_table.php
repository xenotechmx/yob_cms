<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('invoices', function (Blueprint $table) {
        //     $table->increments('id');

        //     $table->integer("packages_buyed_by_users_id");
        //     $table->bigInteger("responseCode");
        //     $table->text("responseDescription");
        //     $table->text("serverTransactionId");
        //     $table->timestamp("requestDate");
        //     $table->timestamp("responseDate");
        //     $table->bigInteger("executionTime");
        //     $table->longText("signedXml");
        //     $table->text("uuid");

        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
