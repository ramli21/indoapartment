<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Apartment;
use App\Models\Inquiry;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $apartmentIds = Apartment::pluck('id')->toArray();
        if (empty($apartmentIds)) {
            return;
        }

        for ($i = 0; $i < 15; $i++) {
            $apartmentId = $faker->randomElement($apartmentIds);

            Inquiry::create([
                'apartment_id' => $apartmentId,
                'nama' => $faker->name,
                'email' => $faker->safeEmail,
                'no_hp' => $faker->phoneNumber,
                'subjek' => $faker->sentence(3),
                'pesan' => $faker->paragraph(3),
                'status' => $faker->randomElement(['baru', 'dibaca', 'dijawab', 'selesai']),
            ]);
        }
    }
}
