<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('paxId', 100);
            $table->string('agentId', 100);
            $table->string('bookingId', 100);
            $table->string('fName', 100);
            $table->string('lName', 100);
            $table->string('dob', 100);
            $table->string('type', 100);
            $table->string('passNation', 50);
            $table->string('passNo', 100);
            $table->string('passEx', 100);
            $table->string('phone', 15);
            $table->string('email', 100);
            $table->string('address', 200);
            $table->string('gender', 100);
            $table->string('passportCopy', 250);
            $table->string('visaCopy', 250);
            $table->string('created', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passengers');
    }
}
