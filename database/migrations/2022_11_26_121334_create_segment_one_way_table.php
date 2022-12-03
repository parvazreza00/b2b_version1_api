<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegmentOneWayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segment_one_way', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('system', 100);
            $table->string('pnr', 30);
            $table->integer('segment');
            $table->string('departure1', 100);
            $table->string('departure2', 100);
            $table->string('departure3', 100);
            $table->string('departure4', 100);
            $table->string('arrival1', 100);
            $table->string('arrival2', 100);
            $table->string('arrival3', 100);
            $table->string('arrival4', 100);
            $table->string('departureTime1', 100);
            $table->string('departureTime2', 100);
            $table->string('departureTime3', 100);
            $table->string('departureTime4', 100);
            $table->string('arrivalTime1', 100);
            $table->string('arrivalTime2', 100);
            $table->string('arrivalTime3', 100);
            $table->string('arrivalTime4', 100);
            $table->string('flightDuration1', 100);
            $table->string('flightDuration2', 100);
            $table->string('flightDuration3', 100);
            $table->string('flightDuration4', 100);
            $table->integer('transit1');
            $table->integer('transit2');
            $table->integer('transit3');
            $table->string('marketingCareer1', 100);
            $table->string('marketingCareer2', 100);
            $table->string('marketingCareer3', 100);
            $table->string('marketingCareer4', 100);
            $table->string('marketingCareerName1', 100);
            $table->string('marketingCareerName2', 100);
            $table->string('marketingCareerName3', 100);
            $table->string('marketingCareerName4', 100);
            $table->string('marketingFlight1', 100);
            $table->string('marketingFlight2', 100);
            $table->string('marketingFlight3', 100);
            $table->string('marketingFlight4', 100);
            $table->string('operatingCareer1', 100);
            $table->string('operatingCareer2', 100);
            $table->string('operatingCareer3', 100);
            $table->string('operatingCareer4', 100);
            $table->string('operatingFlight1', 100);
            $table->string('operatingFlight2', 100);
            $table->string('operatingFlight3', 100);
            $table->string('operatingFlight4', 100);
            $table->string('departureAirport1', 100);
            $table->string('departureAirport2', 100);
            $table->string('departureAirport3', 100);
            $table->string('departureAirport4', 100);
            $table->string('arrivalAirport1', 100);
            $table->string('arrivalAirport2', 100);
            $table->string('arrivalAirport3', 100);
            $table->string('arrivalAirport4', 100);
            $table->string('departureLocation1', 100);
            $table->string('departureLocation2', 100);
            $table->string('departureLocation3', 100);
            $table->string('departureLocation4', 100);
            $table->string('arrivalLocation1', 100);
            $table->string('arrivalLocation2', 100);
            $table->string('arrivalLocation3', 100);
            $table->string('arrivalLocation4', 100);
            $table->string('bookingcode1', 11);
            $table->string('bookingcode2', 11);
            $table->string('bookingcode3', 11);
            $table->string('bookingcode4', 11);
            $table->integer('departureTerminal1');
            $table->integer('departureTerminal2');
            $table->integer('departureTerminal3');
            $table->integer('departureTerminal4');
            $table->integer('arrivalTerminal1');
            $table->integer('arrivalTerminal2');
            $table->integer('arrivalTerminal3');
            $table->integer('arrivalTerminal4');
            $table->string('adultBag', 30);
            $table->string('childBag', 30);
            $table->string('infantBag', 30);
            $table->string('resultId');
            $table->string('searchId', 250);
            $table->string('createdAt', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('segment_one_way');
    }
}
