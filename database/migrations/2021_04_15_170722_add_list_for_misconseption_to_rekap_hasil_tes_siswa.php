<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListForMisconseptionToRekapHasilTesSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekap_hasil_tes_siswa', function (Blueprint $table) {
            foreach(\App\Services\CalculationOfConceptionCriteria::ALL_CRITERIA as $item){

                if($item == \App\Services\CalculationOfConceptionCriteria::CRITERIA_MC){
                    foreach(\App\Enums\TierFiveEnums::SEMUA_CAMELCASE() as $tier_five){
                        $table->text('list_' .  $item['id'] . '_' . $tier_five);
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekap_hasil_tes_siswa', function (Blueprint $table) {
            //
        });
    }
}
