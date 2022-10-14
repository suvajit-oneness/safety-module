<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskAssessmentVesselInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_assessment_vessel_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vessel_id')->unsigned()->nullable();
            $table->integer('fleet_id')->unsigned()->nullable();
            $table->integer('dept_id')->unsigned()->nullable();
            $table->integer('loc_id')->unsigned()->nullable();
            $table->date('assess_date')->nullable();
            $table->string('activity_name')->nullable();
            $table->string('activity_type')->nullable();
            $table->string('activity_group')->nullable();
            $table->string('linkages')->nullable();
            $table->string('assessed_by')->nullable();
            $table->string('assess_rank')->nullable();
            $table->string('verified_by')->nullable();
            $table->string('verify_rank')->nullable();
            $table->date('review_date')->nullable();
            $table->string('reviewed_by')->nullable();
            $table->string('review_rank')->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
        });
        Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {
            
            $table->foreign('fleet_id')->references('id')->on('fleets')->onDelete('cascade');
            $table->foreign('vessel_id')->references('id')->on('vessels')->onDelete('cascade');
            $table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('loc_id')->references('id')->on('locations')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_assessment_vessel_infos');
    }
}
