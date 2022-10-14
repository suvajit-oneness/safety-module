<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTemplateIdB18Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('form_b18', function (Blueprint $table) {
            $table->integer('template_id')->unsigned()->nullable();
        });
        /*Schema::table('form_b18', function (Blueprint $table) {
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('form_b18',function (Blueprint $table) {
            $table->dropForeign(['template_id']);
        });
        Schema::table('form_b18', function (Blueprint $table) {
            $table->dropColumn('template_id');
        });
    }
}
