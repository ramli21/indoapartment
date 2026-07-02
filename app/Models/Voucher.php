<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'min_booking_amount',
        'max_uses',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_booking_amount' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active vouchers for a given date.
     */
    public function scopeActive($query, $date = null)
    {
        $checkDate = $date ? Carbon::parse($date) : Carbon::now();

        return $query->where('is_active', true)
            ->where('start_date', '<=', $checkDate)
            ->where('end_date', '>=', $checkDate)
            ->where(function ($q) {
                $q->whereNull('max_uses')
                  ->orWhereRaw('used_count < max_uses');
            });
    }

    /**
     * Real-time validation for voucher usage.
     *
     * @param float|decimal $bookingAmount The current booking transaction amount
     * @param string|null $date The date to validate (defaults to now)
     * @param string &$errorMessage Reference variable to output reason for failure
     * @return bool
     */
    public function isValidFor($bookingAmount, $date = null, &$errorMessage = ''): bool
    {
        $checkDate = $date ? Carbon::parse($date) : Carbon::now();

        // 1. Check active status
        if (!$this->is_active) {
            $errorMessage = 'Voucher sudah tidak aktif.';
            return false;
        }

        // 2. Check validity dates
        if ($checkDate->lt($this->start_date)) {
            $errorMessage = 'Masa berlaku voucher belum dimulai.';
            return false;
        }

        if ($checkDate->gt($this->end_date)) {
            $errorMessage = 'Voucher sudah kadaluwarsa.';
            return false;
        }

        // 3. Check usage limit
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            $errorMessage = 'Kuota penggunaan voucher sudah habis.';
            return false;
        }

        // 4. Check minimum booking amount
        if ($bookingAmount < (float) $this->min_booking_amount) {
            $errorMessage = 'Nominal pemesanan tidak mencapai syarat minimum penggunaan voucher yaitu Rp' . number_format($this->min_booking_amount, 0, ',', '.');
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount based on the booking amount.
     *
     * @param float|decimal $bookingAmount
     * @return float
     */
    public function calculateDiscountAmount($bookingAmount): float
    {
        $bookingAmount = (float) $bookingAmount;
        $value = (float) $this->value;

        if ($this->type === 'percentage') {
            return ($value / 100) * $bookingAmount;
        }

        // 'fixed' nominal discount
        return min($value, $bookingAmount);
    }

    /**
     * Increment usage count of the voucher.
     *
     * @return bool
     */
    public function incrementUsage(): bool
    {
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return false;
        }

        return $this->increment('used_count');
    }
}
