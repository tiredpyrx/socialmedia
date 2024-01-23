<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    const ALLOWED_EXTENSIONS = [
        "jpg",
        "jpeg",
        "png",
        "avif",
        "webp"
    ];

    const EXTENSION_ERROR = [
        'plural' => "uploaded files must have one of these following extensions: jpg, jpeg, png, webp, avif",
        'singular' => "uploaded file must have one of these following extensions: jpg, jpeg, png, webp, avif"
    ];

    protected $fillable = [
        'user_id',
        'caption',
        'description',
    ];

    protected $hidden = [
        
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function images() {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function likedByUsers() {
        return $this->belongsToMany(User::class, 'post_user_like');
    }
}
