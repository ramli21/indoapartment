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

    protected function casts(): array
    {
        return [
            'fasilitas' => 'array',
            'gambar' => 'array',
            'luas' => 'decimal:2',
            'harga_per_malam' => 'decimal:2',
        ];
    }
}
