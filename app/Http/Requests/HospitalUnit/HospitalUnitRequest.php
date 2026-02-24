<?php

namespace App\Http\Requests\HospitalUnit;

use App\DTOs\HospitalUnit\HospitalUnitRequestSchema;
use App\Enums\HospitalUnitType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class HospitalUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'code' => 'string|required|max:20|unique:hospital_units,code,' . $id,
            'hospital_installation_id' => 'string|required|uuid',
            'name' => 'string|required',
            'type' => [
                'string',
                'required',
                new Enum(HospitalUnitType::class)
            ],
            'is_active' => 'boolean|required'
        ];
    }

    public function toSchema(): HospitalUnitRequestSchema
    {
        return new HospitalUnitRequestSchema(
            code: $this->validated('code'),
            hospitalInstallationId: $this->validated('hospital_installation_id'),
            name: $this->validated('name'),
            type: $this->validated('type'),
            isActive: $this->validated('is_active')
        );
    }
}
