<?php

namespace App\Services;

use App\Models\Discount;
use App\Models\Voucher;
use Carbon\Carbon;

class DiscountService
{
    /**
     * Calculate the final price based on discount priority hierarchy:
     * Voucher > Diskon Per Unit (Room) > Diskon Global
     *
     * @param string|int $roomId
     * @param float $originalPrice
     * @param string|null $voucherCode
     * @param string|null $date Reference date for checking validity (default: now)
     * @return array
     */
    public function calculateFinalPrice($roomId, float $originalPrice, ?string $voucherCode = null, ?string $date = null): array
    {
        $checkDate = $date ? Carbon::parse($date) : Carbon::now();
        $discountAmount = 0.0;
        $appliedType = 'None';
        $errorMessage = null;
        
        // 1. Prioritas Pertama: Voucher
        if ($voucherCode) {
            $voucher = Voucher::where('code', $voucherCode)->first();
            if ($voucher) {
                $err = '';
                if ($voucher->isValidFor($originalPrice, $checkDate, $err)) {
                    $discountAmount = $voucher->calculateDiscountAmount($originalPrice);
                    $appliedType = 'Voucher';
                } else {
                    $errorMessage = $err;
                }
            } else {
                $errorMessage = 'Kode voucher tidak valid.';
            }
        }
        
        // 2. Prioritas Kedua: Diskon Per Unit (Room)
        if ($appliedType === 'None') {
            $roomDiscount = Discount::where('room_id', $roomId)
                ->active($checkDate)
                ->first();
                
            if ($roomDiscount) {
                $discountAmount = $roomDiscount->calculateDiscountAmount($originalPrice);
                $appliedType = 'Room';
            }
        }
        
        // 3. Prioritas Ketiga: Diskon Global
        if ($appliedType === 'None') {
            $globalDiscount = Discount::whereNull('room_id')
                ->active($checkDate)
                ->first();
                
            if ($globalDiscount) {
                $discountAmount = $globalDiscount->calculateDiscountAmount($originalPrice);
                $appliedType = 'Global';
            }
        }
        
        $finalPrice = max(0.0, $originalPrice - $discountAmount);
        
        $result = [
            'original_price' => $originalPrice,
            'discount_amount' => $discountAmount,
            'applied_type' => $appliedType,
            'final_price' => $finalPrice,
        ];

        if ($errorMessage) {
            $result['voucher_error'] = $errorMessage;
        }

        return $result;
    }
}
