<?php

namespace App\Services;

use \App\Enums\TierFiveEnums;

class CalculationOfConceptionCriteria
{
    const CRITERIA_MC = ['id' => 'mc','text' => 'Misconception'];
    const CRITERIA_SU = ['id' => 'su','text' => 'Sound Understanding'];
    const CRITERIA_PU = ['id' => 'pu','text' => 'Partial Understanding'];
    const CRITERIA_NU = ['id' => 'nu','text' => 'No Understanding'];
    const CRITERIA_NC = ['id' => 'nc','text' => 'No Coding'];
    
    const ALL_CRITERIA = [
        self::CRITERIA_MC,
        self::CRITERIA_SU,
        self::CRITERIA_PU,
        self::CRITERIA_NU,
        self::CRITERIA_NC,
    ];

    protected $tier_1, $tier_2, $tier_3, $tier_4;

    /**
     * @param bool $tier_1
     * @param bool $tier_2
     * @param bool $tier_3
     * @param bool $tier_4
     * @param \App\Enums\TierFiveEnums $tier_5
     * @return mixed [criteria, conception_code]
     */
    public function get(bool $tier_1, bool $tier_2, bool $tier_3, bool $tier_4, $tier_5)
    {
        $this->tier_1 = $tier_1;
        $this->tier_2 = $tier_2;
        $this->tier_3 = $tier_3;
        $this->tier_4 = $tier_4;

        $tier_five = collect(TierFiveEnums::SEMUA)->where('id', $tier_5)->first();
 
        $conception_level = [null, $tier_five];

        $conception_level[0] = 
            $this->checkTier(0,1,0,1) ? self::CRITERIA_MC : (
            $this->checkTier(1,1,1,1) ? self::CRITERIA_SU : (
            (
                $this->checkTier(1,1,1,0) ||
                $this->checkTier(1,0,1,1) ||
                $this->checkTier(1,0,1,0) ||
                $this->checkTier(1,1,0,1) ||
                $this->checkTier(1,1,0,0) ||
                $this->checkTier(1,0,0,1) ||
                $this->checkTier(1,0,0,0) ||
                $this->checkTier(0,1,1,1) ||
                $this->checkTier(0,1,1,0) ||
                $this->checkTier(0,0,1,1) ||
                $this->checkTier(0,0,1,0)
            ) ? self::CRITERIA_PU : (
            (
                $this->checkTier(0,1,0,0) ||
                $this->checkTier(0,0,0,1) ||
                $this->checkTier(0,0,0,0)
            )
            ? self::CRITERIA_NU : '')));
        
        return $conception_level;
    }

    private function checkTier($tier_1, $tier_2, $tier_3, $tier_4)
    {
        return ($tier_1 == $this->tier_1 && $tier_2 == $this->tier_2 && $tier_3 == $this->tier_3 && $tier_4 == $this->tier_4);
    }
}