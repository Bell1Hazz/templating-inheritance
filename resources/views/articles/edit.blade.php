@extends('layouts.app')

@section('title', 'Edit Article - ArticleHub')

@section('content')
<section class="form-section">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h1>✏️ Edit Article</h1>
                <p>Update your article information</p>
            </div>

            <form action="{{ route('articles.update', $article) }}" method="POST" class="article-form">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <!-- Title -->
                    <div class="form-group full-width">
                        <label for="title" class="form-label">Article Title *</label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            class="form-input @error('title') error @enderror" 
                            placeholder="Enter an engaging title..."
                            value="{{ old('title', $article->title) }}"
                            required
                        >
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

<!-- Author -->
<div class="form-group">
    <label for="user_id" class="form-label">Author *</label>
    <select 
        id="user_id" 
        name="user_id" 
        class="form-select @error('user_id') error @enderror"
        required
    >
        @foreach(\App\Models\User::all() as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $article->user_id) == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('user_id')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>


                    <!-- Date -->
                    <div class="form-group">
                        <label for="date" class="form-label">Publication Date *</label>
                        <input 
                            type="date" 
                            id="date" 
                            name="date" 
                            class="form-input @error('date') error @enderror" 
                            value="{{ old('date', $article->date->format('Y-m-d')) }}"
                            required
                        >
                        @error('date')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

<!-- Category -->
<div class="form-group">
    <label for="category_id" class="form-label">Category *</label>
    <select 
        id="category_id" 
        name="category_id" 
        class="form-select @error('category_id') error @enderror"
        required
    >
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

                    <!-- Read Time -->
                    <div class="form-group">
                        <label for="read_time" class="form-label">Read Time *</label>
                        <input 
                            type="text" 
                            id="read_time" 
                            name="read_time" 
                            class="form-input @error('read_time') error @enderror" 
                            placeholder="e.g., 5 min read"
                            value="{{ old('read_time', $article->read_time) }}"
                            required
                        >
                        @error('read_time')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Image URL -->
                    <div class="form-group full-width">
                        <label for="image" class="form-label">Image Path *</label>
                        <input 
                            type="text" 
                            id="image" 
                            name="image" 
                            class="form-input @error('image') error @enderror" 
                            placeholder="images/your-image.jpg"
                            value="{{ old('image', $article->image) }}"
                            required
                        >
                        <small class="form-hint">Current: {{ $article->image }}</small>
                        @error('image')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Summary -->
                    <div class="form-group full-width">
                        <label for="summary" class="form-label">Summary *</label>
                        <textarea 
                            id="summary" 
                            name="summary" 
                            rows="3" 
                            class="form-textarea @error('summary') error @enderror" 
                            placeholder="Write a brief summary of your article..."
                            required
                        >{{ old('summary', $article->summary) }}</textarea>
                        @error('summary')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="form-group full-width">
                        <label for="content" class="form-label">Article Content *</label>
                        <textarea 
                            id="content" 
                            name="content" 
                            rows="12" 
                            class="form-textarea @error('content') error @enderror" 
                            placeholder="Write your full article content here..."
                            required
                        >{{ old('content', $article->content) }}</textarea>
                        @error('content')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('articles.show', $article) }}" class="btn-secondary">
                        <span>←</span> Cancel
                    </a>
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" class="btn-primary">
                            <span>💾</span> Update Article
                        </button>
                    </div>
                </div>
            </form>

            <!-- Delete Section -->
            <div class="danger-zone">
                <h3>🗑️ Danger Zone</h3>
                <p>Once you delete this article, there is no going back. Please be certain.</p>
                <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        Delete Article
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection