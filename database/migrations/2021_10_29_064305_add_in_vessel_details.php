<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInVesselDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vessel_details', function (Blueprint $table) {
            //
            $table->string('vessel_image')->nullable();
        });
        Schema::table('vessels', function (Blueprint $table) {
            //
            $table->string('vessel_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vessel_details', function (Blueprint $table) {
            //
            $table->dropColumn('vessel_image');
        });
        Schema::table('vessels', function (Blueprint $table) {
            //
            $table->dropColumn('vessel_image');
        });
    }
}
