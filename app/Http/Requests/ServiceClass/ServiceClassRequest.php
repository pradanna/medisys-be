<?php

namespace App\Http\Requests\ServiceClass;

use App\DTOs\ServiceClass\ServiceClassRequestSchema;
use Illuminate\Foundation\Http\FormRequest;

class ServiceClassRequest extends FormRequest
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
            'code' => 'string|required|max:20|unique:service_classes,code,' . $id,
            'name' => 'string|required',
            'bpjs_class_code' => 'nullable|string',
        ];
    }

    public function toSchema(): ServiceClassRequestSchema
    {
        return new ServiceClassRequestSchema(
            code: $this->validated('code'),
            name: $this->validated('name'),
            bpjsClassCode: $this->validated('bpjs_class_code')
        );
    }
}
