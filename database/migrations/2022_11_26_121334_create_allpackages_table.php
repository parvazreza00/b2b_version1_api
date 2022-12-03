<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllpackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allpackages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('pkId', 100);
            $table->string('titleEN', 20);
            $table->string('titleBN', 20);
            $table->string('album', 100);
            $table->string('coverimage', 250);
            $table->string('longTitleEN', 100);
            $table->string('longTitleBN', 100);
            $table->string('locationEN', 250);
            $table->string('locationBN', 100);
            $table->string('shortDescriptionEN', 250);
            $table->string('shortDescriptionBN', 250);
            $table->string('startDateEN', 100);
            $table->string('startDateBN', 100);
            $table->string('endDateEN', 100);
            $table->string('endDateBN', 100);
            $table->string('durationEN', 100);
            $table->string('durationBN', 100);
            $table->integer('price');
            $table->string('tripTheme', 100);
            $table->string('triptype', 100);
            $table->string('tripplan', 100);
            $table->string('scheduledetailsEN', 100);
            $table->string('scheduledetailsBN', 100);
            $table->longText('inclusionEN');
            $table->longText('inclusionBN');
            $table->longText('exclusionEN');
            $table->longText('exclusionBN');
            $table->string('placevisitEN', 100);
            $table->string('placevisitBN', 100);
            $table->mediumText('detailsEN');
            $table->mediumText('detailsBN');
            $table->longText('bookingpolicyEN');
            $table->longText('bookingpolicyBN');
            $table->longText('refundpolicyEN');
            $table->longText('refundpolicyBN');
            $table->longText('termsEN');
            $table->longText('termsBN');
            $table->mediumText('additionalEN');
            $table->mediumText('additionalBN');
            $table->mediumText('traveltipsEN');
            $table->mediumText('traveltipsBN');
            $table->string('slider1', 250);
            $table->string('slider2', 250);
            $table->string('slider3', 250);
            $table->string('slider4', 250);
            $table->string('slider5', 250);
            $table->string('slider6', 250);
            $table->string('link', 1000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allpackages');
    }
}
