<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentSubTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrument_sub_topics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('instrument_topic_id')->unsigned();
            $table->string('name', 100);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('instrument_topic_id')->references('id')->on('instrument_topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instrument_sub_topics');
    }
}
