<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditRejectDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_reject_descriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->nullable()->unsigned();
            $table->bigInteger('period_id')->nullable()->unsigned();
            $table->bigInteger('audit_form_id')->nullable()->unsigned();
            $table->bigInteger('auditee_id')->nullable()->unsigned();
            $table->bigInteger('auditor_id')->nullable()->unsigned();
            $table->bigInteger('instrument_id')->nullable()->unsigned();

            $table->integer('revision')->default(1);
            $table->string('document_no', 100)->nullable();
            $table->enum('category', ['kts_minor', 'kts_mayor', 'observasi'])->nullable();

            $table->string('auditee_name', 100)->nullable();
            $table->string('auditor_name', 100)->nullable();
            $table->string('instrument_topic_name', 100)->nullable();

            $table->text('finding_description')->nullable();
            $table->text('root_caused_description')->nullable();
            $table->text('consequence_description')->nullable();
            $table->text('action_plan_description')->nullable();

            $table->enum('scope_type', ['academic', 'non_academic'])->nullable();
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
        Schema::dropIfExists('audit_reject_descriptions');
    }
}
