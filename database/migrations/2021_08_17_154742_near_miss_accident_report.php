<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NearMissAccidentReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('near_miss_accident_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date', 100)->nullable();
            $table->text('describtion')->nullable();
            $table->string('incident_type_one', 100);
            $table->string('incident_type_two', 100)->nullable();
            $table->string('incident_type_three', 100)->nullable();
            $table->string('immediate_cause_one', 100)->nullable();
            $table->string('immediate_cause_two', 100)->nullable();
            $table->string('immediate_cause_three', 100)->nullable();
            $table->text('corrective_action')->nullable();
            $table->text('root_causes_one')->nullable();
            $table->text('root_causes_two')->nullable();
            $table->text('root_causes_three')->nullable();
            $table->text('preventive_actions_one')->nullable();
            $table->text('preventive_actions_two')->nullable();
            $table->text('preventive_actions_three')->nullable();
            $table->string('close', 100)->nullable();
            $table->text('office_comments')->nullable();
            $table->text('lession_learnt')->nullable();
            $table->bigInteger('created_by')->nullable();

            $table->timestamps();
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
