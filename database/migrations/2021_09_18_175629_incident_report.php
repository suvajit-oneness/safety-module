<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('incident_report', function (Blueprint $t) {
            $t->bigIncrements('id');

            $t->string('vessel_name')->nullable();
            $t->string('report_no')->nullable();

            $t->unsignedBigInteger('created_by');

            $t->string('date_of_incident')->nullable();
            $t->string('date_report_created')->nullable();
            $t->string('voy_no')->nullable();

            $t->unsignedBigInteger('master');
            $t->unsignedBigInteger('chief_engineer');
            $t->string('charterer')->nullable();;
            $t->string('agent')->nullable();
            $t->unsignedBigInteger('chief_officer');
            $t->unsignedBigInteger('first_engineer');


            $t->string('confidential')->nullable();
            $t->string('media_involved')->nullable();
            $t->string('time_of_incident_lt')->nullable();
            $t->string('time_of_incident_gmt')->nullable();
            $t->string('crew_injury')->nullable();
            $t->string('other_personnel_injury')->nullable();
            $t->string('vessel_damage')->nullable();
            $t->string('cargo_damage')->nullable();
            $t->string('third_party_liability')->nullable();
            $t->string('environmental')->nullable();
            $t->string('commercial')->nullable();
            $t->string('lead_investigator')->nullable();
            $t->string('p_n_i_club_informed')->nullable();
            $t->string('h_n_m_informed')->nullable();
            $t->longText('type_of_loss_remarks')->nullable();
            $t->longText('incident_brief')->nullable();
            
            $t->string('risk_category')->nullable();
            $t->string('is_evalutated')->nullable();

            $t->foreign('created_by')->references('id')->on('crew_list')->onDelete('cascade');
            $t->foreign('master')->references('id')->on('crew_list')->onDelete('cascade');
            $t->foreign('chief_engineer')->references('id')->on('crew_list')->onDelete('cascade');
            $t->foreign('chief_officer')->references('id')->on('crew_list')->onDelete('cascade');
            $t->foreign('first_engineer')->references('id')->on('crew_list')->onDelete('cascade');

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
        Schema::drop('incident_report');
        
    }
}
