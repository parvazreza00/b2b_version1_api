<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingothersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookingothers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('othersId', 100);
            $table->string('agentId', 100);
            $table->string('reference', 10);
            $table->integer('amount');
            $table->string('description', 500);
            $table->string('serviceType', 100);
            $table->string('attachment', 1000);
            $table->string('companyname', 100);
            $table->string('companyphone', 100);
            $table->string('createdBy', 100);
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
        Schema::dropIfExists('bookingothers');
    }
}
