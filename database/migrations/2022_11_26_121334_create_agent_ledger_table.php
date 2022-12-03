<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentLedgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_ledger', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('agentId', 100);
            $table->string('staffId', 100);
            $table->integer('deposit');
            $table->integer('purchase');
            $table->integer('loan');
            $table->integer('returnMoney');
            $table->integer('void');
            $table->integer('refund');
            $table->integer('reissue');
            $table->integer('others');
            $table->integer('servicefee');
            $table->integer('lastAmount');
            $table->string('transactionId', 100);
            $table->string('details', 300);
            $table->string('reference', 100);
            $table->string('actionBy', 100);
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
        Schema::dropIfExists('agent_ledger');
    }
}
