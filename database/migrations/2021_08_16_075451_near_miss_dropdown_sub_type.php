<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NearMissDropdownSubType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('near_miss_dropdown_sub_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_sub_name', 100);
            $table->unsignedBigInteger('main_type_id');

            $table->foreign('main_type_id')->references('id')->on('near_miss_dropdown_main_type')->onDelete('cascade');


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
