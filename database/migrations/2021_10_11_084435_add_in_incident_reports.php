<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInIncidentReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incident_report', function (Blueprint $table) {
            //
            $table->string('investigation_matrix_fst')->nullable();
            $table->string('investigation_matrix_scnd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incident_report', function (Blueprint $table) {
            //
            $table->dropColumn('investigation_matrix_fst');
            $table->dropColumn('investigation_matrix_scnd');
        });
    }
}
