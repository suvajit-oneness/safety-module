<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHazardMasterListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hazard_master_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hazard_id')->unsigned()->nullable();
            $table->longtext('ref');
            $table->longtext('hazards');
            $table->longtext('threats');
            $table->longtext('top_event');
            $table->longtext('consequences');
            $table->longtext('control');
            $table->longtext('recover_measure');
            $table->longtext('reduction_measure');
            $table->longtext('remarks');
            $table->timestamps();
        });
        Schema::table('hazard_master_lists', function (Blueprint $table) {
            
            $table->foreign('hazard_id')->references('id')->on('hazard_lists')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hazard_master_lists');
    }
}
