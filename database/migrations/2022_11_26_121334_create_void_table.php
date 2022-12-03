<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('void', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('bookingId', 100);
            $table->string('voidId', 100);
            $table->string('ticketId', 100);
            $table->string('agentId', 100);
            $table->string('passengerDetails', 100);
            $table->string('refundAmount', 100);
            $table->string('status', 100);
            $table->string('reason', 100);
            $table->string('requestedBy', 100);
            $table->string('actionBy', 100);
            $table->string('requestedAt', 100);
            $table->string('actionAt', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('void');
    }
}
