<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

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
            if (empty($room->id)) {
                $room->id = (string) Str::uuid();
            }
            $base = Str::slug($room->judul) ?: (string) Str::uuid();
            $slug = $base;
            $counter = 1;
            while (self::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $counter++;
            }
            $room->slug = $slug;
        });

        static::updating(function ($room) {
            if ($room->isDirty('judul')) {
                $base = Str::slug($room->judul) ?: (string) Str::uuid();
                $slug = $base;
                $counter = 1;
                while (self::where('slug', $slug)->where('id', '!=', $room->id)->exists()) {
                    $slug = $base . '-' . $counter++;
                }
                $room->slug = $slug;
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


