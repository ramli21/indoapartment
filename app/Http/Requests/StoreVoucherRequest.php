<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50|unique:vouchers,code',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:percentage,fixed',
            'value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($this->input('type') === 'percentage' && $value > 100) {
                        $fail('Persentase diskon voucher tidak boleh melebihi 100%.');
                    }
                }
            ],
            'min_booking_amount' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode voucher wajib diisi.',
            'code.unique' => 'Kode voucher ini sudah digunakan.',
            'name.required' => 'Nama voucher wajib diisi.',
            'type.required' => 'Tipe voucher wajib dipilih.',
            'type.in' => 'Tipe voucher harus percentage atau fixed.',
            'value.required' => 'Nilai diskon voucher wajib diisi.',
            'value.numeric' => 'Nilai diskon voucher harus berupa angka.',
            'value.min' => 'Nilai diskon voucher tidak boleh bernilai negatif.',
            'min_booking_amount.required' => 'Minimal nominal booking wajib diisi.',
            'min_booking_amount.min' => 'Minimal nominal booking tidak boleh bernilai negatif.',
            'max_uses.integer' => 'Maksimal penggunaan harus berupa bilangan bulat.',
            'max_uses.min' => 'Maksimal penggunaan minimal 1 kali.',
            'start_date.required' => 'Tanggal mulai voucher wajib diisi.',
            'end_date.required' => 'Tanggal selesai voucher wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh mendahului tanggal mulai.',
        ];
    }
}
