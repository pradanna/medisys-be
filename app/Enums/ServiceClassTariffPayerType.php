<?php

namespace App\Enums;

enum ServiceClassTariffPayerType: string
{
    case GENERAL = 'general';
    case BPJS = 'bpjs';
    case INSURANCE = 'insurance';
    case CORPORATE = 'corporate';
    public function label(): string
    {
        return match ($this) {
            self::GENERAL => 'Umum',
            self::BPJS => 'BPJS',
            self::INSURANCE => 'Asuransi',
            self::CORPORATE => 'Corporate',
        };
    }
}
