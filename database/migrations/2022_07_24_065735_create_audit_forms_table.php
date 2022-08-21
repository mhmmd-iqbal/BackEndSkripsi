<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->nullable()->unsigned();
            $table->bigInteger('period_id')->nullable()->unsigned();
            $table->bigInteger('auditor_id')->nullable()->unsigned()->comment('Assign to auditor');
            $table->bigInteger('auditee_id')->nullable()->unsigned()->comment('Assign to auditor');
            $table->integer('revision')->default(1);
            $table->string('document_no', 100)->nullable();
            $table->string('department_name', 100)->nullable();
            $table->string('auditee_name', 100)->nullable();
            $table->string('auditor_name', 100)->nullable();
            $table->jsonb('auditor_member_list_json')->nullable();
            $table->enum('scope_type', ['academic', 'non_academic'])->nullable();
            $table->string('audit_type', 100)->nullable()->default('Lapangan');
            $table->string('audit_title', 100)->nullable();
            $table->dateTime('audit_at')->nullable();
            $table->tinyInteger('audit_status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_forms');
    }
}
