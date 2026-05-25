<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPaymentLog extends Model
{
    protected $fillable = [
        'id',
        'invoice_number',
        'original_request_id',
        'amount',
        'payment_channel',
        'status',
        'raw_payload',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'invoice_number', 'booking_code');
    }
}
