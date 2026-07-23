<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FonnteSetting;

class FonnteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FonnteSetting::updateOrCreate(
            ['name' => 'Primary Device'],
            [
                'base_url' => 'https://api.fonnte.com',
                'token' => 'placeholder_token_replace_me',
                'country_code' => '62',
                'is_active' => true,
            ]
        );
    }
}
