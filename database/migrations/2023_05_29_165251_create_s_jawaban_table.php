<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_jawaban', function (Blueprint $table) {
            $table->id();
            $table->longText('teks');
            $table->boolean('is_benar')->default(false);
            $table->unsignedBigInteger('soal_id');
            $table->foreign('soal_id', 's_soal_id_j')->references('id')->on('s_soal')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_jawaban');
    }
}
