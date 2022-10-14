<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReportNumberForIncidentReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('incident_report_number', function (Blueprint $t) {
            $t->bigIncrements('id');

            $t->string('vessel_code')->nullable();
            $t->string('year')->nullable();
            $t->string('ref')->nullable();
            $t->string('incident_report_id')->nullable();

            $t->timestamps();
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
        Schema::drop('incident_report_number');

    }
}
