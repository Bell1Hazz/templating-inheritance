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
                <span class="detail-category">{{ ucfirst($article->category) }}</span>
                <h1 class="detail-title">{{ $article->title }}</h1>
                <div class="detail-info">
                    <span class="detail-author">👤 {{ $article->author }}</span>
                    <span class="detail-date">📅 {{ $article->date->format('d F Y') }}</span>
                    <span class="detail-time">🕒 {{ $article->read_time }}</span>
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

            <!-- Article Footer -->
            <div class="detail-footer">
                <div class="detail-tags">
                    <span class="tag">{{ ucfirst($article->category) }}</span>
                </div>
                <div class="detail-share">
                    <span>Share this article:</span>
                    <a href="#" class="share-btn">📘</a>
                    <a href="#" class="share-btn">🐦</a>
                    <a href="#" class="share-btn">💼</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection