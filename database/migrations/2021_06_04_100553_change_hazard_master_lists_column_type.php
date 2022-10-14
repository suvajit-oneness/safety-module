<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeHazardMasterListsColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('hazard_master_lists', function ($table) {
            $table->string('control')->change();
        });
        
        if (Schema::hasColumn('hazard_master_lists', 'nett_risk_r')){

            Schema::table('hazard_master_lists', function (Blueprint $table) {

                $table->dropColumn('nett_risk_r');

            });

        }
        if (Schema::hasColumn('hazard_master_lists', 'hazard_title')){

            Schema::table('hazard_master_lists', function (Blueprint $table) {

                $table->dropColumn('hazard_title');

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
