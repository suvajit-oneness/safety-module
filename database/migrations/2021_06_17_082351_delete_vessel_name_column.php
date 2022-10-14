<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteVesselNameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop vessel_name column
        if (Schema::hasColumn('risk_assessment_vessel_infos', 'hazard_title')){

            Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {

                $table->dropColumn('vessel_name');

            });

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
