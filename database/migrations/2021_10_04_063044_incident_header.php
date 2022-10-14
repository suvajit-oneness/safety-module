<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncidentHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('incident_report', function (Blueprint $t) {

            $t->string('incident_header')->nullable();
            $t->longText('comments_five_why_section')->nullable();
           
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
        Schema::table('incident_report', function (Blueprint $t) {

            $t->dropColumn('incident_header');
            $t->dropColumn('comments_five_why_section');
           
        });
    }
}
