<?php

namespace App\Http\Resources\HospitalUnit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalUnitResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'is_active' => $this->is_active
        ];
        if ($this->relationLoaded('hospital_installation')) {
            $data['hospital_installation'] = $this->hospital_installation ? [
                'id' => $this->hospital_installation->id,
                'code' => $this->hospital_installation->code,
                'name' => $this->hospital_installation->name,
            ] : null;
        }
        return $data;
    }
}
