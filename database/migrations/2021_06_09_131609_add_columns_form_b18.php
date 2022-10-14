<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsFormB18 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('form_b18', function (Blueprint $table) {
            
            $table->string('hazardEvent')->nullable();           
            $table->string('lkh1')->nullable();
            $table->string('svr1')->nullable();
            $table->string('rf1')->nullable();
            $table->longText('control_measure')->nullable();
            $table->string('lkh2')->nullable();
            $table->string('svr2')->nullable();
            $table->string('rf2')->nullable();
            $table->string('add_control')->nullable();
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
        Schema::table('form_b18', function (Blueprint $table) {
            // $table->dropColumn('hazardEvent');
            // $table->dropColumn('lkh1');
            // $table->dropColumn('svr1');
            // $table->dropColumn('rf1');
            // $table->dropColumn('control_measure');
            // $table->dropColumn('lkh2');
            // $table->dropColumn('svr2');
            // $table->dropColumn('rf2');
            // $table->dropColumn('add_control');
            // $table->dropColumn('alternate_method');
            // $table->dropColumn('hazard_discussed');
            // $table->dropColumn('jha_start');
            // $table->dropColumn('jha_end');
            // $table->dropColumn('unassessed_hazards');
            // $table->dropColumn('comments');
            // $table->dropColumn('port_authorities');
            // $table->dropColumn('tools_available');
            // $table->dropColumn('lcd_notified');
            // $table->dropColumn('threats');
            // $table->dropColumn('top_event');
            // $table->dropColumn('control');
            // $table->dropColumn('recovery_measure');
            // $table->dropColumn('reduction_measure');
            // $table->dropColumn('grr_p');
            // $table->dropColumn('grr_e');
            // $table->dropColumn('grr_a');
            // $table->dropColumn('grr_r');
            // $table->dropColumn('nrr_p');
            // $table->dropColumn('nrr_e');
            // $table->dropColumn('nrr_a');
            // $table->dropColumn('nrr_r');
            // $table->dropColumn('sources');   
        });
    }
}
