<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstWhere('name', 'admin');
        $apoteker = Role::firstWhere('name', 'apoteker');
        $pelanggan = Role::firstWhere('name', 'pelanggan');

        User::updateOrCreate(
            ['email' => 'admin@apotek.com'],
            [
                'role_id'  => $admin->id,
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'apoteker@apotek.com'],
            [
                'role_id'  => $apoteker->id,
                'name'     => 'Apoteker',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        // Dummy Customers (Users with pelanggan role)
        $customers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'phone' => '081234567890'],
            ['name' => 'Siti Aminah', 'email' => 'siti@gmail.com', 'phone' => '082234567891'],
            ['name' => 'Andi Wijaya', 'email' => 'andi@gmail.com', 'phone' => '083334567892'],
        ];

        foreach ($customers as $c) {
            User::updateOrCreate(
                ['email' => $c['email']],
                [
                    'role_id'  => $pelanggan->id,
                    'name'     => $c['name'],
                    'phone'    => $c['phone'],
                    'password' => Hash::make('password'),
                    'is_active' => true,
                ]
            );
        }
    }
}
