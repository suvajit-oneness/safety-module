<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFormB18Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // alter hazardEvent and add_control column to nullable longText

        Schema::table('form_b18', function ($table) {
            $table->longText('hazardEvent')->change();
            $table->longText('add_control')->change();
        });

        // add new column acFlag and source nullable

        Schema::table('form_b18', function (Blueprint $table) {
            $table->string('source')->nullable();
            $table->string('acFlag')->nullable();
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
