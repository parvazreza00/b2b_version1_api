<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('country', 100);
            $table->string('visatype', 100);
            $table->longText('visaDetailsEN');
            $table->longText('visaDetailsBN');
            $table->string('pdfEN', 250);
            $table->string('pdfBN', 250);
            $table->string('uploadedAt', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visa');
    }
}
