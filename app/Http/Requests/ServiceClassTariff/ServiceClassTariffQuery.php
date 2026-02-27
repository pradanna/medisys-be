<?php

namespace App\Http\Requests\ServiceClassTariff;

use App\DTOs\ServiceClass\ServiceClassQuerySchema;
use App\DTOs\ServiceClassTariff\ServiceClassTariffQuerySchema;
use Illuminate\Foundation\Http\FormRequest;

class ServiceClassTariffQuery extends FormRequest
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
            'service_class_id' => 'nullable|string',
            'page' => 'nullable|integer|min:1|max:100',
            'per_page' => 'nullable|integer|min:1|max:100',
            'sort_by' => 'nullable|in:daily_rate,created_at',
            'order' => 'nullable|in:asc,desc',
        ];
    }

    public function toFilter(): ServiceClassTariffQuerySchema
    {
        return new ServiceClassTariffQuerySchema(
            search: $this->search,
            serviceClassId: $this->service_class_id,
            page: (int) ($this->page ?? 1),
            perPage: (int) ($this->per_page ?? 15),
            sortBy: $this->sort_by ?? 'created_at',
            order: $this->order ?? 'desc'
        );
    }
}
