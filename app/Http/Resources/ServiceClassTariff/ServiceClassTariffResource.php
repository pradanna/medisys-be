<?php

namespace App\Http\Resources\ServiceClassTariff;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceClassTariffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'payer_type' => $this->payer_type,
            'daily_rate' => $this->aily_rate,
        ];
        if ($this->relationLoaded('service_class')) {
            $data['service_class'] = $this->service_class ? [
                'id' => $this->service_class->id,
                'code' => $this->service_class->code,
                'name' => $this->service_class->name,
                'bpjs_class_code' => $this->service_class->bpjs_class_code,
            ] : null;
        }
        return $data;
    }
}
