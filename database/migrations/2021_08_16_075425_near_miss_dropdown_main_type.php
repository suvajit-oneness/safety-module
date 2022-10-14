<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NearMissDropdownMainType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('near_miss_dropdown_main_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_main_name', 100);
            $table->unsignedBigInteger('dropdown_id');

            $table->foreign('dropdown_id')->references('id')->on('near_miss_dropdown')->onDelete('cascade');

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
