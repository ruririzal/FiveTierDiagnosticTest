<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlasanJawabanSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alasan_jawaban_soal', function (Blueprint $table) {
            $table->id();
            $table->longText('teks');
            $table->boolean('is_benar')->default(false);
            $table->unsignedBigInteger('soal_id');
            $table->foreign('soal_id', 'soal_id_ajs')->references('id')->on('soal')->onDelete('cascade');
            
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
        Schema::dropIfExists('alasan_jawaban_soal');
    }
}
