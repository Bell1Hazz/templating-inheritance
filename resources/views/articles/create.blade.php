@extends('layouts.app')

@section('title', 'Add New Article - ArticleHub')

@section('content')
<section class="form-section">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h1>✍️ Create New Article</h1>
                <p>Share your knowledge with the world</p>
            </div>

            <form action="{{ route('articles.store') }}" method="POST" class="article-form" id="articleForm">
                @csrf
                
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
                            value="{{ old('title') }}"
                            required
                        >
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Author -->
                    <div class="form-group">
                        <label for="author" class="form-label">Author Name *</label>
                        <input 
                            type="text" 
                            id="author" 
                            name="author" 
                            class="form-input @error('author') error @enderror" 
                            placeholder="Your name..."
                            value="{{ old('author') }}"
                            required
                        >
                        @error('author')
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
                            value="{{ old('date', date('Y-m-d')) }}"
                            required
                        >
                        @error('date')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label for="category" class="form-label">Category *</label>
                        <select 
                            id="category" 
                            name="category" 
                            class="form-select @error('category') error @enderror"
                            required
                        >
                            <option value="">Select a category</option>
                            <option value="technology" {{ old('category') == 'technology' ? 'selected' : '' }}>Technology</option>
                            <option value="design" {{ old('category') == 'design' ? 'selected' : '' }}>Design</option>
                            <option value="business" {{ old('category') == 'business' ? 'selected' : '' }}>Business</option>
                            <option value="lifestyle" {{ old('category') == 'lifestyle' ? 'selected' : '' }}>Lifestyle</option>
                            <option value="health" {{ old('category') == 'health' ? 'selected' : '' }}>Health</option>
                        </select>
                        @error('category')
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
                            value="{{ old('read_time') }}"
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
                            value="{{ old('image') }}"
                            required
                        >
                        <small class="form-hint">Upload image to public/images/ folder and enter the path here</small>
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
                        >{{ old('summary') }}</textarea>
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
                        >{{ old('content') }}</textarea>
                        @error('content')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('articles.index') }}" class="btn-secondary">
                        <span>←</span> Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <span>📝</span> Publish Article
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Character counter for summary
    const summaryTextarea = document.getElementById('summary');
    if (summaryTextarea) {
        summaryTextarea.addEventListener('input', function() {
            const maxLength = 200;
            const currentLength = this.value.length;
            
            if (currentLength > maxLength) {
                this.value = this.value.substring(0, maxLength);
            }
        });
    }
</script>
@endpush