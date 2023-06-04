<?php

namespace App\Jobs;

use App\Models\SimulasiSoal;
use App\Models\SimulasiSiswaTes;
use Illuminate\Bus\Queueable;
use App\Models\SimulasiRekapHasilTesSiswa;
use Illuminate\Support\Facades\DB;
use App\Models\SimulasiJawabanSiswaPerSoal;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\CalculationOfConceptionCriteria;

class BuatRekapJawabanSimulasiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $siswa_id;
    protected $konsepsi_variable = [];
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $siswa_id)
    {
        $this->siswa_id = $siswa_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tes = SimulasiSiswaTes::where('siswa_id', $this->siswa_id)->first();
        if($tes){
            $jumlah_soal = SimulasiSoal::where('is_aktif', 1)->count();
            $jumlah_dijawab = SimulasiJawabanSiswaPerSoal::with([
                'soal:id',
                'soal.jawaban' => function($query){
                    return $query->select(['id','is_benar','soal_id'])->where('is_benar', 1);
                },
                'soal.alasanJawaban' => function($query){
                    return $query->select(['id','is_benar','soal_id'])->where('is_benar', 1);
                },
            ])->where(['tes_id' => $tes->id, 'siswa_id' => $this->siswa_id])->get();

            foreach(CalculationOfConceptionCriteria::ALL_CRITERIA as $item){
                $this->konsepsi_variable['jumlah_' . $item['id']] = 0;
                $this->konsepsi_variable['list_' . $item['id']] = [];
                if($item['id'] == CalculationOfConceptionCriteria::CRITERIA_MC['id']){
                    foreach(\App\Enums\TierFiveEnums::SEMUA_CAMELCASE() as $tier_five){
                        $this->konsepsi_variable['jumlah_' . $item['id'] . '_'.  $tier_five] = 0;
                        $this->konsepsi_variable['list_' . $item['id'] . '_'.  $tier_five] = [];
                    }
                }
            }

            $jumlah_dijawab->each(function($item, $key) {
                $tier_1 = $item->soal->jawaban->contains('id', $item->jawaban_id) ?? false;
                $tier_2 = $item->is_jawaban_yakin ?? false;
                $tier_3 = $item->soal->alasanJawaban->contains('id', $item->alasan_jawaban_soal_id) ?? false;
                $tier_4 = $item->is_alasan_yakin ?? false;
                $tier_5 = $item->tier_five ?? false;

                list($criteria, $conception)  = (new CalculationOfConceptionCriteria())->get($tier_1, $tier_2, $tier_3, $tier_4, $tier_5);

                $this->konsepsi_variable['jumlah_' . $criteria['id']]++;
                $this->konsepsi_variable['list_' . $criteria['id']][] = $item->urutan_soal_tes;

                if($criteria == CalculationOfConceptionCriteria::CRITERIA_MC){
                    $this->konsepsi_variable['jumlah_' . $criteria['id'] . '_' .  $tier_5]++;
                    $this->konsepsi_variable['list_' . $criteria['id'] . '_' .  $tier_5][] = $item->urutan_soal_tes;
                }
            });

            foreach(CalculationOfConceptionCriteria::ALL_CRITERIA as $item){
                $this->konsepsi_variable['list_' . $item['id']] = implode(',', $this->konsepsi_variable['list_' . $item['id']]);
                if($item == CalculationOfConceptionCriteria::CRITERIA_MC){
                    foreach(\App\Enums\TierFiveEnums::SEMUA_CAMELCASE() as $tier_five){
                        $this->konsepsi_variable['list_' . $item['id'] . '_'.  $tier_five] = implode(',', $this->konsepsi_variable['list_' . $item['id'] . '_'.  $tier_five]);
                    }
                }
            }

            $data = array_merge(
                [ 'jumlah_tidak_dijawab' => $jumlah_soal - $jumlah_dijawab->count(),],
                $this->konsepsi_variable
            );

            DB::beginTransaction();

            SimulasiRekapHasilTesSiswa::updateOrCreate(
                ['tes_id' => $tes->id],
                $data
            );

            $tes->update(['waktu_selesai' => \Carbon\Carbon::now()]);

            DB::commit();
        }
    }
}
