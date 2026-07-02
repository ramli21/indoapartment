<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // Assuming admin middleware handles admin check
    }

    public function rules(): array
    {
        return [
            'room_id' => 'nullable|uuid|exists:rooms,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:percentage,fixed',
            'value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $type = $this->input('type');
                    
                    if ($type === 'percentage') {
                        if ($value > 100) {
                            $fail('Persentase diskon tidak boleh melebihi 100%.');
                        }
                    } elseif ($type === 'fixed') {
                        $roomId = $this->input('room_id');
                        if ($roomId) {
                            $room = \App\Models\Room::find($roomId);
                            if ($room && $value > $room->harga_per_malam) {
                                $fail('Nominal diskon tidak boleh melebihi harga kamar per malam (Rp ' . number_format($room->harga_per_malam, 0, ',', '.') . ').');
                            }
                        }
                    }
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'room_id.uuid' => 'Format ID Kamar tidak valid.',
            'room_id.exists' => 'Kamar tidak ditemukan.',
            'name.required' => 'Nama diskon wajib diisi.',
            'type.required' => 'Tipe diskon wajib dipilih.',
            'type.in' => 'Tipe diskon harus percentage atau fixed.',
            'value.required' => 'Nilai diskon wajib diisi.',
            'value.numeric' => 'Nilai diskon harus berupa angka.',
            'value.min' => 'Nilai diskon tidak boleh negatif.',
            'start_date.required' => 'Tanggal mulai diskon wajib diisi.',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.required' => 'Tanggal selesai diskon wajib diisi.',
            'end_date.date' => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh mendahului tanggal mulai.',
        ];
    }
}
