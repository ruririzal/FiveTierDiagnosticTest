<?php

namespace App\Exports;

use App\User;
use App\Exports\Sheets\UsersRekapTesSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\Sheets\UsersDetailTesSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersTesExport implements WithMultipleSheets
{
    use Exportable;
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new UsersRekapTesSheet();
        $all_siswa = User::select('id')->where('is_admin', 0)->get();
        foreach($all_siswa as $siswa){
            $sheets[] = new UsersDetailTesSheet($siswa);
        }

        return $sheets;
    }
}
