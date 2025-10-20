<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Article::with(['user', 'category', 'tags']);

        // Filter by category slug
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest('date')->paginate(6)->withQueryString();
        $categories = Category::withCount('articles')->get();

        return view('articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * 🔒 TRANSACTION: Pastikan article & tags tersimpan bersamaan
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'required|string',
            'read_time' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        try {
            // 🔒 START TRANSACTION
            $article = DB::transaction(function () use ($validated) {
                
                // Step 1: Create Article
                $article = Article::create([
                    'user_id' => $validated['user_id'],
                    'category_id' => $validated['category_id'],
                    'title' => $validated['title'],
                    'date' => $validated['date'],
                    'summary' => $validated['summary'],
                    'content' => $validated['content'],
                    'image' => $validated['image'],
                    'read_time' => $validated['read_time'],
                ]);

                // Step 2: Attach Tags (jika ada)
                if (isset($validated['tags']) && count($validated['tags']) > 0) {
                    $article->tags()->attach($validated['tags']);
                }

                // Step 3: Log activity (optional)
                Log::info('Article created', [
                    'article_id' => $article->id,
                    'title' => $article->title,
                    'user_id' => $article->user_id,
                ]);

                return $article;
            });
            // 🔒 END TRANSACTION (Auto COMMIT jika sukses)

            return redirect()->route('articles.show', $article)
                ->with('success', 'Article created successfully! 🎉');

        } catch (\Exception $e) {
            // 🔒 Auto ROLLBACK jika ada error
            
            Log::error('Failed to create article', [
                'error' => $e->getMessage(),
                'user_id' => $validated['user_id'] ?? null,
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create article. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): View
    {
        // Increment views (simple operation, no transaction needed)
        $article->incrementViews();
        
        // Load relationships
        $article->load(['user', 'category', 'tags', 'comments.user', 'comments.replies.user']);
        
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): View
    {
        $categories = Category::all();
        $tags = Tag::all();
        $article->load('tags'); // Eager load tags
        return view('articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * 🔒 TRANSACTION: Pastikan article & tags update bersamaan
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'required|string',
            'read_time' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        try {
            // 🔒 START TRANSACTION
            DB::transaction(function () use ($article, $validated) {
                
                // Step 1: Update Article
                $article->update([
                    'user_id' => $validated['user_id'],
                    'category_id' => $validated['category_id'],
                    'title' => $validated['title'],
                    'date' => $validated['date'],
                    'summary' => $validated['summary'],
                    'content' => $validated['content'],
                    'image' => $validated['image'],
                    'read_time' => $validated['read_time'],
                ]);

                // Step 2: Sync Tags (remove old, add new)
                if (isset($validated['tags'])) {
                    $article->tags()->sync($validated['tags']);
                } else {
                    $article->tags()->detach(); // Remove all tags
                }

                // Step 3: Log activity
                Log::info('Article updated', [
                    'article_id' => $article->id,
                    'title' => $article->title,
                ]);
            });
            // 🔒 END TRANSACTION

            return redirect()->route('articles.show', $article)
                ->with('success', 'Article updated successfully! ✅');

        } catch (\Exception $e) {
            Log::error('Failed to update article', [
                'error' => $e->getMessage(),
                'article_id' => $article->id,
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update article. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * 🔒 TRANSACTION: Pastikan article, tags, comments terhapus bersamaan
     */
    public function destroy(Article $article): RedirectResponse
    {
        try {
            // 🔒 START TRANSACTION
            DB::transaction(function () use ($article) {
                
                $articleTitle = $article->title;
                
                // Step 1: Detach Tags (optional, cascade sudah handle)
                $article->tags()->detach();

                // Step 2: Delete Comments (cascade sudah handle via foreign key)
                // Tapi kita bisa manual juga:
                $article->comments()->delete();

                // Step 3: Delete Article
                $article->delete();

                // Step 4: Log activity
                Log::info('Article deleted', [
                    'article_id' => $article->id,
                    'title' => $articleTitle,
                ]);
            });
            // 🔒 END TRANSACTION

            return redirect()->route('articles.index')
                ->with('success', 'Article deleted successfully! 🗑️');

        } catch (\Exception $e) {
            Log::error('Failed to delete article', [
                'error' => $e->getMessage(),
                'article_id' => $article->id,
            ]);

            return redirect()->back()
                ->with('error', 'Failed to delete article. Please try again.');
        }
    }
}