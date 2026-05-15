<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Apartment extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'apartment_id');
    }
}

