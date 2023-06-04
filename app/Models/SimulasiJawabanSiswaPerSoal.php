<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulasiJawabanSiswaPerSoal extends JawabanSiswaPerSoal
{
    /** Override $table */
    protected $table = 's_jawaban_siswa_per_soal';

    /** Override function */
    public function jawaban()
    {
        return $this->belongsTo(SimulasiJawaban::class, 'jawaban_id');
    }

    /** Override function */
    public function soal()
    {
        return $this->belongsTo(SimulasiSoal::class, 'soal_id');
    }

    /** Override function */
    public function tes()
    {
        return $this->belongsTo(SimulasiSoalTes::class, 'tes_id');
    }

    /** Override function */
    public function alasan_jawaban_soal()
    {
        return $this->belongsTo(SimulasiAlasanJawabanSoal::class, 'alasan_jawaban_soal_id');
    }

    /** Override function */
    public function keyakinan_jawaban_dan_alasan()
    {
        return $this->belongsTo(SimulasiKeyakinanJawabanDanAlasan::class, 'keyakinan_jawaban_dan_alasan_id');
    }

    /** Override function */
    public function siswa()
    {
        return $this->belongsTo(SimulasiUsers::class, 'siswa_id');
    }
}
