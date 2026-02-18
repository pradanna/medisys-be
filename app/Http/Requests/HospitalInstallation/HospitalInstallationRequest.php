<?php

namespace App\Http\Requests\HospitalInstallation;

use App\DTOs\HospitalInstallation\HospitalInstallationRequestSchema;
use Illuminate\Foundation\Http\FormRequest;

class HospitalInstallationRequest extends FormRequest
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
            'code' => 'string|required|max:20|unique:hospital_installations,code,' . $id,
            'name' => 'string|required',
            'is_active' => 'boolean|required'
        ];
    }

    public function toSchema(): HospitalInstallationRequestSchema
    {
        return new HospitalInstallationRequestSchema(
            code: $this->validated('code'),
            name: $this->validated('name'),
            isActive: $this->validated('is_active')
        );
    }
}
