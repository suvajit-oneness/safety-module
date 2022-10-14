<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentReportAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('incident_report', function (Blueprint $t) {

            // $t->string('breadth')->nullable();
            $t->string('created_by_name')->nullable();
            $t->string('created_by_rank')->nullable();
           
        });
        Schema::table('incident_reports_risk_details', function (Blueprint $t) {

            // $t->string('breadth')->nullable();
            $t->string('currency_code')->nullable();
            
           
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
        Schema::table('incident_report', function (Blueprint $t) {

            // $t->dropColumn('breadth');
            $t->dropColumn('created_by_name');
            $t->dropColumn('created_by_rank');
           
        });
        Schema::table('incident_reports_risk_details', function (Blueprint $t) {

            // $t->dropColumn('breadth');
            $t->dropColumn('currency_code');
            
           
        });
    }
}
