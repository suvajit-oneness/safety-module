<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVesselNameFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_assessment_vessel_infos', function (Blueprint $table) {
            $table->string('vessel_name')->nullable();
            $table->string('weather')->nullable();
            $table->string('voyage')->nullable();
            $table->string('location')->nullable();
            $table->string('tide')->nullable();
            $table->string('work_activity')->nullable();
            $table->string('work_area')->nullable();
            $table->string('visibility')->nullable();
            $table->string('master_name')->nullable();
            $table->date('master_date')->nullable();
            $table->string('ch_off_name')->nullable();
            $table->string('ch_eng_name')->nullable();
            $table->string('eng2_name')->nullable();
            $table->string('sm_name')->nullable();
            $table->string('dgm_activity_type')->nullable();
            $table->date('ch_off_date')->nullable();
            $table->date('ch_eng_date')->nullable();
            $table->date('eng2_date')->nullable();
            $table->date('sm_date')->nullable();
            $table->date('dgm_date')->nullable();
            $table->date('gm_date')->nullable();
            $table->string('dgm_name')->nullable();
            $table->string('name_rank')->nullable();
            $table->string('gm_activity_type')->nullable();
            $table->string('gm_name')->nullable(); 
            $table->string('alternate_method')->nullable();
            $table->string('hazard_discussed')->nullable();
            $table->date('jha_start')->nullable();
            $table->date('jha_end')->nullable();
            $table->string('unassessed_hazards')->nullable();
            $table->string('comments')->nullable();
            $table->string('port_authorities')->nullable();
            $table->string('tools_available')->nullable();
            $table->string('lcd_notified')->nullable();
            $table->date('jha_date')->nullable();
            $table->string('last_assessment')->nullable(); 
            $table->longText('remarks')->nullable();           
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
            dropColumn('vessel_name');
            dropColumn('weather');
        });
    }
}
