<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegmentReturnWayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segment_return_way', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('system', 100);
            $table->string('segment', 100);
            $table->string('pnr', 30);
            $table->string('goTransit1', 100);
            $table->string('goTransit2', 100);
            $table->string('backTransit1', 100);
            $table->string('backTransit2', 100);
            $table->string('goMarketingCareer1', 100);
            $table->string('goMarketingCareer2', 100);
            $table->string('goMarketingCareer3', 100);
            $table->string('goMarketingCareerName1', 100);
            $table->string('goMarketingCareerName2', 100);
            $table->string('goMarketingCareerName3', 100);
            $table->string('goMarketingFlight1', 100);
            $table->string('goMarketingFlight2', 100);
            $table->string('goMarketingFlight3', 100);
            $table->string('goOperatingCareer1', 100);
            $table->string('goOperatingCareer2', 100);
            $table->string('goOperatingCareer3', 100);
            $table->string('goOperatingFlight1', 100);
            $table->string('goOperatingFlight2', 100);
            $table->string('goOperatingFlight3', 100);
            $table->string('goDeparture1', 100);
            $table->string('goDeparture2', 100);
            $table->string('goDeparture3', 100);
            $table->string('goArrival1', 100);
            $table->string('goArrival2', 100);
            $table->string('goArrival3', 100);
            $table->string('goDepartureAirport1', 100);
            $table->string('goDepartureAirport2', 100);
            $table->string('goDepartureAirport3', 100);
            $table->string('goArrivalAirport1', 100);
            $table->string('goArrivalAirport2', 100);
            $table->string('goArrivalAirport3', 100);
            $table->string('goDepartureLocation1', 100);
            $table->string('goDepartureLocation2', 100);
            $table->string('goDepartureLocation3', 100);
            $table->string('goArrivalLocation1', 100);
            $table->string('goArrivalLocation2', 100);
            $table->string('goArrivalLocation3', 100);
            $table->string('goDepartureTime1', 100);
            $table->string('goDepartureTime2', 100);
            $table->string('goDepartureTime3', 100);
            $table->string('goArrivalTime1', 100);
            $table->string('goArrivalTime2', 100);
            $table->string('goArrivalTime3', 100);
            $table->string('goFlightDuration1', 100);
            $table->string('goFlightDuration2', 100);
            $table->string('goFlightDuration3', 100);
            $table->string('goBookingCode1', 100);
            $table->string('goBookingCode2', 100);
            $table->string('goBookingCode3', 100);
            $table->integer('goDepTerminal1');
            $table->integer('goDepTerminal2');
            $table->integer('goDepTerminal3');
            $table->integer('goArrTerminal1');
            $table->integer('goArrTerminal2');
            $table->integer('goArrTerminal3');
            $table->string('backMarketingCareer1', 100);
            $table->string('backMarketingCareer2', 100);
            $table->string('backMarketingCareer3', 100);
            $table->string('backMarketingCareerName1', 100);
            $table->string('backMarketingCareerName2', 100);
            $table->string('backMarketingCareerName3', 100);
            $table->string('backMarketingFlight1', 100);
            $table->string('backMarketingFlight2', 100);
            $table->string('backMarketingFlight3', 100);
            $table->string('backOperatingCareer1', 100);
            $table->string('backOperatingCareer2', 100);
            $table->string('backOperatingCareer3', 100);
            $table->string('backOperatingFlight1', 100);
            $table->string('backOperatingFlight2', 100);
            $table->string('backOperatingFlight3', 100);
            $table->string('backDeparture1', 100);
            $table->string('backDeparture2', 100);
            $table->string('backDeparture3', 100);
            $table->string('backArrival1', 100);
            $table->string('backArrival2', 100);
            $table->string('backArrival3', 100);
            $table->string('backDepartureAirport1', 100);
            $table->string('backDepartureAirport2', 100);
            $table->string('backDepartureAirport3', 100);
            $table->string('backArrivalAirport1', 100);
            $table->string('backArrivalAirport2', 100);
            $table->string('backArrivalAirport3', 100);
            $table->string('backDepartureLocation1', 100);
            $table->string('backDepartureLocation2', 100);
            $table->string('backDepartureLocation3', 100);
            $table->string('backArrivalLocation1', 100);
            $table->string('backArrivalLocation2', 100);
            $table->string('backArrivalLocation3', 100);
            $table->string('backDepartureTime1', 100);
            $table->string('backDepartureTime2', 100);
            $table->string('backDepartureTime3', 100);
            $table->string('backArrivalTime1', 100);
            $table->string('backArrivalTime2', 100);
            $table->string('backArrivalTime3', 100);
            $table->string('backFlightDuration1', 100);
            $table->string('backFlightDuration2', 100);
            $table->string('backFlightDuration3', 100);
            $table->string('backBookingCode1', 100);
            $table->string('backBookingCode2', 100);
            $table->string('backBookingCode3', 100);
            $table->integer('backdepTerminal1');
            $table->integer('backdepTerminal2');
            $table->integer('backdepTerminal3');
            $table->integer('backArrTerminal1');
            $table->integer('backArrTerminal2');
            $table->integer('backArrTerminal3');
            $table->string('searchId', 100);
            $table->string('resultId', 100);
            $table->string('createdAt', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('segment_return_way');
    }
}
