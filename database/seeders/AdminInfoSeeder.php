<?php

namespace Database\Seeders;

use App\Models\AdminInfo;
use Illuminate\Database\Seeder;

class AdminInfoSeeder extends Seeder
{
    public function run(): void
    {
        AdminInfo::updateOrCreate(
            ['id' => 1],
            [
                'bank_name' => 'Bank Central Asia (BCA)',
                'account_number' => '1234567890',
                'account_holder' => 'PT IndoApartment Indonesia',
                'whatsapp' => '081234567890',
                'email' => 'admin@indoapart.com',
            ]
        );
    }
}

