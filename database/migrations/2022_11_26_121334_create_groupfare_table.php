<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupfareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupfare', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('groupId', 100);
            $table->integer('segment');
            $table->string('career', 10);
            $table->integer('total');
            $table->integer('BasePrice');
            $table->integer('Taxes');
            $table->integer('price');
            $table->string('departure1', 100);
            $table->string('departure2', 100);
            $table->string('departure3', 100);
            $table->string('depTime1', 100);
            $table->string('depTime2', 100);
            $table->string('depTime3', 100);
            $table->string('arrival1', 100);
            $table->string('arrival2', 10);
            $table->string('arrival3', 10);
            $table->string('arrTime1', 100);
            $table->string('arrTime2', 100);
            $table->string('arrTime3', 100);
            $table->integer('seat');
            $table->integer('bags');
            $table->integer('flightNum1');
            $table->integer('flightNum2');
            $table->integer('flightNum3');
            $table->integer('journeyTime');
            $table->integer('transit1');
            $table->integer('transit2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupfare');
    }
}
