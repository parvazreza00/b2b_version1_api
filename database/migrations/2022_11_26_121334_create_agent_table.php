<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('agentId', 100);
            $table->string('name', 30);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->string('phone', 100);
            $table->string('joinAt', 100);
            $table->string('status', 100);
            $table->string('isActive', 10);
            $table->string('company', 1000);
            $table->string('companyadd', 500);
            $table->string('area', 100);
            $table->string('companyImage', 500);
            $table->integer('logoPermission');
            $table->string('markup', 10);
            $table->integer('bonus');
            $table->integer('credit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent');
    }
}
