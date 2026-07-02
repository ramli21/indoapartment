<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\DiscountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    protected DiscountService $discountService;

    /**
     * Inject the DiscountService.
     */
    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * Get price calculation details (including automatic global or unit discount)
     * when a user views a room or begins the booking process.
     *
     * GET /api/v1/rooms/{id}/calculate-price
     *
     * @param Request $request
     * @param string $roomId
     * @return JsonResponse
     */
    public function calculatePrice(Request $request, string $roomId): JsonResponse
    {
        $room = Room::find($roomId);

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak ditemukan.',
            ], 404);
        }

        // Validate number of nights
        $nights = (int) $request->query('nights', 1);
        if ($nights < 1) {
            $nights = 1;
        }

        $basePrice = (float) $room->harga_per_malam * $nights;

        // Calculate automatic discount (Unit discount or Global discount)
        $pricing = $this->discountService->calculateFinalPrice($roomId, $basePrice);

        return response()->json([
            'success' => true,
            'message' => 'Kalkulasi harga berhasil diambil.',
            'data' => [
                'room_id' => $room->id,
                'room_title' => $room->judul,
                'harga_per_malam' => (float) $room->harga_per_malam,
                'nights' => $nights,
                'original_price' => $pricing['original_price'],
                'discount_amount' => $pricing['discount_amount'],
                'applied_type' => $pricing['applied_type'],
                'final_price' => $pricing['final_price'],
            ]
        ]);
    }

    /**
     * Endpoint to validate and apply a voucher code in real-time.
     *
     * POST /api/v1/checkout/apply-voucher
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function applyVoucher(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|uuid|exists:rooms,id',
            'nights' => 'required|integer|min:1',
            'voucher_code' => 'required|string',
        ], [
            'room_id.required' => 'ID Kamar wajib diisi.',
            'room_id.exists' => 'Kamar tidak terdaftar dalam database.',
            'nights.required' => 'Jumlah malam wajib diisi.',
            'nights.min' => 'Jumlah malam minimal 1 malam.',
            'voucher_code.required' => 'Kode voucher wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $room = Room::find($request->input('room_id'));
        $nights = (int) $request->input('nights');
        $voucherCode = $request->input('voucher_code');

        $basePrice = (float) $room->harga_per_malam * $nights;

        // Perform calculation using priority: Voucher > Unit > Global
        $pricing = $this->discountService->calculateFinalPrice($room->id, $basePrice, $voucherCode);

        // Check if the voucher was successfully applied
        if ($pricing['applied_type'] !== 'Voucher') {
            $errorMsg = $pricing['voucher_error'] ?? 'Kode voucher tidak dapat digunakan.';
            return response()->json([
                'success' => false,
                'message' => $errorMsg,
                'data' => [
                    'original_price' => $pricing['original_price'],
                    'discount_amount' => $pricing['discount_amount'],
                    'applied_type' => $pricing['applied_type'],
                    'final_price' => $pricing['final_price'],
                ]
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil diterapkan.',
            'data' => [
                'original_price' => $pricing['original_price'],
                'discount_amount' => $pricing['discount_amount'],
                'applied_type' => $pricing['applied_type'],
                'final_price' => $pricing['final_price'],
            ]
        ]);
    }
}
