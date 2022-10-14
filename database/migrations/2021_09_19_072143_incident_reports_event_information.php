<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentReportsEventInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('incident_reports_event_information', function (Blueprint $t) {
            $t->bigIncrements('id');

            $t->unsignedBigInteger('incident_report_id');
            $t->string('place_of_incident')->nullable();
            $t->string('place_of_incident_position')->nullable();
            $t->string('date_of_incident')->nullable();
            $t->string('time_of_incident_lt')->nullable();
            $t->string('time_of_incident_gmt')->nullable();
            $t->string('location_of_incident')->nullable();
            $t->string('operation')->nullable();
            $t->string('vessel_condition')->nullable();
            $t->string('cargo_type_and_quantity')->nullable();
            
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
        Schema::drop('incident_reports_event_information');
    }
}
