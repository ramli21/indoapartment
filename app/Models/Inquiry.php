<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'apartment_id',
        'nama',
        'email',
        'no_hp',
        'subjek',
        'pesan',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function apartment()
    {
        // Minimal-drift: Inquiry tetap terhubung ke Room via room_id
        // Apartment diakses lewat Room.
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }

}
