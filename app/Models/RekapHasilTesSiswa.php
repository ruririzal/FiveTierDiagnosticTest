<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\CalculationOfConceptionCriteria;

class RekapHasilTesSiswa extends Model
{
    protected $table = 'rekap_hasil_tes_siswa';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'tes_id',
        'jumlah_tidak_dijawab',
        // constuct
    ];

    protected $cast = [

    ];
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    //merge $fillable with $stageGroupOfFields
    public function __construct(array $attributes = array())
    {
        $konsepsi = [];
        foreach(\App\Services\CalculationOfConceptionCriteria::ALL_CRITERIA as $item){
            $konsepsi[] = 'jumlah_' . $item['id'];
            $konsepsi[] = 'list_' . $item['id'];
            if($item['id'] == \App\Services\CalculationOfConceptionCriteria::CRITERIA_MC['id']){
                foreach(\App\Enums\TierFiveEnums::SEMUA_CAMELCASE() as $tier_five){
                    $konsepsi[] = 'jumlah_' . $item['id'] . '_'.  $tier_five;
                    $konsepsi[] = 'list_' . $item['id'] . '_'.  $tier_five;
                }
            }
        }   
        
        $this->fillable = array_merge(
            $this->fillable,
            $konsepsi
        );
        parent::__construct($attributes);
    }

    public function tes()
    {
        return $this->belongsTo(SiswaTes::class, 'tes_id');
    }
}
