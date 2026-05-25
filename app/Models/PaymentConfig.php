<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PaymentConfig extends Model
{
    use HasFactory;

    protected $table = 'payment_configs';

    protected $fillable = [
        'provider_name',
        'merchant_id',
        'client_id',
        'shared_key',
        'is_production',
    ];

    protected $casts = [
        'is_production' => 'boolean',
    ];

    // Store encrypted values for sensitive fields
    public function setClientIdAttribute($value)
    {
        $this->attributes['client_id'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getClientIdAttribute($value)
    {
        if (empty($value)) return null;
        try {
            return Crypt::decryptString($value);
        } catch (\Throwable $e) {
            return $value;
        }
    }

    public function setSharedKeyAttribute($value)
    {
        $this->attributes['shared_key'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getSharedKeyAttribute($value)
    {
        if (empty($value)) return null;
        try {
            return Crypt::decryptString($value);
        } catch (\Throwable $e) {
            return $value;
        }
    }
}
