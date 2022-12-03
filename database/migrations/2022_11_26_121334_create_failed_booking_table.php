<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_booking', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('agentId', 100);
            $table->string('staffId', 100);
            $table->string('system', 100);
            $table->string('depfrom', 100);
            $table->string('arrto', 100);
            $table->string('route', 100);
            $table->string('airlines', 100);
            $table->string('tripType', 100);
            $table->string('depTime', 100);
            $table->string('arrTime', 30);
            $table->string('pax', 100);
            $table->string('adultcount', 100);
            $table->string('childcount', 100);
            $table->string('infantcount', 100);
            $table->string('netcost', 100);
            $table->string('flightnumber', 100);
            $table->string('cabinclass', 100);
            $table->string('SearchID', 100);
            $table->string('ResultID', 100);
            $table->string('createdAt', 100);
            $table->string('createdBy', 100);
            $table->string('companyname', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_booking');
    }
}
