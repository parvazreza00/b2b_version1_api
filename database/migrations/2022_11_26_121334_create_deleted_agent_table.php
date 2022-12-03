<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletedAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deleted_agent', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('agentId', 100);
            $table->string('name', 30);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->string('phone', 100);
            $table->string('joinAt', 100);
            $table->string('status', 100);
            $table->string('company', 1000);
            $table->string('companyadd', 500);
            $table->string('companyImage', 500);
            $table->integer('logoPermission');
            $table->string('markup', 10);
            $table->integer('bonus');
            $table->integer('credit');
            $table->string('actionBy', 100);
            $table->string('approvedBy', 100);
            $table->string('rejectBy', 100);
            $table->string('deactiveBy', 100);
            $table->string('creditedBy', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deleted_agent');
    }
}
