<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowNullSomeJawabanSiswaPerSoalTableField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            DB::statement("ALTER TABLE jawaban_siswa_per_soal MODIFY COLUMN jawaban_id BIGINT(20) unsigned NULL DEFAULT NULL");
            DB::statement("ALTER TABLE jawaban_siswa_per_soal MODIFY COLUMN is_jawaban_yakin BOOLEAN NULL DEFAULT NULL");
            DB::statement("ALTER TABLE jawaban_siswa_per_soal MODIFY COLUMN alasan_jawaban_soal_id BIGINT(20) unsigned NULL DEFAULT NULL");
            DB::statement("ALTER TABLE jawaban_siswa_per_soal MODIFY COLUMN is_alasan_yakin BOOLEAN NULL DEFAULT NULL");
            DB::statement("ALTER TABLE jawaban_siswa_per_soal MODIFY COLUMN tier_five ENUM(" . '"' . implode('","', \App\Enums\TierFiveEnums::SEMUA_ID) . '"' .") NULL DEFAULT NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
