<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('instrument_sub_topic_id')->unsigned();
            $table->text('matrix');
            $table->enum('audit_type', ['academic', 'non_academic'])->default('academic');
            $table->boolean('is_available')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('instrument_sub_topic_id')->references('id')->on('instrument_sub_topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instruments');
    }
}
