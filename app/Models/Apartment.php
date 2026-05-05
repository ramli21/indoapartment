<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    /** @use HasFactory<\Database\Factories\ApartmentFactory> */
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'luas',
        'tipe',
        'harga_per_malam',
        'deskripsi',
        'gambar',
        'fasilitas',
        'alamat',
        'alamat_google',
        'nama_tower',
        'lantai',
        'nomor_kamar',
        'tamu_dewasa',
        'tamu_anak',
        'jumlah_kamar',
        'jumlah_kamar_mandi',
        'check_in',
        'check_out',
        'status',
        'tata_tertib',
        'owner_nama',
        'owner_wa',
        'owner_rekening',
        'owner_bank_name'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($apartment) {
            $apartment->slug = \Str::slug($apartment->judul);
        });

        static::updating(function ($apartment) {
            if ($apartment->isDirty('judul')) {
                $apartment->slug = \Str::slug($apartment->judul);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'fasilitas' => 'array',
        'gambar' => 'array',
        'luas' => 'decimal:2',
        'harga_per_malam' => 'decimal:2',
    ];
}
