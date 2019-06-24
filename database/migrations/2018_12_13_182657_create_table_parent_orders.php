<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableParentOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('order_id', 500);
            $table->string('txn', 500)->nullable();
            $table->double('total_amount')->nullable();
            $table->integer('status')->comment('0 - shipping , 1 - success, 2 - cancelled order')->default(0);
            $table->integer('payment_status')->comment('0 - unpaid, 1 - successful, 2 - refunded')->default(0);
            $table->string('tracking', 500)->nullable();
            $table->string('remark', 500)->nullable();
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
        Schema::dropIfExists('parent_orders');
    }
}
