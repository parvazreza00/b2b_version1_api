<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentFailedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_failed', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 30);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->string('phone', 100);
            $table->string('joinAt', 100);
            $table->string('status', 100);
            $table->string('company', 1000);
            $table->string('companyadd', 500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_failed');
    }
}
