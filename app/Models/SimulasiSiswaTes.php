<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulasiSiswaTes extends SiswaTes
{
    /** Override $table */
    protected $table = 's_siswa_tes';

    /** Override function */
    public function jawabanSiswa()
    {
        return $this->hasMany(SimulasiJawabanSiswaPerSoal::class, 'tes_id');
    }

    /** Override function */
    public function rekapTesSiswa()
    {
        return $this->hasOne(SimulasiRekapHasilTesSiswa::class, 'tes_id');
    }
}
