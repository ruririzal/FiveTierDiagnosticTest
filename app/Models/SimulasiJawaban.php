<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulasiJawaban extends Jawaban
{
    /** Override $table */
    protected $table = 's_jawaban';

    /** Override function */
    public function soal()
    {
        return $this->belongsTo(SimulasiSoal::class, 'soal_id');
    }
}
