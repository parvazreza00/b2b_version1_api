<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('bookingId', 25);
            $table->string('ticketId', 25);
            $table->string('voidId', 25);
            $table->string('refundId', 50);
            $table->string('reissueId', 50);
            $table->string('agentId', 100);
            $table->string('staffId', 100);
            $table->string('email', 100);
            $table->string('phone', 15);
            $table->string('name', 100);
            $table->string('refundable', 10);
            $table->string('pnr', 100);
            $table->string('airlinesPNR', 30);
            $table->string('tripType', 100);
            $table->string('journeyType', 100);
            $table->integer('pax');
            $table->string('adultBag', 20);
            $table->string('childBag', 20);
            $table->string('infantBag', 20);
            $table->integer('adultCount');
            $table->integer('childCount');
            $table->integer('infantCount');
            $table->integer('netCost');
            $table->integer('adultCostBase');
            $table->integer('childCostBase');
            $table->integer('infantCostBase');
            $table->integer('adultCostTax');
            $table->integer('childCostTax');
            $table->integer('infantCostTax');
            $table->integer('grossCost');
            $table->integer('baseFare');
            $table->integer('Tax');
            $table->string('deptFrom', 100);
            $table->string('airlines', 100);
            $table->string('arriveTo', 100);
            $table->string('gds', 100);
            $table->string('status', 100);
            $table->string('coupon', 30);
            $table->string('bonus', 10);
            $table->string('travelDate', 100);
            $table->string('bookedAt', 100);
            $table->string('timeLimit', 19);
            $table->string('searchId', 500);
            $table->string('resultId', 500);
            $table->string('bookedBy', 100);
            $table->string('lastUpdated', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking');
    }
}
