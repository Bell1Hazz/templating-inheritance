<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'date',
        'category',
        'summary',
        'content',
        'image',
        'read_time'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    // Scope untuk filter category
    public function scopeCategory($query, $category)
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }
        return $query;
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%");
        }
        return $query;
    }
}