<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest tech news, AI, and innovations',
                'color' => '#3b82f6',
            ],
            [
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'UI/UX design principles and creative trends',
                'color' => '#8b5cf6',
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Business strategies, startups, and marketing',
                'color' => '#10b981',
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'description' => 'Life tips, wellness, and personal growth',
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Health',
                'slug' => 'health',
                'description' => 'Health, fitness, and nutrition guides',
                'color' => '#ef4444',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}