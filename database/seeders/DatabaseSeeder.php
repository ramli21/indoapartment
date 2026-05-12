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

        // Seed 10 dummy apartments
        $this->call(ApartmentSeeder::class);
        $this->call(AdminInfoSeeder::class);

        // Seed inquiries and bookings
        // $this->call(InquirySeeder::class);
        // $this->call(BookingSeeder::class);
    }
}

