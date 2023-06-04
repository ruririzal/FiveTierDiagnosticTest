<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSRekapHasilTesSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_rekap_hasil_tes_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tes_id');
            $table->foreign('tes_id', 's_tes_id_rhts')->references('id')->on('s_siswa_tes')->onDelete('cascade');
            $table->unsignedBigInteger('jumlah_tidak_dijawab');

            foreach(\App\Services\CalculationOfConceptionCriteria::ALL_CRITERIA as $item){
                $table->text('list_' .  $item['id']);
                $table->unsignedBigInteger('jumlah_' . $item['id']);

                if($item['id'] == \App\Services\CalculationOfConceptionCriteria::CRITERIA_MC['id']){
                    foreach(\App\Enums\TierFiveEnums::SEMUA_CAMELCASE() as $tier_five){
                        $table->unsignedBigInteger('jumlah_' . $item['id'] . '_'.  $tier_five);
                    }
                }
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_rekap_hasil_tes_siswa');
    }
}
