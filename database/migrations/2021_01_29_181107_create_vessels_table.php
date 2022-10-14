<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vessels', function (Blueprint $table) {
            

            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->integer('fleet_id')->unsigned()->nullable();
            // $table->foreign('fleet_id')->references('id')->on('fleets')->onDelete('cascade');
        });

        Schema::table('vessels', function (Blueprint $table) {
            
            $table->foreign('fleet_id')->references('id')->on('fleets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vessels');
    }
}
