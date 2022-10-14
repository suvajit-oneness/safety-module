<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentReportsWeather extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('incident_reports_weather', function (Blueprint $t) {
            $t->bigIncrements('id');

            $t->unsignedBigInteger('incident_report_id');
            $t->string('wind_force')->nullable();
            $t->string('wind_direction')->nullable();
            $t->string('sea_wave')->nullable();
            $t->string('sea_direction')->nullable();
            $t->string('swell_height')->nullable();
            $t->string('swell_length')->nullable();
            $t->string('swell_direction')->nullable();
            $t->string('sky')->nullable();
            $t->string('visibility')->nullable();
            $t->string('rolling')->nullable();
            $t->string('pitching')->nullable();
            $t->string('illumination')->nullable();
            
            $t->foreign('incident_report_id')->references('id')->on('incident_report')->onDelete('cascade');
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('incident_reports_weather');
    }
}
