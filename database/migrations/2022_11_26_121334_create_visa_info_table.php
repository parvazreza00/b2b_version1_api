<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('visaId', 100);
            $table->string('country', 100);
            $table->string('visaType', 100);
            $table->string('visaCategory', 100);
            $table->string('entryType', 100);
            $table->string('duration', 100);
            $table->string('maximumStay', 100);
            $table->string('processingTime', 100);
            $table->string('interview', 100);
            $table->string('location', 100);
            $table->integer('cost');
            $table->integer('embassyFee');
            $table->integer('agentFee');
            $table->integer('agencyFee');
            $table->integer('FFIServiceCharge');
            $table->integer('total');
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
        Schema::dropIfExists('visa_info');
    }
}
