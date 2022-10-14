<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByB18AndVesselInfoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {
            $table->integer('created_by')->unsigned()->nullable();
        });
        Schema::table('form_b18', function (Blueprint $table) {
            $table->integer('created_by')->unsigned()->nullable();
        });
        /*Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('form_b18', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('form_b18', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
}
