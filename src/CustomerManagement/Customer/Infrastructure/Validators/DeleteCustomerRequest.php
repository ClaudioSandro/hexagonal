<?php

namespace Src\CustomerManagement\Customer\Infrastructure\Validators;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $customerId = $this->route('customer');
            Log::info('Customer ID from route: ' . $customerId);

            if (!$customerId) {
                $validator->errors()->add('id', 'No se pudo obtener el ID del cliente.');
                return;
            }
            
            try {
                $exists = Customer::where('id', $customerId)->exists();
                Log::info('¿Cliente existe?: ' . ($exists ? 'Sí' : 'No'));
                
                if (!$exists) {
                    $validator->errors()->add(
                        'customer', 
                        "Cliente con ID {$customerId} no encontrado."
                    );
                    return;
                }

                $activeOrders = Order::where('customer_id', $customerId)
                    ->whereNotIn('status', ['completed', 'declined'])
                    ->count();
                
                Log::info('Número de órdenes activas: ' . $activeOrders);

                if ($activeOrders > 0) {
                    $validator->errors()->add(
                        'customer', 
                        'No se puede eliminar el cliente porque tiene órdenes pendientes o en proceso.'
                    );
                }
            } catch (\Exception $e) {
                Log::error('Error al validar cliente: ' . $e->getMessage());
                $validator->errors()->add(
                    'customer',
                    'Error al validar el cliente: ' . $e->getMessage()
                );
            }
        });
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'success' => false
            ], 422)
        );
    }
}