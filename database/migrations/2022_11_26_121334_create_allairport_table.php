<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllairportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allairport', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 100);
            $table->string('name', 100);
            $table->string('city', 100);
            $table->string('country', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allairport');
    }
}
