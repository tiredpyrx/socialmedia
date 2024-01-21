<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'src',
        'caption',
        'description',
    ];

    protected $hidden = [
        
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'post_id', 'id');
    }

    public function likedByUsers() {
        return $this->belongsToMany(User::class);
    }
}
