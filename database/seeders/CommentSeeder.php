<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $articles = Article::all();
        $users = User::all();

        $commentContents = [
            'Great article! Very informative and well-written.',
            'This is exactly what I was looking for. Thanks for sharing!',
            'I learned so much from this. Keep up the good work!',
            'Interesting perspective. I hadn\'t thought about it this way.',
            'Thanks for the detailed explanation. Very helpful!',
            'Could you elaborate more on this topic?',
            'Fantastic content! Looking forward to more articles.',
        ];

        $replyContents = [
            'I agree! This is really helpful.',
            'Thanks for your feedback!',
            'Glad you found it useful!',
            'Let me know if you have any questions.',
            'Appreciate your thoughts!',
        ];

        foreach ($articles as $article) {
            // Create 3-4 parent comments per article
            $numComments = rand(3, 4);
            
            for ($i = 0; $i < $numComments; $i++) {
                $comment = Comment::create([
                    'article_id' => $article->id,
                    'user_id' => $users->random()->id,
                    'content' => $commentContents[array_rand($commentContents)],
                    'is_approved' => true,
                ]);

                // Add 0-2 replies to each comment
                $numReplies = rand(0, 2);
                
                for ($j = 0; $j < $numReplies; $j++) {
                    Comment::create([
                        'article_id' => $article->id,
                        'user_id' => $users->random()->id,
                        'parent_id' => $comment->id,
                        'content' => $replyContents[array_rand($replyContents)],
                        'is_approved' => true,
                    ]);
                }
            }
        }
    }
}