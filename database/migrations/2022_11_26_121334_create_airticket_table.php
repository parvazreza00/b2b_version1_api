<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirticketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airticket', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('invoiceId', 100);
            $table->string('agentId', 100);
            $table->string('bookingId', 100);
            $table->string('systemPnr', 100);
            $table->string('airlinesPnr', 100);
            $table->string('eticketNo', 100);
            $table->string('pasengerType', 100);
            $table->string('flightdate', 100);
            $table->string('addedTime', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airticket');
    }
}
