<?php

namespace App\Http\Requests\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class ShowOrderRequest extends FormRequest
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
            ''
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $order = Order::find($this->route('order'));
            if (!$order) {
                $validator->errors()->add('service', 'Order no encontrada');
            }
        });
    }
}
