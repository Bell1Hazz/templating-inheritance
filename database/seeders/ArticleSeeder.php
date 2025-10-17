<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Revolutionizing Web Development with AI Tools',
                'author' => 'Sarah Johnson',
                'date' => '2024-11-15',
                'category' => 'technology',
                'summary' => 'Discover how artificial intelligence is transforming the way developers build modern web applications.',
                'content' => 'Artificial intelligence has become a game-changer in web development, offering unprecedented opportunities to streamline workflows and enhance productivity. Modern AI-powered tools are revolutionizing how developers approach coding challenges.',
                'image' => 'images/pexels-bertellifotografia-16094040.jpg',
                'read_time' => '5 min read'
            ],
            [
                'title' => 'Mastering UI/UX Design Principles',
                'author' => 'Michael Chen',
                'date' => '2024-11-12',
                'category' => 'design',
                'summary' => 'Learn the fundamental principles of UI/UX design that create engaging user experiences.',
                'content' => 'Creating exceptional user experiences requires a deep understanding of design principles that go beyond visual aesthetics. Successful UI/UX design balances functionality with beauty.',
                'image' => 'images/pexels-mikael-blomkvist-6476263.jpg',
                'read_time' => '7 min read'
            ],
            [
                'title' => 'Building Scalable Business Solutions',
                'author' => 'Emily Rodriguez',
                'date' => '2024-11-10',
                'category' => 'business',
                'summary' => 'Explore how cloud technology enables businesses to scale efficiently while reducing costs.',
                'content' => 'Cloud technology has transformed the business landscape, offering unprecedented scalability and flexibility for organizations of all sizes.',
                'image' => 'images/pexels-pavel-danilyuk-7869054.jpg',
                'read_time' => '6 min read'
            ],
            [
                'title' => 'The Future of Mobile App Development',
                'author' => 'David Kim',
                'date' => '2024-11-08',
                'category' => 'technology',
                'summary' => 'Investigating emerging trends in mobile development including cross-platform frameworks.',
                'content' => 'Mobile app development continues to evolve rapidly with new technologies and frameworks emerging constantly.',
                'image' => 'images/pexels-divinetechygirl-1181244.jpg',
                'read_time' => '8 min read'
            ],
            [
                'title' => 'Creative Brand Identity Design',
                'author' => 'Lisa Wang',
                'date' => '2024-11-05',
                'category' => 'design',
                'summary' => 'Discover innovative approaches to creating memorable brand identities.',
                'content' => 'Brand identity design goes far beyond creating a logo; it encompasses the entire visual and emotional experience.',
                'image' => 'images/pexels-nourabiad-25566785.jpg',
                'read_time' => '6 min read'
            ],
            [
                'title' => 'Digital Marketing for Small Business',
                'author' => 'Robert Johnson',
                'date' => '2024-11-03',
                'category' => 'business',
                'summary' => 'Learn cost-effective digital marketing techniques for small businesses.',
                'content' => 'Small businesses can leverage digital marketing to compete effectively with larger corporations by focusing on targeted strategies.',
                'image' => 'images/pexels-ketut-subiyanto-4473351.jpg',
                'read_time' => '7 min read'
            ]
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}