<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentReportsFiveWhy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('incident_reports_five_why', function (Blueprint $t) {
            $t->bigIncrements('id');

            $t->unsignedBigInteger('incident_report_id');
            $t->foreign('incident_report_id')->references('id')->on('incident_report')->onDelete('cascade');
            
            $t->string('incident')->nullable();
            $t->string('first_why')->nullable();
            $t->string('second_why')->nullable();
            $t->string('third_why')->nullable();
            $t->string('fourth_why')->nullable();
            $t->string('fifth_why')->nullable();
            $t->string('root_cause')->nullable();

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
        Schema::drop('incident_reports_five_why');
    }
}
