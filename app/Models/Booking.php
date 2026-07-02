<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'room_id',
        'nama_tamu',
        'email_tamu',
        'no_hp',
        'check_in',
        'check_out',
        'jumlah_tamu',
        'harga_per_malam',
        'jumlah_malam',
        'total_harga',
        'discount_amount',
        'discount_type',
        'voucher_code',
        'catatan',
        'status',
        'payment_method',
        'payment_proof',
        'paid_at',
        'payment_notes',
        'ppn',
        'admin_fee',
        'raw_payload',
        'cancel_reason',
        'cancelled_by',
        'cancelled_at',
        'is_terms_accepted',
        'terms_accepted_at',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'harga_per_malam' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'is_terms_accepted' => 'boolean',
        'terms_accepted_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function payment_logs()
    {
        return $this->hasMany(BookingPaymentLog::class, 'invoice_number', 'booking_code');
    }
}

