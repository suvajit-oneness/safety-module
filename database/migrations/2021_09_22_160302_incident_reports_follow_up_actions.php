<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentReportsFollowUpActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('incident_reports_follow_up_actions', function (Blueprint $t) {
            $t->bigIncrements('id');

            $t->unsignedBigInteger('incident_report_id');
            $t->string('sl_no')->nullable();
            $t->longText('description')->nullable();
            $t->string('pic')->nullable();
            $t->string('department')->nullable();
            $t->string('target_date')->nullable();
            $t->string('completed_date')->nullable();
            $t->string('evidence_uploaded')->nullable();
            $t->string('cost')->nullable();
            $t->longText('comments')->nullable();

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
        Schema::drop('incident_reports_follow_up_actions');
    }
}
