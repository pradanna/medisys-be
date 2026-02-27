<?php

namespace App\Http\Requests\ServiceClassTariff;

use App\DTOs\ServiceClassTariff\ServiceClassTariffRequestSchema;
use App\Enums\ServiceClassTariffPayerType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ServiceClassTariffRequest extends FormRequest
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
            'service_class_id' => 'string|required|uuid',
            'payer_type' => [
                'string',
                'required',
                new Enum(ServiceClassTariffPayerType::class)
            ],
            'daily_rate' => 'numeric|required'
        ];
    }

    public function toSchema(): ServiceClassTariffRequestSchema
    {
        return new ServiceClassTariffRequestSchema(
            serviceClassId: $this->validated('service_class_id'),
            payerType: $this->validated('payer_type'),
            dailyRate: $this->validated('daily_rate')
        );
    }
}
