<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('pers_daten_pruefling_id');
            $table->foreign('pers_daten_pruefling_id')->references('id')->on('pers_daten_prueflings')->onDelete('cascade');
            $table->unsignedBigInteger('discipline_id');
            $table->string('comment');
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete('cascade');
            $table->unsignedBigInteger('error_code_id')->nullable();
            $table->foreign('error_code_id')->references('id')->on('error_codes')->onDelete('cascade');
            $table->double('result')->nullable();
            $table->double('enteredIn')->nullable();
            $table->double('passed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
