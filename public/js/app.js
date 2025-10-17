// Theme Toggle
document.getElementById('themeToggle')?.addEventListener('click', function() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    this.textContent = newTheme === 'dark' ? '☀️' : '🌙';
});

// Search Toggle
document.getElementById('searchToggle')?.addEventListener('click', function() {
    const searchBar = document.getElementById('searchBar');
    const searchInput = document.getElementById('searchInput');
    
    searchBar.classList.toggle('active');
    
    if (searchBar.classList.contains('active')) {
        setTimeout(() => searchInput.focus(), 300);
    }
});

// Mobile Navigation Toggle
document.getElementById('navToggle')?.addEventListener('click', function() {
    const navMenu = document.getElementById('navMenu');
    
    navMenu.classList.toggle('active');
    
    if (navMenu.classList.contains('active')) {
        this.textContent = '✕';
    } else {
        this.textContent = '☰';
    }
});

// Newsletter
document.getElementById('subscribeBtn')?.addEventListener('click', function() {
    const emailInput = document.getElementById('newsletterEmail');
    const email = emailInput.value.trim();
    
    if (!email) {
        alert('Please enter your email address');
        return;
    }
    
    if (!email.includes('@')) {
        alert('Please enter a valid email address');
        return;
    }
    
    alert('Thank you for subscribing to our newsletter!');
    emailInput.value = '';
});

// Load saved theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.textContent = savedTheme === 'dark' ? '☀️' : '🌙';
    }
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});