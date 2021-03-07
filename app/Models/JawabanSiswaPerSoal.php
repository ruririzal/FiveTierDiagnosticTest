<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswaPerSoal extends Model
{
    protected $table = 'jawaban_siswa_per_soal';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'tes_id',
        'soal_id',
        'siswa_id',
        'jawaban_id',
        'is_jawaban_yakin',
        'alasan_jawaban_soal_id',
        'is_alasan_yakin',
        'keyakinan_jawaban_dan_alasan_id'
    ];

    protected $cast = [
        'is_jawaban_yakin' => 'boolean',
        'is_alasan_yakin' => 'boolean',
    ];
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class, 'jawaban_id');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id');
    }

    public function tes()
    {
        return $this->belongsTo(SoalTes::class, 'tes_id');
    }

    public function alasan_jawaban_soal()
    {
        return $this->belongsTo(AlasanJawabanSoal::class, 'alasan_jawaban_soal_id');
    }

    public function keyakinan_jawaban_dan_alasan()
    {
        return $this->belongsTo(KeyakinanJawabanDanAlasan::class, 'keyakinan_jawaban_dan_alasan_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Users::class, 'siswa_id');
    }
}
