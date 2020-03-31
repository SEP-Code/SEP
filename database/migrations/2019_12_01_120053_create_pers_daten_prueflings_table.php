<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersDatenPrueflingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pers_daten_prueflings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('vorname');
            $table->string('nachname');
            $table->string('strasseHausnummer');
            $table->string('stadtPLZ');
            $table->date('GebDatum');
            $table->enum('geschlecht', ['w', 'm', 'd']);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('attest')->nullable();
            $table->string('kontoauszug')->nullable();
            $table->string('einvErkl')->nullable();
            $table->string('passbild')->nullable();
            $table->string('wDok')->nullable();
            $table->string('attest_name')->nullable();
            $table->string('kontoauszug_name')->nullable();
            $table->string('einvErkl_name')->nullable();
            $table->string('passbild_name')->nullable();
            $table->string('wDok_name')->nullable();
            $table->integer('abgeschlossen')->default(0);
            $table->integer('anwesend')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pers_daten_prueflings');
    }
}
