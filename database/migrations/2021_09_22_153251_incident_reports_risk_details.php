<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentReportsRiskDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('incident_reports_risk_details', function (Blueprint $t) {
            $t->bigIncrements('id');

            $t->unsignedBigInteger('incident_report_id');
            $t->foreign('incident_report_id')->references('id')->on('incident_report')->onDelete('cascade');

            $t->string('risk')->nullable();
            $t->string('severity')->nullable();
            $t->string('likelihood')->nullable();
            $t->string('result')->nullable();
            $t->string('name_of_person')->nullable();
            $t->string('type_of_injury')->nullable();
            $t->string('associated_cost_usd')->nullable();
            $t->string('associated_cost_loca')->nullable();
            $t->string('type_of_pollution')->nullable();
            $t->string('quantity_of_pollutant')->nullable();
            $t->string('contained_spill')->nullable();
            $t->string('total_spilled_quantity')->nullable();
            $t->string('spilled_in_water')->nullable();
            $t->string('spilled_ashore')->nullable();
            $t->string('vessel')->nullable();
            $t->string('cargo')->nullable();
            $t->string('third_party')->nullable();
            $t->longText('damage_description')->nullable();
            $t->string('off_hire')->nullable();
            $t->longText('description')->nullable();
            $t->string('type')->nullable();

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
        Schema::drop('incident_reports_risk_details');
    }
}
