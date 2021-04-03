<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('municipalities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('zone', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('municipality_id')->unsigned();
            $table->foreign('municipality_id')->references('id')->on('municipalities')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->string('long_name');
            $table->string('short_name');
            $table->string('description');
            $table->string('direction');
            $table->string('phone');
            $table->string('mobile');
            $table->string('email');
            $table->string('logo');
            $table->string('cover');
            $table->double('rate_avg', 10, 2);
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('store_categories')->onUpdate('cascade');
            $table->bigInteger('department_id');
            $table->bigInteger('municipality_id');
            $table->bigInteger('zone_id');
            $table->timestamps();
        });

        Schema::create('category_store', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('store_categories')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade');
            $table->bigInteger('client_id');
            $table->integer('value');
            $table->string('comment');
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
        Schema::dropIfExists('category_store');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('zone');
        Schema::dropIfExists('municipalities');
        Schema::dropIfExists('departments');
    }
}
