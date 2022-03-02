<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id('invoice_details_id');
            $table->string('invoice_detail_size',50);
            $table->integer('invoice_detail_quantity');
            $table->integer('invoice_detail_price_sell');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('invoice_id');
            // $table->primary(['product_id', 'invoice_id']);
            $table->foreign('product_id','fk_products_invoiceDetails')
                ->references('product_id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('invoice_id','fk_invoices_invoiceDetails')
                ->references('invoice_id')->on('invoices')
                ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('invoice_details');
    }
}
