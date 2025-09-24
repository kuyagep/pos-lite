<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        License::create([
            'license_key'   => strtoupper(Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4)),
            'registered_to' => 'Demo Store',
            'valid_until'   => now()->addYear(), // valid for 1 year
            'is_active'     => true,
        ]);
    }
}
