<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableVesselInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('hazard_master_lists', function($table)
        {
            $table->longtext('ref')->nullable()->change();
            $table->longtext('hazards')->nullable()->change();
            $table->longtext('threats')->nullable()->change();
            $table->longtext('top_event')->nullable()->change();
            $table->longtext('consequences')->nullable()->change();
            $table->longtext('control')->nullable()->change();
            $table->longtext('recover_measure')->nullable()->change();
            $table->longtext('reduction_measure')->nullable()->change();
            $table->longtext('remarks')->nullable()->change(); 
            $table->string('risk_p')->nullable()->change();
            $table->string('risk_e')->nullable()->change();
            $table->string('risk_a')->nullable()->change();
            $table->string('risk_r')->nullable()->change();

            $table->string('nett_risk_p')->nullable()->change();
            $table->string('nett_risk_e')->nullable()->change();
            $table->string('nett_risk_a')->nullable()->change();
            $table->string('nett_risk_r')->nullable()->change();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hazard_master_lists', function($table)
        {
            $table->longtext('ref')->nullable(false)->change();
            $table->longtext('hazards')->nullable(false)->change();
            $table->longtext('threats')->nullable(false)->change();
            $table->longtext('top_event')->nullable(false)->change();
            $table->longtext('consequences')->nullable(false)->change();
            $table->longtext('control')->nullable(false)->change();
            $table->longtext('recover_measure')->nullable(false)->change();
            $table->longtext('reduction_measure')->nullable(false)->change();
            $table->longtext('remarks')->nullable(false)->change(); 
            $table->string('risk_p')->nullable(false)->change();
            $table->string('risk_e')->nullable(false)->change();
            $table->string('risk_a')->nullable(false)->change();
            $table->string('risk_r')->nullable(false)->change();

            $table->string('nett_risk_p')->nullable(false)->change();
            $table->string('nett_risk_e')->nullable(false)->change();
            $table->string('nett_risk_a')->nullable(false)->change();
            $table->string('nett_risk_r')->nullable(false)->change();           
        });
        
        //
    }
}
