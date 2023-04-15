<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->createMany([
            ['title' => 'Test Category 1'],
            ['title' => 'Test Category 2'],
            ['title' => 'Test Category 3'],
        ]);
    }
}
