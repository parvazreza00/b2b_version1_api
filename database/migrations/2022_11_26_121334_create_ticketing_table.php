<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticketing', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('ticketId', 100);
            $table->string('agentId', 100);
            $table->string('bookingId', 100);
            $table->string('staffId', 100);
            $table->string('route', 100);
            $table->integer('cost');
            $table->string('tripType', 100);
            $table->string('airlines', 100);
            $table->string('status', 100);
            $table->string('remarks', 500);
            $table->string('bonus', 10);
            $table->string('created', 100);
            $table->string('actionBy', 100);
            $table->string('actionAt', 100);
            $table->string('issueRequestBy', 100);
            $table->string('passportCopy', 100);
            $table->string('visaCopy', 500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticketing');
    }
}
