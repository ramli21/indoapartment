<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ApartmentSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan folder gambar dummy tersedia
        Storage::disk('public')->makeDirectory('apartments');

        // 8 contoh apartment
        $apartments = [
            [
                'nama' => 'Apartemen Sudirman Park',
                'alamat' => 'Jl. Jend. Sudirman No. 1, Jakarta',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'nama' => 'Studio Apartment Thamrin',
                'alamat' => 'Jl. Thamrin No. 10, Jakarta',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!2" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'nama' => 'Luxury Penthouse Kemang',
                'alamat' => 'Jl. Kemang Raya No. 15, Jakarta',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!3" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'nama' => 'Apartemen Taman Anggrek 3BR',
                'alamat' => 'Jl. Taman Anggrek No. 3, Jakarta',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!4" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'nama' => 'Cozy 1BR Apartemen BSD',
                'alamat' => 'BSD City, Tangerang',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!5" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'nama' => 'Duplex Apartment SCBD',
                'alamat' => 'SCBD Lot 1, Jakarta',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!6" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'nama' => 'Studio Premium PIK',
                'alamat' => 'Pantai Indah Kapuk, Jakarta',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!7" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'nama' => 'Family Apartment Kelapa Gading',
                'alamat' => 'Kelapa Gading, Jakarta',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!8" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
        ];

        foreach ($apartments as $i => $data) {
            // gambar dummy: pakai salah satu file demo rooms yang sudah ada jika memungkinkan
            // fallback: tetap insert gambar null jika folder demo kosong.
            $dummyImagePath = null;
            $demoFiles = Storage::disk('public')->files('demo');
            if (!empty($demoFiles)) {
                $picked = $demoFiles[$i % count($demoFiles)];
                $ext = pathinfo($picked, PATHINFO_EXTENSION);
                $dummyImagePath = 'apartments/demo_apartment_' . ($i + 1) . '.' . $ext;
                Storage::disk('public')->copy($picked, $dummyImagePath);
            }

            $apartment = Apartment::updateOrCreate(
                ['nama' => $data['nama']],
                [
                    'alamat' => $data['alamat'],
                    'google_maps_embed' => $data['google_maps_embed'],
                    'gambar' => $dummyImagePath,
                ]
            );

            // Relasikan langsung: 1 apartment -> sekumpulan rooms dummy
            // Untuk demo sederhana: ambil chunk 1 room per apartment (atau sisanya tetap null).
            // Ini agar relasi sudah bisa dipakai oleh UI tanpa mengubah booking/inquiry.
            $roomIds =
                \App\Models\Room::query()
                    ->whereNull('apartment_id')
                    ->orderBy('id')
                    ->limit(3)
                    ->pluck('id')
                    ->toArray();

            if (!empty($roomIds)) {
                \App\Models\Room::query()
                    ->whereIn('id', $roomIds)
                    ->update(['apartment_id' => $apartment->id]);
            }
        }

    }
}

