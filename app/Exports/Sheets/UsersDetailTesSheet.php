<?php

namespace App\Exports\Sheets;

use App\User;
use App\Models\Soal;
use App\Models\Jawaban;
use App\Models\SiswaTes;
use App\Enums\TierFiveEnums;
use App\Models\AlasanJawabanSoal;
use App\Models\RekapHasilTesSiswa;
use Illuminate\Support\Facades\DB;
use App\Models\JawabanSiswaPerSoal;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Services\CalculationOfConceptionCriteria;

class UsersDetailTesSheet implements FromQuery, WithHeadings, WithTitle, WithMapping
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function query()
    {
        $soal = (new Soal())->getTable();
        $jawaban = (new Jawaban())->getTable();
        $alasan_jawaban = (new AlasanJawabanSoal())->getTable();
        $jawaban_siswa_per_soal = (new JawabanSiswaPerSoal())->getTable();
        return JawabanSiswaPerSoal::query()
            ->select([
                DB::raw("SUBSTRING($soal.teks, 1, 50) as soal"), 
                DB::raw("SUBSTRING($jawaban.teks, 1, 50) as jawaban"), 
                DB::raw("is_jawaban_yakin"), 
                DB::raw("SUBSTRING($alasan_jawaban.teks, 1, 50) alasan_jawaban"), 
                DB::raw("is_alasan_yakin"), 
                "tier_five",
                "$jawaban.is_benar as jawaban_benar",
                "$alasan_jawaban.is_benar as alasan_jawaban_benar",
                "$jawaban_siswa_per_soal.id",
                "$jawaban_siswa_per_soal.jawaban_id",
                "$jawaban_siswa_per_soal.soal_id",
            ])
            ->leftJoin($soal, function($join) use ($jawaban_siswa_per_soal, $soal){
                return $join->on($soal . '.id', '=', $jawaban_siswa_per_soal . '.soal_id');
            })->leftJoin($jawaban, function($join) use ($jawaban_siswa_per_soal, $soal, $jawaban){
                return $join->on($jawaban . '.id', '=', $jawaban_siswa_per_soal . '.jawaban_id');
                    // ->where($jawaban . '.soal_id', $soal . '.id');
            })->leftJoin($alasan_jawaban, function($join) use ($jawaban_siswa_per_soal, $soal, $alasan_jawaban){
                return $join->on($alasan_jawaban . '.id', '=', $jawaban_siswa_per_soal . '.alasan_jawaban_soal_id');
                    // ->where($alasan_jawaban . '.soal_id', $soal . '.id');
            })
            ->where('siswa_id', $this->user->id)
            ;
    }
    
    /**
    * @var query $jawaban_siswa_per_soal
    */
    public function map($jawaban_siswa_per_soal): array
    {
        $tier_1 = $jawaban_siswa_per_soal->jawaban_benar;
        $tier_2 = $jawaban_siswa_per_soal->is_jawaban_yakin;
        $tier_3 = $jawaban_siswa_per_soal->alasan_jawaban_benar;
        $tier_4 = $jawaban_siswa_per_soal->is_alasan_yakin;
        $tier_5 = $jawaban_siswa_per_soal->tier_five;
        
        list($criteria, $conception)  = (new CalculationOfConceptionCriteria())->get($tier_1, $tier_2, $tier_3, $tier_4, $tier_5);
                
        return [
            strip_tags($jawaban_siswa_per_soal->soal),
            strip_tags($jawaban_siswa_per_soal->jawaban),
            $jawaban_siswa_per_soal->jawaban_benar == 1 ? 'Ya' : 'Tidak',
            $jawaban_siswa_per_soal->is_jawaban_yakin == 1 ? 'Ya' : 'Tidak',
            strip_tags($jawaban_siswa_per_soal->alasan_jawaban),
            $jawaban_siswa_per_soal->alasan_benar == 1 ? 'Ya' : 'Tidak',
            $jawaban_siswa_per_soal->is_alasan_yakin == 1 ? 'Ya' : 'Tidak',
            $conception['text'],
            $criteria['text'] . ' - ' . ucwords($conception['conception_text'])
        ];
    }

    public function headings(): array
    {
        $firstRow = [ 
            'Soal',
            'Jawaban',
            'Jawaban Benar?',
            'Keyakinan Jawaban',
            'Alasan Menjawab',
            'Alasan Benar?',
            'Keyakinan Alasan',
            'Jawaban dan alasan berdasarkan',
            'Kriteria'
        ];
        return $firstRow;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Siswa ID ' . $this->user->id;
    }
}
