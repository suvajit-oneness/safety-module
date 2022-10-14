<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FollowupActionFieldNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('incident_reports_follow_up_actions', function (Blueprint $table) {
            //
            $table->string('evidence_file')->nullable();
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
        Schema::table('incident_reports_follow_up_actions', function (Blueprint $table) {
            //
            $table->dropColumn('evidence_file');
        });
    }
}
