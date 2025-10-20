@extends('layouts.app')

@section('title', $article->title . ' - ArticleHub')

@section('content')
<section class="articles-section" style="margin-top: 80px;">
    <div class="container">
        <div class="article-detail">
            <!-- Back Button -->
            <div class="detail-header">
                <a href="{{ route('articles.index') }}" class="back-btn">
                    <span>←</span> Back to Articles
                </a>
                <div class="detail-actions">
                    <a href="{{ route('articles.edit', $article) }}" class="btn-edit">
                        <span>✏️</span> Edit
                    </a>
                </div>
            </div>

            <!-- Article Header -->
            <div class="detail-meta">
                <span class="detail-category" style="background: {{ $article->category->color }}">
                    {{ $article->category->name }}
                </span>
                <h1 class="detail-title">{{ $article->title }}</h1>
                <div class="detail-info">
                    <span class="detail-author">👤 {{ $article->user->name }}</span>
                    <span class="detail-date">📅 {{ $article->date->format('d F Y') }}</span>
                    <span class="detail-time">🕒 {{ $article->read_time }}</span>
                    <span class="detail-views">👁️ {{ number_format($article->views) }} views</span>
                </div>
            </div>

            <!-- Article Image -->
            <div class="detail-image">
                <img src="{{ asset($article->image) }}" alt="{{ $article->title }}">
            </div>

            <!-- Article Summary -->
            <div class="detail-summary">
                <p>{{ $article->summary }}</p>
            </div>

            <!-- Article Content -->
            <div class="detail-content">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Article Tags -->
            <div class="detail-footer">
                <div class="detail-tags">
                    @foreach($article->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="detail-share">
                    <span>Share this article:</span>
                    <a href="#" class="share-btn">📘</a>
                    <a href="#" class="share-btn">🐦</a>
                    <a href="#" class="share-btn">💼</a>
                </div>
            </div>

            <!-- Comments Section -->
            @if($article->comments->count() > 0)
            <div class="comments-section" style="margin-top: 3rem;">
                <h3>💬 Comments ({{ $article->comments->count() }})</h3>
                
                @foreach($article->comments()->whereNull('parent_id')->get() as $comment)
                    <div class="comment" style="padding: 1.5rem; background: var(--bg-secondary); border-radius: 8px; margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                            <strong>{{ $comment->user->name }}</strong>
                            <span style="color: var(--text-secondary); font-size: 0.875rem;">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p>{{ $comment->content }}</p>
                        
                        @if($comment->replies->count() > 0)
                            <div style="margin-left: 2rem; margin-top: 1rem;">
                                @foreach($comment->replies as $reply)
                                    <div class="comment-reply" style="padding: 1rem; background: var(--bg-primary); border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                            <strong>{{ $reply->user->name }}</strong>
                                            <span style="color: var(--text-secondary); font-size: 0.875rem;">
                                                {{ $reply->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p>{{ $reply->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endsection