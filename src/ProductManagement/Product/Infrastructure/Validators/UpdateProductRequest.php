<?php

namespace Src\ProductManagement\Product\Infrastructure\Validators;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|min:3',
            'price' => 'sometimes|numeric|min:0',
            'category' => 'sometimes|string',
        ];
    }
}
