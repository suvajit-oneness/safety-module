<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NearMissDropdownTerType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('near_miss_dropdown_ter_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_ter_name', 100);
            $table->unsignedBigInteger('sub_id');

            $table->foreign('sub_id')->references('id')->on('near_miss_dropdown_sub_type')->onDelete('cascade');

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
