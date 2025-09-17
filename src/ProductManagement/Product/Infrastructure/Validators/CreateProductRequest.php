<?php

namespace Src\ProductManagement\Product\Infrastructure\Validators;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
        ];
    }
}
