<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  use HasFactory;

  protected $fillable = [
    'apartment_id',
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

  public function apartment()
  {
    return $this->belongsTo(Apartment::class);
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
