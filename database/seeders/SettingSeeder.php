<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'app_name' => 'Laravel',
            'app_description' => 'The PHP Framework For Web Artisans',
            'email' => 'contact@yopmail.com',
            'phone' => '1234567890',
            'address' => '123, Laravel Street, Laravel City, Laravel Country',
            'logo' => 'logo.png',
            'favicon' => 'favicon.png',
        ];
        foreach ($data as $key => $value) {
            
            Setting::create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}
