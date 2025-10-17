<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Article::query();

        // Filter by category
        if ($request->has('category')) {
            $query->category($request->category);
        }

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Pagination
        $articles = $query->latest('date')->paginate(6);
        
        // Get all categories for filter
        $categories = Article::distinct()->pluck('category');

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string',
            'summary' => 'required|string',
            'content' => 'required|string',
            'image' => 'required|string',
            'read_time' => 'required|string'
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): View
    {
        return view('articles.show', compact('article'));
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
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string',
            'summary' => 'required|string',
            'content' => 'required|string',
            'image' => 'required|string',
            'read_time' => 'required|string'
        ]);

        $article->update($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully!');
    }
}