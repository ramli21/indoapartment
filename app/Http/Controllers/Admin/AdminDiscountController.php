<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Discount;
use Illuminate\Http\JsonResponse;

class AdminDiscountController extends Controller
{
    /**
     * Store a newly created discount (global or room-specific) in storage.
     *
     * POST /api/v1/admin/discounts
     *
     * @param StoreDiscountRequest $request
     * @return JsonResponse
     */
    public function store(StoreDiscountRequest $request): JsonResponse
    {
        $discount = Discount::create($request->validated());

        $message = $discount->room_id 
            ? 'Diskon spesifik unit kamar berhasil dibuat.' 
            : 'Diskon global berhasil dibuat.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $discount,
        ], 201);
    }

    /**
     * Update the specified discount (global or room-specific) in storage.
     *
     * PUT/PATCH /api/v1/admin/discounts/{discount}
     *
     * @param UpdateDiscountRequest $request
     * @param Discount $discount
     * @return JsonResponse
     */
    public function update(UpdateDiscountRequest $request, Discount $discount): JsonResponse
    {
        $discount->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi diskon berhasil diperbarui.',
            'data' => $discount,
        ]);
    }
}
