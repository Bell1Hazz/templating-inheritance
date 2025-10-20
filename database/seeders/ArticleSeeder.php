<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'user_id' => 1,
                'category_id' => 1, // Technology
                'title' => 'Revolutionizing Web Development with AI Tools',
                'date' => '2024-11-15',
                'summary' => 'Discover how artificial intelligence is transforming the way developers build modern web applications.',
                'content' => 'Artificial intelligence has become a game-changer in web development, offering unprecedented opportunities to streamline workflows and enhance productivity. Modern AI-powered tools are revolutionizing how developers approach coding challenges, from automated code generation to intelligent debugging assistants. This transformation is not just about writing code faster—it\'s about fundamentally changing how we think about software development. Machine learning models can now predict code patterns, suggest optimizations, and even identify potential security vulnerabilities before they become problems. As we move forward, the integration of AI in development workflows will only deepen, making it essential for developers to adapt and embrace these new technologies.',
                'image' => 'images/pexels-bertellifotografia-16094040.jpg',
                'read_time' => '5 min read',
                'views' => 1250,
                'tags' => ['AI', 'Web Development', 'Machine Learning'],
            ],
            [
                'user_id' => 2,
                'category_id' => 2, // Design
                'title' => 'Mastering UI/UX Design Principles',
                'date' => '2024-11-12',
                'summary' => 'Learn the fundamental principles of UI/UX design that create engaging user experiences.',
                'content' => 'Creating exceptional user experiences requires a deep understanding of design principles that go beyond visual aesthetics. Successful UI/UX design balances functionality with beauty, ensuring that every interaction feels intuitive and purposeful. From color theory to typography, spacing to visual hierarchy—each element plays a crucial role in guiding users through their journey. Modern design thinking emphasizes empathy, putting users at the center of every decision. By conducting thorough research, creating detailed personas, and iterating based on user feedback, designers can craft experiences that truly resonate with their target audience.',
                'image' => 'images/pexels-mikael-blomkvist-6476263.jpg',
                'read_time' => '7 min read',
                'views' => 980,
                'tags' => ['UI Design', 'UX Design', 'Prototyping'],
            ],
            [
                'user_id' => 3,
                'category_id' => 3, // Business
                'title' => 'Building Scalable Business Solutions',
                'date' => '2024-11-10',
                'summary' => 'Explore how cloud technology enables businesses to scale efficiently while reducing costs.',
                'content' => 'Cloud technology has transformed the business landscape, offering unprecedented scalability and flexibility for organizations of all sizes. By leveraging cloud infrastructure, companies can now rapidly adapt to changing market demands without the burden of maintaining expensive on-premise hardware. This shift has democratized access to enterprise-level resources, enabling startups to compete with established players. Modern cloud platforms provide not just infrastructure, but entire ecosystems of tools and services that facilitate everything from data analytics to artificial intelligence. The key to success lies in understanding how to architect solutions that can grow seamlessly with your business.',
                'image' => 'images/pexels-pavel-danilyuk-7869054.jpg',
                'read_time' => '6 min read',
                'views' => 750,
                'tags' => ['Startup', 'Cloud Computing', 'Marketing'],
            ],
            [
                'user_id' => 4,
                'category_id' => 1, // Technology
                'title' => 'The Future of Mobile App Development',
                'date' => '2024-11-08',
                'summary' => 'Investigating emerging trends in mobile development including cross-platform frameworks.',
                'content' => 'Mobile app development continues to evolve rapidly with new technologies and frameworks emerging constantly. Cross-platform development has matured significantly, with frameworks like Flutter and React Native enabling developers to build high-performance apps for both iOS and Android from a single codebase. The future points toward even more seamless experiences, with progressive web apps blurring the lines between web and native applications. As 5G networks become ubiquitous, we can expect mobile apps to become even more powerful and feature-rich.',
                'image' => 'images/pexels-divinetechygirl-1181244.jpg',
                'read_time' => '8 min read',
                'views' => 1100,
                'tags' => ['Mobile Apps', 'Web Development', 'Cloud Computing'],
            ],
            [
                'user_id' => 5,
                'category_id' => 2, // Design
                'title' => 'Creative Brand Identity Design',
                'date' => '2024-11-05',
                'summary' => 'Discover innovative approaches to creating memorable brand identities.',
                'content' => 'Brand identity design goes far beyond creating a logo; it encompasses the entire visual and emotional experience that customers have with your brand. A strong brand identity tells your story, communicates your values, and creates lasting emotional connections with your audience. From color palettes to typography, every element should work in harmony to create a cohesive and memorable brand presence. Successful brand identities are built on thorough research, strategic thinking, and creative execution.',
                'image' => 'images/pexels-nourabiad-25566785.jpg',
                'read_time' => '6 min read',
                'views' => 820,
                'tags' => ['Branding', 'UI Design', 'Illustration'],
            ],
            [
                'user_id' => 1,
                'category_id' => 3, // Business
                'title' => 'Digital Marketing for Small Business',
                'date' => '2024-11-03',
                'summary' => 'Learn cost-effective digital marketing techniques for small businesses.',
                'content' => 'Small businesses can leverage digital marketing to compete effectively with larger corporations by focusing on targeted strategies and authentic engagement. Social media platforms, content marketing, and email campaigns offer affordable ways to reach and engage your target audience. The key is to understand your customers deeply and create value-driven content that resonates with their needs and interests. By building genuine relationships and providing consistent value, small businesses can establish strong online presence.',
                'image' => 'images/pexels-ketut-subiyanto-4473351.jpg',
                'read_time' => '7 min read',
                'views' => 950,
                'tags' => ['Marketing', 'SEO', 'Startup'],
            ],
        ];

        foreach ($articles as $articleData) {
            $tags = $articleData['tags'];
            unset($articleData['tags']);
            
            $article = Article::create($articleData);
            
            // Attach tags
            $tagIds = Tag::whereIn('name', $tags)->pluck('id');
            $article->tags()->attach($tagIds);
        }
    }
}