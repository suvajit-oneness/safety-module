<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableIncidentReportMakeNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incident_report', function (Blueprint $t) {
            $t->unsignedBigInteger('created_by')->nullable(true)->change();

            $t->unsignedBigInteger('master')->nullable(true)->change();
            $t->unsignedBigInteger('chief_engineer')->nullable(true)->change();
            $t->unsignedBigInteger('chief_officer')->nullable(true)->change();
            $t->unsignedBigInteger('first_engineer')->nullable(true)->change();
            
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
    }
}
