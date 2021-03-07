<?php

namespace App\Http\Controllers;

use App\Exports\UsersTesExport;
use App\User;
use App\Models\SiswaTes;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use App\Jobs\BuatRekapJawabanJob;
use App\Models\RekapHasilTesSiswa;

class HasilTesSiswaController extends Controller
{
    /**
     * Display a listing of the user with result tes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengaturan = Pengaturan::first() ?? Pengaturan::create(['durasi_menit'=> 120]);
        $all_siswa = User::where('is_admin', 0)->with(['tes', 'tes.rekapTesSiswa'])->paginate(10);

        foreach($all_siswa as $siswa){
            //jika waktu tes sudah lewat
            if($siswa->tes && $siswa->tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->lessThan(now()) && ! $siswa->tes->waktu_selesai){
                BuatRekapJawabanJob::dispatch($siswa->id);
            }
        }
        return view('siswa.index', compact('all_siswa'));
    }

    public function show(User $user)
    {
        $siswa = $user;
        return view('siswa.show', compact('siswa'));
    }

    public function destroy(SiswaTes $siswa)
    {
        $siswa->delete();
        return redirect()->back()->with('message', "Tes Berhasil Dihapus");
    }

    public function download()
    {
        return (new UsersTesExport)->download('hasil_tes_siswa.xlsx');
    }
}
