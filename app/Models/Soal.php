<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'teks',
        'is_aktif',
    ];

    protected $cast = [
        'is_aktif' => 'boolean'
    ];
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'soal_id');
    }

    public function alasanJawaban()
    {
        return $this->hasMany(AlasanJawabanSoal::class, 'soal_id');
    }
}
