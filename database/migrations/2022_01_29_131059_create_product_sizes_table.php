<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->unsignedInteger('size_id');
            $table->unsignedInteger('product_id');
            $table->integer('product_size_quantily');
            $table->primary(['size_id', 'product_id']);
            $table->foreign('size_id','fk_sizes_productSizes')
                ->references('size_id')->on('sizes')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id','fk_products_productSizes')
                ->references('product_id')->on('products')
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
        Schema::dropIfExists('product_sizes');
    }
}
