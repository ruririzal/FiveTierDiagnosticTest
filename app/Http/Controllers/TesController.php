<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Soal;
use App\Models\SiswaTes;
use App\Models\Pengaturan;
use App\Enums\TierFiveEnums;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Jobs\BuatRekapJawabanJob;
use App\Models\JawabanSiswaPerSoal;

class TesController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first() ?? Pengaturan::create(['durasi_menit'=> 120]);
        
        $tes = SiswaTes::where('siswa_id', auth()->id())->first();
        
        $jumlah_soal = Soal::where('is_aktif', 1)->count();
        
        $soal = [];
        if($tes){
            //jika tes sedang berlangsung
            if($tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->greaterThan(now()) && ! $tes->waktu_selesai){
                $soal = Soal::select('id', 'teks')
                    ->with('jawaban:teks,id,soal_id', 'alasanJawaban:teks,id,soal_id')
                    ->where('is_aktif', 1)
                    ->get()
                    ;
                $tes->load('jawabanSiswa');
                $tes->jawaban_siswa = $tes->jawabanSiswa->mapWithKeys(function($item){
                    return [$item->soal_id => $item];
                });
            //jika waktu tes sudah lewat
            }elseif($tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->lessThan(now()) && ! $tes->waktu_selesai){
                BuatRekapJawabanJob::dispatch(auth()->id());
                return redirect()->route('tes');
            }else{
                $tes->load('rekapTesSiswa');
            }
        }

        return view('tes.index', compact('pengaturan', 'tes', 'jumlah_soal', 'soal'));
    }

    public function mulai()
    {
        $tes = SiswaTes::where('siswa_id', auth()->id())->firstOrCreate([
            'siswa_id' => auth()->id(),
            'waktu_mulai' => now(),
        ]);
        
        return redirect()->route('tes');
    }

    public function simpanJawaban(Request $request)
    {
        $tes = SiswaTes::where('siswa_id', auth()->id())->first();
        
        $request->validate([
            'tes_id' => [
                'required', 'in:'.$tes->id
            ],
            'soal_id' => [
                'required', 
                Rule::exists('soal','id')->where('is_aktif', 1),
            ],
            'jawaban_id' => [
                'required_without_all:is_jawaban_yakin,alasan_jawaban_soal_id,is_alasan_yakin,tier_five',
                Rule::exists('jawaban','id')->where('soal_id', $request->soal_id),
            ],
            'is_jawaban_yakin' => [
                'required_without_all:jawaban_id,alasan_jawaban_soal_id,is_alasan_yakin,tier_five',
                'in:0,1'
            ],
            'alasan_jawaban_soal_id' => [
                'required_without_all:jawaban_id,is_jawaban_yakin,is_alasan_yakin,tier_five',
                Rule::exists('alasan_jawaban_soal','id')->where('soal_id', $request->soal_id),
            ],
            'is_alasan_yakin' => [
                'required_without_all:jawaban_id,is_jawaban_yakin,alasan_jawaban_soal_id,tier_five',
                'in:0,1'
            ],
            'tier_five' => [
                'required_without_all:jawaban_id,is_jawaban_yakin,alasan_jawaban_soal_id,is_alasan_yakin',
                'in:'.implode(',', TierFiveEnums::SEMUA_ID)
            ],
        ]);

        $jawaban_siswa = JawabanSiswaPerSoal::updateOrCreate(
            $request->only(['tes_id', 'soal_id', 'jawaban_id']),
            $request->all()
        );

        $belum_dijawab = $this->getJumlahBelumDijawab();
        
        if($jawaban_siswa){
            return response()->json(['status' => 'success', 'belum_dijawab' => $belum_dijawab]);
        }else{
            return response()->json(['status' => 'fail', 'belum_dijawab' => $belum_dijawab]);
        }
    }

    public function selesaiTes(Request $request)
    {
        $belum_dijawab = $this->getJumlahBelumDijawab();
        
        if($belum_dijawab == 0 || $request->force ?? false){
            BuatRekapJawabanJob::dispatch(auth()->id());
            return redirect()->back();
        }else{
            return redirect()->back()->with('message', $belum_dijawab . ' Soal belum dijawab');
        }
    }

    private function getJumlahBelumDijawab()
    {
        $jumlah_soal = Soal::where('is_aktif', 1)->count();
        $jumlah_dijawab = JawabanSiswaPerSoal::where('siswa_id', auth()->id())->count();
        return  $jumlah_soal - $jumlah_dijawab;
    }
}
