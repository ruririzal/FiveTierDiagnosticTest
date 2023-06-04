<?php

use App\Models\Pengaturan;
use App\Models\SimulasiSoal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSimulationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            DB::transaction(function () {
                Pengaturan::firstOrCreate(['id'=>1], ['durasi_menit_simulasi' => 5]);

                for($i = 1; $i <= 3; $i++){
                    $soal = SimulasiSoal::create([
                        'is_aktif' => true,
                        'teks' => 'Ini soal simulasi ' . $i,
                    ]);

                    $all_jawaban = [
                        ['teks' => 'Ini jawaban benar ' . $i, 'is_benar' => true],
                        ['teks' => 'Ini jawaban salah' . $i, 'is_benar' => false],
                    ];

                    $all_alasan = [
                        ['teks' => 'Ini alasan benar ' . $i, 'is_benar' => true],
                        ['teks' => 'Ini alasan salah' . $i, 'is_benar' => false],
                    ];

                    $soal->jawaban()->createMany($all_jawaban);
                    $soal->alasanJawaban()->createMany($all_alasan);
                }

            });
        }catch(Exception $ex){
            Log::error($ex->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
