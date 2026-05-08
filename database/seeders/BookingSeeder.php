<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Apartment;
use App\Models\Booking;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $apartmentIds = Apartment::pluck('id')->toArray();
        if (empty($apartmentIds)) {
            return;
        }

        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        for ($i = 0; $i < 25; $i++) {
            $apartment = Apartment::find($faker->randomElement($apartmentIds));
            if (! $apartment) {
                continue;
            }

            $harga = $apartment->harga_per_malam ?? $faker->numberBetween(200000, 1500000);

            $checkIn = $faker->dateTimeBetween('now', '+60 days');
            $nights = $faker->numberBetween(1, 14);
            $checkOut = (clone $checkIn)->modify("+{$nights} days");

            $status = $faker->randomElement($statuses);
            $paidAt = null;
            if (in_array($status, ['confirmed', 'completed'])) {
                $paidAt = Carbon::instance($faker->dateTimeBetween('-30 days', 'now'));
            }

            Booking::create([
                'booking_code' => 'BK' . strtoupper(Str::random(4)),
                'apartment_id' => $apartment->id,
                'nama_tamu' => $faker->name,
                'email_tamu' => $faker->safeEmail,
                'no_hp' => $faker->phoneNumber,
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'jumlah_tamu' => $faker->numberBetween(1, max(1, $apartment->tamu_dewasa ?? 4)),
                'harga_per_malam' => $harga,
                'jumlah_malam' => $nights,
                'total_harga' => $harga * $nights,
                'catatan' => $faker->optional()->sentence(6),
                'status' => $status,
                'payment_method' => $faker->randomElement(['bank_transfer', 'qris', 'cash']),
                'payment_proof' => null,
                'paid_at' => $paidAt ? $paidAt->format('Y-m-d H:i:s') : null,
            ]);
        }
    }
}
