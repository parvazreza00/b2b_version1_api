<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_history', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('searchId', 100);
            $table->string('agentId', 100);
            $table->string('company', 100);
            $table->string('phone', 20);
            $table->string('searchBy', 100);
            $table->string('searchtype', 100);
            $table->string('DepFrom', 50);
            $table->string('DepAirport', 100);
            $table->string('ArrTo', 50);
            $table->string('ArrAirport', 100);
            $table->string('class', 100);
            $table->string('searchTime', 100);
            $table->string('depTime', 100);
            $table->integer('adult');
            $table->integer('child');
            $table->integer('infant');
            $table->string('returnTime', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_history');
    }
}
