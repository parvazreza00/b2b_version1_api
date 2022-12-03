<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartialpaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partialpayment', function (Blueprint $table) {
            $table->integer('id');
            $table->string('agentId', 100);
            $table->string('bookingId', 100);
            $table->string('stuffId', 100);
            $table->string('ticketId', 100);
            $table->string('status', 100);
            $table->string('action', 100);
            $table->string('travelDate', 100);
            $table->integer('totalAmount');
            $table->integer('paidAmount');
            $table->integer('dueAmount');
            $table->string('dueDate', 100);
            $table->string('settleOn', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partialpayment');
    }
}
