<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- Preconnect untuk external resources --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    {{-- DNS Prefetch untuk performance --}}
    <link rel="dns-prefetch" href="//cdn.example.com">
    
    <title>@yield('title', 'ArticleHub - Latest Articles')</title>
    
    {{-- CSS dengan cache busting --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ config('app.asset_version', '1.0') }}">
    
    {{-- Preload critical resources --}}
    <link rel="preload" href="{{ asset('css/style.css') }}" as="style">
    
    @stack('styles')

    {{-- Performance monitoring (optional) --}}
    <script>
        // Catat waktu navigation start
        window.navigationStart = performance.now();
    </script>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="{{ route('articles.index') }}" style="text-decoration: none; color: inherit;">
                    <span>📰 ArticleHub</span>
                </a>
            </div>
            
            <nav class="nav-menu" id="navMenu">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.index') ? 'active' : '' }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('articles.index') }}#articles" class="nav-link">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('articles.create') }}" class="nav-link {{ request()->routeIs('articles.create') ? 'active' : '' }}">
                            ➕ Add Article
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('articles.index') }}#about" class="nav-link">About Us</a>
                    </li>
                </ul>
            </nav>

            <div class="nav-actions">
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">🌙</button>
                <button class="search-toggle" id="searchToggle" aria-label="Toggle search">🔍</button>
                <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">☰</button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-bar" id="searchBar">
            <div class="container">
                <form action="{{ route('articles.index') }}" method="GET" class="search-input-wrapper">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari artikel..." 
                        id="searchInput" 
                        value="{{ request('search') }}"
                        aria-label="Search articles"
                    >
                    <button type="submit" class="search-btn" aria-label="Submit search">🔍</button>
                </form>
            </div>
        </div>
    </header>

    <main class="main">
        @if(session('success'))
            <div class="alert-container">
                <div class="container">
                    <div class="alert alert-success" role="alert">
                        <span>✓</span> {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-container">
                <div class="container">
                    <div class="alert alert-error" role="alert">
                        <span>✕</span> {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <span>📰 ArticleHub</span>
                    </div>
                    <p>Platform artikel terbaik untuk semua topik menarik dan informatif.</p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">📘</a>
                        <a href="#" class="social-link" aria-label="Twitter">🐦</a>
                        <a href="#" class="social-link" aria-label="Instagram">📷</a>
                        <a href="#" class="social-link" aria-label="LinkedIn">💼</a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('articles.index') }}">Home</a></li>
                        <li><a href="{{ route('articles.index') }}#articles">Articles</a></li>
                        <li><a href="{{ route('articles.create') }}">Add Article</a></li>
                        <li><a href="{{ route('articles.index') }}#about">About Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Categories</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('articles.index', ['category' => 'technology']) }}">Technology</a></li>
                        <li><a href="{{ route('articles.index', ['category' => 'design']) }}">Design</a></li>
                        <li><a href="{{ route('articles.index', ['category' => 'business']) }}">Business</a></li>
                    </ul>
                </div>
                
               <div class="footer-section">
    <h3>Categories</h3>
    <ul class="footer-links">
        @foreach(\App\Models\Category::limit(5)->get() as $category)
            <li>
                <a href="{{ route('articles.index', ['category' => $category->slug]) }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 ArticleHub. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Defer script loading untuk performance --}}
    <script defer src="{{ asset('js/app.js') }}?v={{ config('app.asset_version', '1.0') }}"></script>
    @stack('scripts')

    {{-- Lazy load analytics/tracking scripts --}}
    <script>
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPerformanceMonitoring);
        } else {
            initPerformanceMonitoring();
        }

        function initPerformanceMonitoring() {
            // Log performance metrics
            window.addEventListener('load', function() {
                const perfData = window.performance.timing;
                const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
                console.log('Page Load Time:', pageLoadTime + 'ms');
            });
        }
    </script>
</body>
</html>