<?php

namespace App\Http\Requests\HospitalUnit;

use App\DTOs\HospitalUnit\HospitalUnitQuerySchema;
use Illuminate\Foundation\Http\FormRequest;

class HospitalUnitQuery extends FormRequest
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
        return [
            'search' => 'nullable|string|max:100',
            'hospital_installation_id' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'page' => 'nullable|integer|min:1|max:100',
            'per_page' => 'nullable|integer|min:1|max:100',
            'sort_by' => 'nullable|in:name,code,created_at',
            'order' => 'nullable|in:asc,desc',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->filled('is_active')) {
            $this->merge([
                'is_active' => $this->boolean('is_active'),
            ]);
        } else {
            $this->merge([
                'is_active' => null,
            ]);
        }
    }

    public function toFilter(): HospitalUnitQuerySchema
    {
        return new HospitalUnitQuerySchema(
            search: $this->search,
            hospitalInstallationId: $this->hospital_installation_id,
            isActive: $this->is_active,
            page: (int) ($this->page ?? 1),
            perPage: (int) ($this->per_page ?? 15),
            sortBy: $this->sort_by ?? 'created_at',
            order: $this->order ?? 'desc'
        );
    }
}
