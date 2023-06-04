<?php

namespace App\Models;


class SimulasiSoal extends Soal
{
    /** Override $table */
    protected $table = 's_soal';

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /** Override function */
    public function jawaban()
    {
        return $this->hasMany(SimulasiJawaban::class, 'soal_id');
    }

    /** Override function */
    public function alasanJawaban()
    {
        return $this->hasMany(SimulasiAlasanJawabanSoal::class, 'soal_id');
    }
}
