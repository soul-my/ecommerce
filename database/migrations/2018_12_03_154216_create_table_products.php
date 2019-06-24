<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('title');
            $table->text('description');
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('quantity');
            $table->integer('quantity_sold')->default(0);
            $table->integer('status')->default(0)->comment('0 - inactive, 1 - active');
            $table->integer('allow_buy')->default(0)->comment('allow user to buy even if the item is out of stocks');
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
        Schema::dropIfExists('products');
    }
}
