<?php

namespace App\Enums;

class TierFiveEnums
{
    const BUKU = ['id' => 'buku', 'text' => 'Membaca dari buku', 'conception_code' => 'B', 'conception_text' => 'book'];
    const GURU = ['id' => 'guru', 'text' => 'Penjelasan guru', 'conception_code' => 'T', 'conception_text' => 'teacher'];
    const PEMIKIRAN_PRIBADI = ['id' => 'pemikiran_pribadi', 'text' => 'Pemikiran pribadi', 'conception_code' => 'PT', 'conception_text' => 'personal thoughts'];
    const TEMAN = ['id' => 'teman', 'text' => 'Penjelasan Teman', 'conception_code' => 'OPE', 'conception_text' => 'other people explanation'];
    const INTERNET = ['id' => 'internet', 'text' => 'Membaca dari internet', 'conception_code' => 'I', 'conception_text' => 'internet'];

    const SEMUA_ID = [
        self::BUKU['id'],
        self::GURU['id'],
        self::PEMIKIRAN_PRIBADI['id'],
        self::TEMAN['id'],
        self::INTERNET['id'],
    ];
    
    const SEMUA = [
        self::BUKU,
        self::GURU,
        self::PEMIKIRAN_PRIBADI,
        self::TEMAN,
        self::INTERNET,
    ];

    final static public function SEMUA_CAMELCASE()
    {
        $arr = [];
        foreach(self::SEMUA_ID as $item){
            $arr[] = strtolower(str_replace(' ', '_', $item));
        }
        return $arr;
    }
}