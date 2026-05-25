<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentConfigRequest extends FormRequest
{
    public function authorize()
    {
        // Adjust authorization as needed (e.g., check admin)
        return auth()->check();
    }

    public function rules()
    {
        return [
            'provider_name' => 'nullable|string|max:50',
            'merchant_id' => 'required|string|max:255',
            'client_id' => 'required|string|max:1000',
            'shared_key' => 'required|string|max:2000',
            'is_production' => 'nullable|boolean',
        ];
    }
}
