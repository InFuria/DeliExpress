<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('lat');
            $table->string('lgn');
            $table->string('patent');
            $table->string('identity_number');
            $table->date('birth');
            $table->boolean('available');
            $table->boolean('enabled');
            $table->timestamps();
        });

        Schema::create('delivery_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->bigInteger('delivery_id')->unsigned();
            $table->foreign('delivery_id')->references('id')->on('delivery_detail')->onUpdate('cascade');
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
        Schema::dropIfExists('delivery_user');
        Schema::dropIfExists('delivery_detail');
    }
}
