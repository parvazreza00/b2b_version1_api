<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_request', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('agentId', 200);
            $table->string('staffId', 100);
            $table->string('depositId', 100);
            $table->string('sender');
            $table->string('reciever', 200);
            $table->string('paymentway', 100);
            $table->string('paymentmethod', 100);
            $table->string('transactionId', 100);
            $table->string('chequeIssueDate', 100);
            $table->string('ref', 100);
            $table->integer('amount');
            $table->string('attachment', 5000);
            $table->string('createdAt', 100);
            $table->string('depositBy', 100);
            $table->string('status', 100);
            $table->string('remarks', 500);
            $table->string('approvedBy', 100);
            $table->string('rejectBy', 100);
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
        Schema::dropIfExists('deposit_request');
    }
}
