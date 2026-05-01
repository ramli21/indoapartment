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
        return $this->belongsTo(Apartment::class);
    }
}
