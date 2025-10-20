<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'AI',
            'Machine Learning',
            'Web Development',
            'Mobile Apps',
            'Cloud Computing',
            'Cybersecurity',
            'UI Design',
            'UX Design',
            'Branding',
            'Typography',
            'Illustration',
            'Prototyping',
            'Startup',
            'Marketing',
            'SEO',
            'Productivity',
            'Leadership',
            'Remote Work',
            'Health',
            'Fitness',
            'Nutrition',
            'Travel',
            'Food',
            'Photography',
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => \Illuminate\Support\Str::slug($tagName),
            ]);
        }
    }
}