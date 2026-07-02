<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the room that owns the discount.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Scope a query to only include active discounts for a given date.
     */
    public function scopeActive($query, $date = null)
    {
        $checkDate = $date ? Carbon::parse($date) : Carbon::now();

        return $query->where('is_active', true)
            ->where('start_date', '<=', $checkDate)
            ->where('end_date', '>=', $checkDate);
    }

    /**
     * Calculate discount amount based on the base price.
     *
     * @param float|decimal $basePrice
     * @return float
     */
    public function calculateDiscountAmount($basePrice): float
    {
        $basePrice = (float) $basePrice;
        $value = (float) $this->value;

        if ($this->type === 'percentage') {
            return ($value / 100) * $basePrice;
        }

        // 'fixed' nominal discount
        return min($value, $basePrice); // Discount cannot exceed the base price
    }
}
