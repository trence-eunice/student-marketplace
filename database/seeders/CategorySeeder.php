<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Books & Modules', 'description' => 'Textbooks, reviewers, and printed modules'],
            ['name' => 'Electronics', 'description' => 'Gadgets, chargers, earphones, and accessories'],
            ['name' => 'Uniforms & Clothing', 'description' => 'School uniforms and student clothing'],
            ['name' => 'School Supplies', 'description' => 'Notebooks, pens, art materials, and more'],
            ['name' => 'Food & Snacks', 'description' => 'Homemade food and snacks sold by students'],
            ['name' => 'Services', 'description' => 'Tutoring, printing, and other student services'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}