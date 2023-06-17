<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SiswaTes;
use App\Models\Pengaturan;
use App\Enums\TierFiveEnums;
use App\Models\SimulasiSoal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SimulasiSiswaTes;
use App\Jobs\BuatRekapJawabanSimulasiJob;
use App\Models\SimulasiJawabanSiswaPerSoal;

class SimulasiController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first() ?? Pengaturan::create(['durasi_menit'=> 120, 'durasi_menit_simulasi_simulasi' => 5]);

        $tes = SimulasiSiswaTes::where('siswa_id', auth()->id())->first();

        $jumlah_soal = SimulasiSoal::where('is_aktif', 1)->count();

        $soal = [];
        if($tes){
            //jika tes sedang berlangsung
            if($tes->waktu_mulai->addMinutes($pengaturan->durasi_menit_simulasi)->greaterThan(now()) && ! $tes->waktu_selesai){
                $soal = SimulasiSoal::select('id', 'teks')
                    ->with('jawaban:teks,id,soal_id', 'alasanJawaban:teks,id,soal_id')
                    ->where('is_aktif', 1)
                    ->get()
                    ;
                $tes->load('jawabanSiswa');
                $tes->jawaban_siswa = $tes->jawabanSiswa->mapWithKeys(function($item){
                    return [$item->soal_id => $item];
                });
            //jika waktu tes sudah lewat
            }elseif($tes->waktu_mulai->addMinutes($pengaturan->durasi_menit_simulasi)->lessThan(now()) && ! $tes->waktu_selesai){
                BuatRekapJawabanSimulasiJob::dispatch(auth()->id());
                return redirect()->route('simulasi');
            }else{
                $tes->load('rekapTesSiswa');
            }
        }

        return view('simulasi.index', compact('pengaturan', 'tes', 'jumlah_soal', 'soal'));
    }

    public function mulai()
    {
        $tes = SimulasiSiswaTes::where('siswa_id', auth()->id())->first();
        if(!$tes){
            $tes = SimulasiSiswaTes::create([
                'siswa_id' => auth()->id(),
                'waktu_mulai' => now(),
            ]);
        }else{
            $tes->update([
                'waktu_mulai' => now(),
                'waktu_selesai' => null,
            ]);
        }

        return redirect()->route('tes_simulasi');
    }

    public function simpanJawaban(Request $request)
    {
        $tes = SimulasiSiswaTes::where('siswa_id', auth()->id())->firstOrFail();

        $validated = $request->validate([
            'urutan_soal_tes' => [
                'required', 'numeric', 'min:0'
            ],
            'soal_id' => [
                'required',
                Rule::exists('s_soal','id')->where('is_aktif', 1),
            ],
            'jawaban_id' => [
                'required_without_all:is_jawaban_yakin,alasan_jawaban_soal_id,is_alasan_yakin,tier_five',
                Rule::exists('s_jawaban','id')->where('soal_id', $request->soal_id),
            ],
            'is_jawaban_yakin' => [
                'required_without_all:jawaban_id,alasan_jawaban_soal_id,is_alasan_yakin,tier_five',
                'in:0,1'
            ],
            'alasan_jawaban_soal_id' => [
                'required_without_all:jawaban_id,is_jawaban_yakin,is_alasan_yakin,tier_five',
                Rule::exists('s_alasan_jawaban_soal','id')->where('soal_id', $request->soal_id),
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

        $validated['siswa_id']  = auth()->id();
        $validated['tes_id']    = $tes->id;

        $jawaban_siswa = SimulasiJawabanSiswaPerSoal::where('tes_id', $tes->id)
            ->where('soal_id', $request->soal_id)
            ->first();

        if(empty($jawaban_siswa)){
            $jawaban_siswa = SimulasiJawabanSiswaPerSoal::create($validated);
        }else{
            $jawaban_siswa->update(
                $validated
            );
        }
        $response_jawaban_siswa['tier_1'] = $jawaban_siswa->jawaban_id;
        $response_jawaban_siswa['tier_2'] = $jawaban_siswa->is_jawaban_yakin;
        $response_jawaban_siswa['tier_3'] = $jawaban_siswa->alasan_jawaban_soal_id;
        $response_jawaban_siswa['tier_4'] = $jawaban_siswa->is_alasan_yakin;
        $response_jawaban_siswa['tier_5'] = $jawaban_siswa->tier_five;

        $belum_dijawab = $this->getJumlahBelumDijawab();

        if($jawaban_siswa){
            return response()->json(['status' => 'success', 'belum_dijawab' => $belum_dijawab, 'jawaban_siswa' => $response_jawaban_siswa]);
        }else{
            return response()->json(['status' => 'fail', 'belum_dijawab' => $belum_dijawab, 'jawaban_siswa' => $response_jawaban_siswa]);
        }
    }

    public function selesaiTes(Request $request)
    {
        $belum_dijawab = $this->getJumlahBelumDijawab();

        if($belum_dijawab == 0 || $request->force ?? false){
            BuatRekapJawabanSimulasiJob::dispatch(auth()->id());
            return redirect()->back();
        }else{
            return redirect()->back()->with('message', $belum_dijawab . ' Simulasi Soal belum dijawab');
        }
    }

    private function getJumlahBelumDijawab()
    {
        $jumlah_soal = SimulasiSoal::where('is_aktif', 1)->count();
        $jumlah_dijawab = SimulasiJawabanSiswaPerSoal::where('siswa_id', auth()->id())->count();
        return  $jumlah_soal - $jumlah_dijawab;
    }
}
