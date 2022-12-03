<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_check_list', function (Blueprint $table) {
            $table->string('country', 100);
            $table->string('category', 100);
            $table->string('visatype', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visa_check_list', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('category');
            $table->dropColumn('visatype');
        });
    }
};
