<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@indoapart.com'],
            [
                'name' => 'Admin IndoApart',
                'password' => Hash::make('password@123'),
                'is_admin' => true,
            ]
        );

        // Seed rooms dummy (sudah ada sebelumnya)
        $this->call(RoomSeeder::class);

        // Seed apartments kategori + relasikan ke rooms
        $this->call(ApartmentSeeder::class);

        // Relasikan rooms ke apartment (minimal-drift untuk demo)
        // Jika ApartmentSeeder membuat record, RoomSeeder sebelumnya akan di-update di sini.
        $this->call(RoomSeeder::class);


        $this->call(AdminInfoSeeder::class);


        // Seed inquiries and bookings
        // $this->call(InquirySeeder::class);
        // $this->call(BookingSeeder::class);
    }
}

