<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InspectionAndAuditPreventiveUploadEvidence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_and_audit_preventive_upload_evidence', function(Blueprint $t){
            $t->string('id');
            $t->string('inspection_and_audit_preventive_id');
            $t->string('url')->nullable();
            $t->string('name')->nullable();
            $t->timestamps();  
            $t->timestamp('deleted_at')->default(DB::raw('CURRENT_TIMESTAMP')); 

            $t->foreign('inspection_and_audit_preventive_id')->references('id')->on('inspection_and_audit_preventive_actions')->onDelete('cascade');
            

            
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inspection_and_audit_preventive_upload_evidence');  
        
    }
}
