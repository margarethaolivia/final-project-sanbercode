<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pertanyaan_id');
            $table->unsignedBigInteger('jawaban_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan');
            $table->foreign('jawaban_id')->references('id')->on('jawaban');
            $table->integer('vote');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote');
    }
}
