<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'src',
        'caption',
        'description',
    ];

    protected $hidden = [
        'post_id'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'post_id', 'id');
    }
}
