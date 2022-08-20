<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditFormResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_form_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('audit_form_id')->unsigned();
            $table->bigInteger('instrument_id')->unsigned();
            $table->text('instrument')->nullable();
            $table->text('description')->nullable();
            $table->string('evidence_file', 255)->nullable();
            $table->tinyInteger('approval')->nullable()->default(null);
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
        Schema::dropIfExists('audit_form_results');
    }
}
