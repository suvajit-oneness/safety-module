<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIncidentReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('incident_report', function (Blueprint $table) {
            //
            $table->string('user_id')->nullable();
            $table->string('saved_status')->nullable();
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
        Schema::table('incident_report', function (Blueprint $table) {
            //
            $table->dropColumn('user_id');
            $table->dropColumn('saved_status');
        });
    }
}
