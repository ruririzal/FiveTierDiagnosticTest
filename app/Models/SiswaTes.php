<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SiswaTes extends Model
{
    protected $table = 'siswa_tes';

    protected $dates = [
        'waktu_mulai',
        'waktu_selesai',
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'siswa_id',
        'waktu_mulai',
        'waktu_selesai',
    ];

    protected $cast = [

    ];
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswaPerSoal::class, 'tes_id');
    }

    public function rekapTesSiswa()
    {
        return $this->hasOne(RekapHasilTesSiswa::class, 'tes_id');
    }
}
