<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InspectionAndAuditCorrectiveActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_and_audit_corrective_actions', function(Blueprint $t){
            $t->string('id');
            $t->string('inspection_and_audit_form_id');
            $t->string('description')->nullable();
            $t->date('date_completed')->nullable();
            $t->timestamps();  
            $t->timestamp('deleted_at')->default(DB::raw('CURRENT_TIMESTAMP')); 

            $t->foreign('inspection_and_audit_id')->references('id')->on('inspection_and_audit_master')->onDelete('cascade');
           

            
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inspection_and_audit_corrective_actions');        
       
        
    }
}
