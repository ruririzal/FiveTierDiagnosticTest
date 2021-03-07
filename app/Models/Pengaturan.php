<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'durasi_menit',
    ];

    protected $cast = [

    ];
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
