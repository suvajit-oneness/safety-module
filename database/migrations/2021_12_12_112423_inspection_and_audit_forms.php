<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InspectionAndAuditForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_and_audit_forms', function(Blueprint $t){
            $t->string('id');
            $t->string('inspection_and_audit_id');
            $t->string('name_of_auditor')->nullable();
            $t->string('description')->nullable();
            $t->string('type_of_report')->nullable();
            $t->string('ism_clause')->nullable();
            $t->string('type_of_nc')->nullable();
            $t->date('due_date')->nullable();
            $t->string('sign_by_master_name')->nullable();
            $t->string('sign_by_master_url')->nullable();
            $t->string('sign_by_auditor_name')->nullable();
            $t->string('sign_by_auditor_url')->nullable();
            $t->string('sign_by_auditee_name')->nullable();
            $t->string('sign_by_auditee_url')->nullable();
            $t->string('accepted_by_name')->nullable();
            $t->string('accepted_by_url')->nullable();
            $t->string('follow_up_comments')->nullable();
            $t->boolean('is_confirmed_by')->nullable();
            $t->date('form_date')->nullable();
            $t->boolean('is_verification_required')->nullable();
            $t->string('psc_ref')->nullable();
            $t->string('psc_code')->nullable();
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
        Schema::drop('inspection_and_audit_forms');
    }
}
