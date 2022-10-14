<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNearMissTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('near_miss_accident_report', function (Blueprint $table) {
            $table->string('date', 100)->nullable()->change();
            $table->text('describtion')->nullable()->change();
            $table->string('incident_type_one', 100)->nullable()->change();
            $table->string('incident_type_two', 100)->nullable()->change();
            $table->string('incident_type_three', 100)->nullable()->change();
            $table->string('immediate_cause_one', 100)->nullable()->change();
            $table->string('immediate_cause_two', 100)->nullable()->change();
            $table->string('immediate_cause_three', 100)->nullable()->change();
            $table->text('corrective_action')->nullable()->change();
            $table->text('root_causes_one')->nullable()->change();
            $table->text('root_causes_two')->nullable()->change();
            $table->text('root_causes_three')->nullable()->change();
            $table->text('preventive_actions_one')->nullable()->change();
            $table->text('preventive_actions_two')->nullable()->change();
            $table->text('preventive_actions_three')->nullable()->change();
            $table->string('close', 100)->nullable()->change();
            $table->text('office_comments')->nullable()->change();
            $table->text('lession_learnt')->nullable()->change();
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('near_miss_accident_report', function (Blueprint $table) {
            $table->date('date', 100)->nullable(false)->change();
            $table->text('describtion')->nullable(false)->change();
            $table->string('incident_type_one', 100)->nullable(false)->change();
            $table->string('incident_type_two', 100)->nullable(false)->change();
            $table->string('incident_type_three', 100)->nullable(false)->change();
            $table->string('immediate_cause_one', 100)->nullable(false)->change();
            $table->string('immediate_cause_two', 100)->nullable(false)->change();
            $table->string('immediate_cause_three', 100)->nullable(false)->change();
            $table->text('corrective_action')->nullable(false)->change();
            $table->text('root_causes_one')->nullable(false)->change();
            $table->text('root_causes_two')->nullable(false)->change();
            $table->text('root_causes_three')->nullable(false)->change();
            $table->text('preventive_actions_one')->nullable(false)->change();
            $table->text('preventive_actions_two')->nullable(false)->change();
            $table->text('preventive_actions_three')->nullable(false)->change();
            $table->string('close', 100)->nullable(false)->change();
            $table->text('office_comments')->nullable(false)->change();
            $table->text('lession_learnt')->nullable(false)->change();
        });
    }
}
