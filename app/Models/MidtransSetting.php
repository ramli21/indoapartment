<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MidtransSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_key',
        'client_key',
        'webhook_secret',
        'is_production',
    ];

    protected $casts = [
        'is_production' => 'boolean',
    ];

    public static function getFirst(): ?self
    {
        return self::query()->orderBy('id', 'asc')->first();
    }
}

