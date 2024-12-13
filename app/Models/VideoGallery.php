<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoGallery extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = ['title', 'slug', 'url'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getEmbedUrlAttribute()
{
    $url = $this->attributes['url'] ?? null;
    
    if (!$url) {
        return null;
    }
    
    // Handle different YouTube URL formats
    $patterns = [
        '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
        '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
        '/youtu\.be\/([a-zA-Z0-9_-]+)/'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            $videoId = $matches[1];
            return 'https://www.youtube.com/embed/' . $videoId . '?enablejsapi=1&origin=' . urlencode(config('app.url'));
        }
    }
    
    return null;
}
}


