<?php

namespace App\Exports\Sheets;

use App\User;
use App\Models\SiswaTes;
use App\Models\RekapHasilTesSiswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersRekapTesSheet implements FromQuery, WithHeadings, WithTitle
{
    public function query()
    {
        $tes = (new SiswaTes())->getTable();
        $rekap_tes = (new RekapHasilTesSiswa())->getTable();

        $select_rekap = [DB::raw("IFNULL($rekap_tes.jumlah_tidak_dijawab,0)"),];
        foreach(\App\Services\CalculationOfConceptionCriteria::ALL_CRITERIA as $item){
            if($item['id'] == \App\Services\CalculationOfConceptionCriteria::CRITERIA_MC['id']){
                foreach(\App\Enums\TierFiveEnums::SEMUA_CAMELCASE() as $tier_five){
                    $select_rekap[] = DB::raw("IFNULL({$rekap_tes}.list_{$item['id']}_{$tier_five}, 0)");
                }
                $select_rekap[] = DB::raw("IFNULL({$rekap_tes}.jumlah_{$item['id']}, 0)");
            }else{
                $select_rekap[] = DB::raw("IFNULL({$rekap_tes}.list_{$item['id']}, 0)");
            }
        }
        return User::query()
            ->select([
                "users.id", 
                "email",
                "name",
                "kelas",
            ])
            ->where('is_admin', 0)
            ->addSelect(DB::raw("CONCAT($tes.waktu_mulai, ' s.d ',  $tes.waktu_selesai)"))
            ->addSelect($select_rekap)
            ->leftJoin($tes, function($join) use ($tes){
                return $join->on($tes . '.siswa_id', '=', 'users.id');
            })->leftJoin($rekap_tes, function($join) use ($rekap_tes, $tes){
                return $join->on($rekap_tes . '.tes_id', '=', $tes . '.id');
            });
    }

    public function headings(): array
    {
        $firstRow = [ 
            'Siswa ID',
            'Email',
            'Nama',
            'Kelas',
            'Waktu Tes',
            'Tidak Dijawab',
        ];
        $secondRow = array_map(function($e){return '';}, $firstRow);
        foreach(\App\Services\CalculationOfConceptionCriteria::ALL_CRITERIA as $item){
            if($item['id'] == \App\Services\CalculationOfConceptionCriteria::CRITERIA_MC['id']){
                for($i = 0; $i < count(\App\Enums\TierFiveEnums::SEMUA) + 1; $i++){
                    $firstRow[] = $i == 0 ? $item['text'] : '';
                }
            }
            else $firstRow[] = $item['text'];
        }
        foreach(\App\Enums\TierFiveEnums::SEMUA as $item){
            $secondRow[] = ucfirst($item['conception_text']);
        }
        $secondRow[] = 'MC Total';
        return [
            $firstRow,
            $secondRow
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Rekap Siswa';
    }
}
