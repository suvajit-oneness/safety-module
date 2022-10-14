<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrewList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('crew_list', function (Blueprint $t) {
            $t->bigIncrements('id');
            $t->string('name')->nullable();
            $t->string('rank')->nullable();
            $t->string('nationality')->nullable();
            $t->string('sex')->nullable();
            $t->string('dob')->nullable();
            $t->string('pob')->nullable();
            $t->string('seaman_passpoert_pp_no')->nullable();
            $t->string('seaman_passpoert_exp')->nullable();
            $t->string('seaman_book_cdc_no')->nullable();
            $t->string('seaman_book_exp')->nullable();
            $t->string('date_and_port_of_embarkation_date')->nullable();
            $t->string('date_and_port_of_embarkation_port')->nullable();
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
        Schema::drop('crew_list');
    }
}
