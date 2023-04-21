<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            'Hardware',
            'Software',
            'Network',
            'Other',
            'Headphones',
            'Speakers',
            'Monitors',
            'Mice',
            'Keyboards',
            'Printers',
            'Scanners',
            'Projectors',
            'Laptops',
        ]);

        Category::factory()->createMany($categories->map(fn ($name) => ['title' => $name])->toArray());
    }
}
