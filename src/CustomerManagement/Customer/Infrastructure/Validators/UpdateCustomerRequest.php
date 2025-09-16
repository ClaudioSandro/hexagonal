<?php

namespace Src\CustomerManagement\Customer\Infrastructure\Validators;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|min:3|max:100',
            'email' => 'sometimes|email|unique:customers,email,' . $this->route('id'),
        ];
    }
}
