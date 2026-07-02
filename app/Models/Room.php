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

    /**
     * Get the discounts specific to this room.
     */
    public function discounts()
    {
        return $this->hasMany(Discount::class, 'room_id');
    }

    /**
     * Get the active discount according to the priority hierarchy:
     * Unit Discount (attached to room) > Global Discount (room_id is null)
     *
     * @param string|null $date
     * @return Discount|null
     */
    public function getActiveDiscount($date = null)
    {
        // 1. Prioritas Utama: Diskon per unit (spesifik untuk room_id ini)
        $unitDiscount = $this->discounts()->active($date)->first();
        if ($unitDiscount) {
            return $unitDiscount;
        }

        // 2. Prioritas Kedua: Diskon Global (room_id bernilai null)
        return Discount::whereNull('room_id')->active($date)->first();
    }

    /**
     * Calculate final price using priority hierarchy:
     * Voucher > Diskon Per Unit > Diskon Global.
     *
     * @param int $nights
     * @param string|null $voucherCode
     * @param string|null $date
     * @param array &$details Will be filled with calculation details
     * @return float
     */
    public function calculateBookingPrice(int $nights, ?string $voucherCode = null, ?string $date = null, &$details = []): float
    {
        $basePricePerNight = (float) $this->harga_per_malam;
        $totalBasePrice = $basePricePerNight * $nights;
        
        $appliedDiscount = null;
        $appliedVoucher = null;
        $discountAmount = 0.0;
        
        // 1. Cek Voucher (Prioritas tertinggi: Voucher > Diskon Per Unit > Diskon Global)
        if ($voucherCode) {
            $voucher = Voucher::where('code', $voucherCode)->first();
            if ($voucher) {
                $err = '';
                if ($voucher->isValidFor($totalBasePrice, $date, $err)) {
                    $appliedVoucher = $voucher;
                    $discountAmount = $voucher->calculateDiscountAmount($totalBasePrice);
                } else {
                    $details['voucher_error'] = $err;
                }
            } else {
                $details['voucher_error'] = 'Kode voucher tidak valid.';
            }
        }
        
        // 2. Jika tidak ada voucher yang berhasil diaplikasikan, gunakan Diskon (Unit atau Global)
        if (!$appliedVoucher) {
            $discount = $this->getActiveDiscount($date);
            if ($discount) {
                $appliedDiscount = $discount;
                $discountAmount = $discount->calculateDiscountAmount($totalBasePrice);
            }
        }
        
        $finalPrice = max(0.0, $totalBasePrice - $discountAmount);
        
        $details = array_merge($details, [
            'base_price_per_night' => $basePricePerNight,
            'nights' => $nights,
            'total_base_price' => $totalBasePrice,
            'applied_voucher' => $appliedVoucher ? $appliedVoucher->code : null,
            'applied_discount' => $appliedDiscount ? $appliedDiscount->name : null,
            'applied_discount_type' => $appliedVoucher ? 'voucher' : ($appliedDiscount ? ($appliedDiscount->room_id ? 'unit' : 'global') : 'none'),
            'discount_amount' => $discountAmount,
            'final_price' => $finalPrice,
        ]);
        
        return $finalPrice;
    }
}


