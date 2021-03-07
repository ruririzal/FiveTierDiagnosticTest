<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanSiswaPerSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_siswa_per_soal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tes_id');
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('soal_id');
            $table->unsignedBigInteger('jawaban_id');
            $table->boolean('is_jawaban_yakin');
            $table->unsignedBigInteger('alasan_jawaban_soal_id');
            $table->boolean('is_alasan_yakin');
            $table->enum('tier_five', \App\Enums\TierFiveEnums::SEMUA_ID);
            
            $table->foreign('tes_id', 'jsps1')->references('id')->on('siswa_tes')->onDelete('cascade');
            $table->foreign('siswa_id', 'jsps2')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('soal_id', 'jsps3')->references('id')->on('soal')->onDelete('cascade');
            $table->foreign('jawaban_id', 'jsps4')->references('id')->on('jawaban')->onDelete('cascade');
            $table->foreign('alasan_jawaban_soal_id', 'jsps5')->references('id')->on('alasan_jawaban_soal')->onDelete('cascade');
            
            $table->unique(['siswa_id', 'soal_id']);

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
        Schema::dropIfExists('jawaban_siswa_per_soal');
    }
}
