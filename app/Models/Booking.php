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
    'catatan',
    'status',
    'payment_method',
    'payment_proof',
    'paid_at',
    'payment_notes',
    'raw_payload',
    'cancel_reason',
    'cancelled_by',
    'cancelled_at',
  ];

  protected $casts = [
    'check_in' => 'date',
    'check_out' => 'date',
    'harga_per_malam' => 'decimal:2',
    'total_harga' => 'decimal:2',
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
}
