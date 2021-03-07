<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'teks',
        'is_benar',
        'soal_id'
    ];

    protected $cast = [
        'is_benar' => 'boolean'
    ];
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id');
    }
}
