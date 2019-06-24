<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier');
            $table->integer('user_id')->nullable()->default(0)->comment('0 - guest, otherwise it belong to a member');
            $table->double('value')->nullable()->default(0);
            $table->integer('status')->comment('0 - abandon , 1 - currently use, 2 - successful checkout'); 
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
        Schema::dropIfExists('carts');
    }
}
