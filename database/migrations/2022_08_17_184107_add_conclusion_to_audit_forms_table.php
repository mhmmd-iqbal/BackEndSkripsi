<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConclusionToAuditFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_forms', function (Blueprint $table) {
            $table->text('json_positive_issue')->nullable();
            $table->text('json_conclusion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_forms', function (Blueprint $table) {
            $table->dropColumn('json_positive_issue');
            $table->dropColumn('json_conclusion');
        });
    }
}
