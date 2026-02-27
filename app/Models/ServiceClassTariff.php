<?php

namespace App\Models;

use App\Enums\ServiceClassTariffPayerType;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceClassTariff extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'service_class_id',
        'payer_type',
        'daily_rate'
    ];

    protected $casts = [
        'daily_rate' => 'float',
        'payer_type' => ServiceClassTariffPayerType::class
    ];

    public function service_class()
    {
        return $this->belongsTo(ServiceClass::class, 'service_class_id');
    }
}
