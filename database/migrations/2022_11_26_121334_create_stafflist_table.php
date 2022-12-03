<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStafflistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stafflist', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('staffId', 100);
            $table->string('agentId', 100);
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->string('phone', 100);
            $table->string('designation', 100);
            $table->string('role', 100);
            $table->string('status', 100);
            $table->string('created', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stafflist');
    }
}
