<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentReportsImmediateCauses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('incident_reports_immediate_causes', function (Blueprint $t) {
            $t->bigIncrements('id');

            $t->unsignedBigInteger('incident_report_id');
            $t->foreign('incident_report_id')->references('id')->on('incident_report')->onDelete('cascade');
            
            $t->string('primary')->nullable();
            $t->string('secondary')->nullable();
            $t->string('tertiary')->nullable();

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
        Schema::drop('incident_reports_immediate_causes');
    }
}
