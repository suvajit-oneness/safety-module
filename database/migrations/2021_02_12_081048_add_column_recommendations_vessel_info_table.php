<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRecommendationsVesselInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {
            $table->longtext('recommendations')->nullable();
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
        Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {
            dropColumn('recommendations');
        });
    }
}
