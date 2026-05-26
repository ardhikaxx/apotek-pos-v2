<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Analgesik & Antipiretik',
            'Antibiotik',
            'Antivirus',
            'Obat Batuk & Pilek',
            'Obat Diabetes',
            'Obat Hipertensi',
            'Suplemen & Vitamin',
            'Obat Lambung & Antacida',
            'Obat Kulit & Kelamin',
            'Obat Mata',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
