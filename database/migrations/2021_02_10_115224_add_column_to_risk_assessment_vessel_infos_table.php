<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToRiskAssessmentVesselInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {
            $table->integer('ref')->nullable();
            //$table->integer('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {
            $table->dropColumn('ref');
            //$table->dropColumn('created_by');
        });
    }
}
