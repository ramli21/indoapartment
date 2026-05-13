<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasFactory;

    protected $table = 'apartments';

    protected $fillable = [
        'nama',
        'gambar',
        'alamat',
        'google_maps_embed',
    ];

    protected $casts = [
        'google_maps_embed' => 'string',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'apartment_id');
    }
}

