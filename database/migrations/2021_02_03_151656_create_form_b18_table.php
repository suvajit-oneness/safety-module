<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormB18Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_b18', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_template')->nullable();
            $table->integer('vessel_info_id')->unsigned()->nullable();
            $table->integer('hazard_list_id')->unsigned()->nullable();
            $table->longtext('hazards')->nullable();
            $table->longtext('threats')->nullable();
            $table->longtext('top_event')->nullable();
            $table->longtext('consequences')->nullable();
            $table->longtext('control')->nullable();
            $table->longtext('recovery_measure')->nullable();
            $table->longtext('reduction_measure')->nullable();
            $table->longtext('remarks')->nullable();

            $table->string('grr_p')->nullable();
            $table->string('grr_e')->nullable();
            $table->string('grr_a')->nullable();
            $table->string('grr_r')->nullable();

            $table->string('nrr_p')->nullable();
            $table->string('nrr_e')->nullable();
            $table->string('nrr_a')->nullable();
            $table->string('nrr_r')->nullable();

            $table->timestamps();
        });

        Schema::table('form_b18', function (Blueprint $table) {
            $table->foreign('hazard_list_id')->references('id')->on('hazard_lists')->onDelete('cascade');
            $table->foreign('vessel_info_id')->references('id')->on('risk_assessment_vessel_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_b18');
    }
}
