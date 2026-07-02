<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Models\Voucher;
use Illuminate\Http\JsonResponse;

class AdminVoucherController extends Controller
{
    /**
     * Store a newly created voucher in storage.
     *
     * POST /api/v1/admin/vouchers
     *
     * @param StoreVoucherRequest $request
     * @return JsonResponse
     */
    public function store(StoreVoucherRequest $request): JsonResponse
    {
        $voucher = Voucher::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kode voucher baru berhasil dibuat.',
            'data' => $voucher,
        ], 201);
    }

    /**
     * Update the specified voucher in storage.
     *
     * PUT/PATCH /api/v1/admin/vouchers/{voucher}
     *
     * @param UpdateVoucherRequest $request
     * @param Voucher $voucher
     * @return JsonResponse
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher): JsonResponse
    {
        $voucher->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Detail kode voucher berhasil diperbarui.',
            'data' => $voucher,
        ]);
    }
}
