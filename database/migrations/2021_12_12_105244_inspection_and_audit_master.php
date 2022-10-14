<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InspectionAndAuditMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_and_audit_master', function(Blueprint $t){
            $t->string('id');
            $t->string('vessel_id');
            $t->date('report_date')->nullable();
            $t->string('location')->nullable();
            $t->string('type_of_audit')->nullable();
            $t->string('status')->nullable();
            $t->timestamps(); 
            $t->timestamp('deleted_at')->default(DB::raw('CURRENT_TIMESTAMP')); 
              
           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::drop('inspection_and_audit_master');
    }
}
