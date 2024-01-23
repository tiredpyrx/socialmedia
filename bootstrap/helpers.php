<?php

use App\Models\Post;
use App\Models\User;

function shortenText($text, $max = 200) {
    $string = strlen($text) > $max ? substr($text, 0, $max).'...' : $text;
    return $string;
}


function isOwnerPost(Post $post) {
    $user = auth()->user();
    return $post->user_id === $user->id;
}

function isPostLikedByAuth(string $post_id) {
    $user = auth()->user();
    $post = Post::all()->find($post_id);
    return $post->likedByUsers()->find($user->id);
}

function primarySetDefault(mixed $primary, mixed $default) {
    if (!isset($default)) {
        return false;
    }
    return (isset($primary) && $primary) ? $primary : $default;
}