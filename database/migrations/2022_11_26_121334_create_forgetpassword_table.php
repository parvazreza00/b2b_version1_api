<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForgetpasswordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forgetpassword', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('agentId', 100);
            $table->string('email', 100);
            $table->string('link', 100);
            $table->integer('isClick');
            $table->string('expire', 100);
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
        Schema::dropIfExists('forgetpassword');
    }
}
