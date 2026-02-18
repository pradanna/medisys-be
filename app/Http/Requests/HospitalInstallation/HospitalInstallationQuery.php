<?php

namespace App\Http\Requests\HospitalInstallation;

use App\DTOs\HospitalInstallation\HospitalInstallationQuerySchema;
use Illuminate\Foundation\Http\FormRequest;

class HospitalInstallationQuery extends FormRequest
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
            'is_active' => 'nullable|boolean',
            'page' => 'nullable|integer|min:1|max:100',
            'per_page' => 'nullable|integer|min:1|max:100',
            'sort_by' => 'nullable|in:name,code,created_at',
            'order' => 'nullable|in:asc,desc',
        ];
    }

    public function toFilter(): HospitalInstallationQuerySchema
    {
        return new HospitalInstallationQuerySchema(
            search: $this->search,
            isActive: $this->has('is_active') ? $this->boolean('is_active') : null,
            page: (int) ($this->page ?? 1),
            perPage: (int) ($this->per_page ?? 15),
            sortBy: $this->sort_by ?? 'created_at',
            order: $this->order ?? 'desc'
        );
    }
}
