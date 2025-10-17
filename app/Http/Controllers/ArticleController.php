<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $cacheKey = 'articles_' . md5(
            $request->get('category', '') . 
            $request->get('search', '') . 
            $request->get('page', 1)
        );

        // Cache selama 5 menit (300 detik)
        $articles = Cache::remember($cacheKey, 300, function () use ($request) {
            $query = Article::select(['id', 'title', 'author', 'date', 'category', 'summary', 'image', 'read_time']);

            // Filter by category
            if ($request->has('category') && $request->category !== 'all') {
                $query->where('category', $request->category);
            }

            // Search
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('summary', 'like', "%{$search}%");
                });
            }

            return $query->latest('date')->paginate(6)->withQueryString();
        });
        
        // Cache categories juga
        $categories = Cache::remember('article_categories', 3600, function () {
            return Article::distinct()->pluck('category');
        });

        return view('articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'required|string',
            'read_time' => 'required|string'
        ]);

        $article = Article::create($validated);

        // Clear cache saat ada artikel baru
        $this->clearArticleCache();

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article created successfully! 🎉');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): View
    {
        // Cache detail artikel selama 24 jam
        $cachedArticle = Cache::remember("article_{$article->id}", 86400, function () use ($article) {
            return $article;
        });

        return view('articles.show', compact('article' => $cachedArticle));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): View
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'required|string',
            'read_time' => 'required|string'
        ]);

        $article->update($validated);

        // Clear cache untuk artikel yang di-update
        Cache::forget("article_{$article->id}");
        $this->clearArticleCache();

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article updated successfully! ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        // Clear cache saat artikel dihapus
        Cache::forget("article_{$article->id}");
        $this->clearArticleCache();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully! 🗑️');
    }

    /**
     * Clear all article-related caches
     */
    private function clearArticleCache(): void
    {
        Cache::tags(['articles'])->flush();
        // Atau jika tidak menggunakan tags:
        // Cache::forget('article_categories');
    }
}