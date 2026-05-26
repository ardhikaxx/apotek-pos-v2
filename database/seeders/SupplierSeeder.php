<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::create([
            'name'    => 'PT. Kimia Farma',
            'phone'   => '021-123456',
            'address' => 'Jakarta, Indonesia',
        ]);

        Supplier::create([
            'name'    => 'PT. Kalbe Farma',
            'phone'   => '021-654321',
            'address' => 'Bekasi, Indonesia',
        ]);
    }
}
