<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Article::with(['user', 'category', 'tags']);

        // Filter by category SLUG (bukan string category lagi)
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
        
        // Get categories dengan count
        $categories = Category::withCount('articles')->get();

        return view('articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
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
            'read_time' => 'required|string'
        ]);

        $article = Article::create($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article created successfully! 🎉');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): View
    {
        // Increment views
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
        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
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
            'read_time' => 'required|string'
        ]);

        $article->update($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article updated successfully! ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully! 🗑️');
    }
}