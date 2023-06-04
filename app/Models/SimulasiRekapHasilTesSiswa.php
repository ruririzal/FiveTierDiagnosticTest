<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulasiRekapHasilTesSiswa extends RekapHasilTesSiswa
{
    /** Override $table */
    protected $table = 's_rekap_hasil_tes_siswa';

    /** Override function */
    public function tes()
    {
        return $this->belongsTo(SimulasiSiswaTes::class, 'tes_id');
    }
}
