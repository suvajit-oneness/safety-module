<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentReportsCrewInjury extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('incident_reports_crew_injury', function (Blueprint $t) {
            $t->bigIncrements('id');

            $t->unsignedBigInteger('incident_report_id');
            $t->string('fatality')->nullable();
            $t->string('lost_workday_case')->nullable();
            $t->string('restricted_work_case')->nullable();
            $t->string('medical_treatment_case')->nullable();
            $t->string('lost_time_injuries')->nullable();
            $t->string('first_aid_case')->nullable();

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
        Schema::drop('incident_reports_crew_injury');
    }
}
