<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSJawabanSiswaPerSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_jawaban_siswa_per_soal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tes_id');
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('soal_id');
            $table->unsignedBigInteger('jawaban_id')->nullable()->default(null);
            $table->boolean('is_jawaban_yakin')->nullable()->default(null);
            $table->unsignedBigInteger('alasan_jawaban_soal_id')->nullable()->default(null);
            $table->boolean('is_alasan_yakin')->nullable()->default(null);
            $table->enum('tier_five', \App\Enums\TierFiveEnums::SEMUA_ID)->nullable()->default(null);

            $table->foreign('tes_id', 's_jsps1')->references('id')->on('s_siswa_tes')->onDelete('cascade');
            $table->foreign('siswa_id', 's_jsps2')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('soal_id', 's_jsps3')->references('id')->on('s_soal')->onDelete('cascade');
            $table->foreign('jawaban_id', 's_jsps4')->references('id')->on('s_jawaban')->onDelete('cascade');
            $table->foreign('alasan_jawaban_soal_id', 's_jsps5')->references('id')->on('s_alasan_jawaban_soal')->onDelete('cascade');

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
        Schema::dropIfExists('s_jawaban_siswa_per_soal');
    }
}
