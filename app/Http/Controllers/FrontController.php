<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function show_users(User $user) {
        $users = $user->all();
        return view('front.users.index', ['users' => $users]);
    }

    public function show_feed(Post $post) {
        $posts = $post->all();
        $post->load('likedByUsers');
        return view('front.feed.index', ['posts' => $posts]);
    }

    public function profile_feed() {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $posts = Post::all();

        return view('auth.profile.feed', ['posts' => $posts]);

    }

    
}
