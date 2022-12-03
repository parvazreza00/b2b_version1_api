<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control', function (Blueprint $table) {
            $table->integer('id', true);
            $table->boolean('active');
            $table->boolean('sabre');
            $table->boolean('galileo');
            $table->boolean('flyhub');
            $table->integer('amadeus');
            $table->integer('priority1');
            $table->integer('priority2');
            $table->integer('priority3');
            $table->integer('gdsPrice');
            $table->integer('farePrice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control');
    }
}
