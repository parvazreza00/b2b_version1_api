<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticketed', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('bookingId', 100);
            $table->string('ticketId', 100);
            $table->string('airlinesPnr', 100);
            $table->string('ticketno', 100);
            $table->string('passengerName', 100);
            $table->string('passportno', 100);
            $table->string('pType', 100);
            $table->string('gender', 100);
            $table->string('ticketedAt', 100);
            $table->string('ticketedBy', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticketed');
    }
}
