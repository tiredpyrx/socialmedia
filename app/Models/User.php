<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const GENDER_CHOICES = [
        'I don\'t want to share' => 'nogender',
        'Male' => 'male',
        'Female' => 'female',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nick_name',
        'src',
        'bio',
        'email',
        'password',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'user_id', 'id');
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_like');
    }

    public function getUserAvatarPathByGender(string $id, ?string $gender = '')
    {
        $user = User::all()->find($id);
        $gender = $gender ? $gender : $user->gender;
        $file_path = env('APP_URL') . 'images/profiles/avatars/default/' . $gender . '.jpeg';

        return $file_path;
    }

    
}
