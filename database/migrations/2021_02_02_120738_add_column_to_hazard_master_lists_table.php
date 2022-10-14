<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToHazardMasterListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hazard_master_lists', function (Blueprint $table) {
            $table->string('risk_p');
            $table->string('risk_e');
            $table->string('risk_a');
            $table->string('risk_r');

            $table->string('nett_risk_p');
            $table->string('nett_risk_e');
            $table->string('nett_risk_a');
            $table->string('nett_risk_r');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hazard_master_lists', function (Blueprint $table) {
            $table->dropColumn('risk_p');
            $table->dropColumn('risk_e');
            $table->dropColumn('risk_a');
            $table->dropColumn('risk_r');

            $table->dropColumn('nett_risk_p');
            $table->dropColumn('nett_risk_e');
            $table->dropColumn('nett_risk_a');
            $table->dropColumn('nett_risk_r');
        });
    }
}
