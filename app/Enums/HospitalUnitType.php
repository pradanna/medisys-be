<?php

namespace App\Enums;

enum HospitalUnitType: string
{
    case CLINIC = 'clinic';
    case LABORATORY = 'laboratory';
    case EMERGENCY = 'emergency';
    case PHARMACY = 'pharmacy';
    case WARD = 'ward';

    public function label(): string
    {
        return match($this) {
            self::CLINIC => 'Klinik',
            self::LABORATORY => 'Laboratorium',
            self::EMERGENCY => 'IGD',
            self::PHARMACY => 'Farmasi',
            self::WARD => 'Bangsal',
        };
    }
}
