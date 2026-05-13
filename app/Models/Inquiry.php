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
        return $this->hasOneThrough(
            Apartment::class,
            Room::class,
            'id', // kunci primary pada Room untuk dipetakan
            'id', // kunci primary pada Apartment
            'room_id',
            'apartment_id'
        );
    }

}
