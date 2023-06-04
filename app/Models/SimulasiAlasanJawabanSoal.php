<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulasiAlasanJawabanSoal extends AlasanJawabanSoal
{
    /** Override $table */
    protected $table = 's_alasan_jawaban_soal';

    /** Override function */
    public function soal()
    {
        return $this->belongsTo(SimulasiSoal::class, 'soal_id');
    }
}
