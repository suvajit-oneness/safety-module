<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VesselNewField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('vessel_details', function (Blueprint $t) {

            // $t->string('breadth')->nullable();
            $t->string('depth')->nullable();
           
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
        Schema::table('vessel_details', function (Blueprint $t) {

            // $t->dropColumn('breadth');
            $t->dropColumn('depth');
           
        });
    }
}
