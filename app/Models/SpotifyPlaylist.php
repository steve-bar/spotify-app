<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SpotifyPlaylist extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'spotify_id',
        'name',
        'description',
        'public',
        'tracks_count',
        'image_url',
        'data',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return Storage::disk('public')->url($value);
        }

        return asset('default-playlist-image.png'); // Provide a default image
    }
}
