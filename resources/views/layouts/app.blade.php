<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArticleHub - Latest Articles')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">
    @stack('styles')
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
                <button class="theme-toggle" id="themeToggle">🌙</button>
                <button class="search-toggle" id="searchToggle">🔍</button>
                <button class="nav-toggle" id="navToggle">☰</button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-bar" id="searchBar">
            <div class="container">
                <form action="{{ route('articles.index') }}" method="GET" class="search-input-wrapper">
                    <input type="text" name="search" placeholder="Cari artikel..." id="searchInput" value="{{ request('search') }}">
                    <button type="submit" class="search-btn">🔍</button>
                </form>
            </div>
        </div>
    </header>

    <main class="main">
        @if(session('success'))
            <div class="alert-container">
                <div class="container">
                    <div class="alert alert-success">
                        <span>✓</span> {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-container">
                <div class="container">
                    <div class="alert alert-error">
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
                        <a href="#" class="social-link">📘</a>
                        <a href="#" class="social-link">🐦</a>
                        <a href="#" class="social-link">📷</a>
                        <a href="#" class="social-link">💼</a>
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
                    <h3>Newsletter</h3>
                    <p>Berlangganan untuk mendapat artikel terbaru</p>
                    <div class="newsletter-form">
                        <input type="email" placeholder="Email anda..." id="newsletterEmail">
                        <button type="submit" id="subscribeBtn">✈</button>
                    </div>
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

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>