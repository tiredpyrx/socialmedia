<?php

use App\Models\Post;
use App\Models\User;

function shortenText($text, $max = 200) {
    $string = strlen($text) > $max ? substr($text, 0, $max).'...' : $text;
    return $string;
}


function isOwnerPost(Post $post) {
    $user = auth()->user();
    return $post->post_id === $user->id;
}

function isPostLikedByAuth(string $post_id) {
    $user = auth()->user();
    $post = Post::all()->find($post_id);
    return $post->likedByUsers()->find($user->id);
}