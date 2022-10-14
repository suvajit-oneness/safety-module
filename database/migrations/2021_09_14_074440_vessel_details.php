<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VesselDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('vessel_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('vessel_code');
            $table->string('class_society');
            $table->string('imo_no');
            $table->string('year_built');
            $table->string('type');
            $table->string('owner');
            $table->string('hull_no');
            $table->string('grt');
            $table->string('call_sign');
            $table->string('flag');
            $table->string('nrt');
            $table->string('length');
            $table->string('port_of_registry');
            $table->string('breadth');
            $table->string('moulded_depth');
            $table->timestamps();
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
        Schema::drop('vessel_details');
    }
}
