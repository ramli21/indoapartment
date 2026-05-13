<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Room di DB direpresentasikan oleh tabel `rooms`
    protected $table = 'rooms';


    protected $fillable = [
        'judul',
        'slug',
        'luas',
        'tipe',
        'harga_per_malam',
        'deskripsi',
        'gambar',
        'fasilitas',
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
        'owner_bank_name',
        'apartment_id',
    ];


    protected $casts = [
        'fasilitas' => 'array',
        'gambar' => 'array',
        'luas' => 'decimal:2',
        'harga_per_malam' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            $room->slug = \Str::slug($room->judul);
        });

        static::updating(function ($room) {
            if ($room->isDirty('judul')) {
                $room->slug = \Str::slug($room->judul);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }
}


