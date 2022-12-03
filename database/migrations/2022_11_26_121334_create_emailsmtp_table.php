<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsmtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emailsmtp', function (Blueprint $table) {
            $table->integer('id');
            $table->string('host', 100);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->string('emailTo', 100);
            $table->string('addCC1', 100);
            $table->string('addCC2', 100);
            $table->string('addCC3', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emailsmtp');
    }
}
