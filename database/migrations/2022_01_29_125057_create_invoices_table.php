<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('invoice_id');
            $table->string('invoice_customer_name',100);
            $table->string('invoice_customer_email',255);
            $table->string('invoice_customer_tels',20);
            $table->string('invoice_customer_province',100);
            $table->string('invoice_customer_district',100);
            $table->string('invoice_customer_ward',100);
            $table->string('invoice_customer_address',100);
            $table->integer('invoice_total');
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
        Schema::dropIfExists('invoices');
    }
}
