<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('refundId', 100);
            $table->string('agentId', 100);
            $table->string('bookingId', 100);
            $table->string('ticketId', 100);
            $table->string('passengerDetails', 1000);
            $table->integer('ticketCost');
            $table->integer('penaltyAmount');
            $table->integer('amountRefunded');
            $table->integer('servicefee');
            $table->string('status', 100);
            $table->string('requestedBy', 100);
            $table->string('requestedAt', 100);
            $table->string('actionBy', 100);
            $table->string('actionAt', 100);
            $table->string('remarks', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refund');
    }
}
