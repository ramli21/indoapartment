<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Models\Discount;
use App\Models\Voucher;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DiscountWebController extends Controller
{
    /**
     * Display a listing of discounts (global & unit-specific) and vouchers.
     */
    public function index(): View
    {
        $vouchers = Voucher::orderBy('created_at', 'desc')->get();
        $unitDiscounts = Discount::whereNotNull('room_id')->with('room')->orderBy('created_at', 'desc')->get();
        $globalDiscounts = Discount::whereNull('room_id')->orderBy('created_at', 'desc')->get();
        $rooms = Room::orderBy('judul', 'asc')->get(['id', 'judul', 'harga_per_malam']);

        return view('admin.discounts.index', compact('vouchers', 'unitDiscounts', 'globalDiscounts', 'rooms'));
    }

    /**
     * Store a newly created discount (global or unit-specific).
     */
    public function storeDiscount(StoreDiscountRequest $request): RedirectResponse
    {
        Discount::create($request->validated());

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Diskon baru berhasil ditambahkan.');
    }

    /**
     * Update the specified discount in database.
     */
    public function updateDiscount(UpdateDiscountRequest $request, Discount $discount): RedirectResponse
    {
        $discount->update($request->validated());

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Konfigurasi diskon berhasil diperbarui.');
    }

    /**
     * Remove the specified discount from database.
     */
    public function destroyDiscount(Discount $discount): RedirectResponse
    {
        $discount->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Konfigurasi diskon berhasil dihapus.');
    }

    /**
     * Store a newly created voucher.
     */
    public function storeVoucher(StoreVoucherRequest $request): RedirectResponse
    {
        Voucher::create($request->validated());

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Voucher baru berhasil dibuat.');
    }

    /**
     * Update the specified voucher in database.
     */
    public function updateVoucher(UpdateVoucherRequest $request, Voucher $voucher): RedirectResponse
    {
        $voucher->update($request->validated());

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Detail voucher berhasil diperbarui.');
    }

    /**
     * Remove the specified voucher from database.
     */
    public function destroyVoucher(Voucher $voucher): RedirectResponse
    {
        $voucher->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Voucher berhasil dihapus.');
    }
}
