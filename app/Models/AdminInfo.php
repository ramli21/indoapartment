<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_number',
        'account_holder',
        'whatsapp',
        'email',
        'ppn',
        'admin_fee',
    ];

    public static function getFirst()
    {
        return self::first();
    }
}

