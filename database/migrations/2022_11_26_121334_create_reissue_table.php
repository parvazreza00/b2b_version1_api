<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReissueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reissue', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('agentId', 100);
            $table->string('reissueId', 100);
            $table->string('bookingId', 100);
            $table->string('ticketId', 100);
            $table->string('passengerDetails', 100);
            $table->integer('charge');
            $table->integer('servicefee');
            $table->string('reissueDate', 100);
            $table->string('requestedBy', 100);
            $table->string('requestedAt', 100);
            $table->string('status', 100);
            $table->string('remarks', 250);
            $table->string('actionBy', 100);
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
        Schema::dropIfExists('reissue');
    }
}
