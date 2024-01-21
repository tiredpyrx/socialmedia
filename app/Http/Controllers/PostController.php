<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('front.post.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($request->hasFile('src')) {
            $file = $request->file('src');
            $fileName = $file->getClientOriginalName(); // file name and extension
            $file->move(public_path('images/posts/' . $user->nick_name), $fileName);
            $path = 'images/posts/' . $user->nick_name . '/'. $fileName;
            $post = new Post();
            $post->src = $path;
        }


        $post->fill([
            'caption' => $request->caption,
            'description' => $request->description,
            'post_id' => auth()->id()
        ]);

        $post->save();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $filled_datas = array_filter($request->all());
        
        $post = Post::all()->find($id);
        $user = auth()->user();

        if ($request->src) {
            $file = $request->file('src');
            $fileName = $file->getClientOriginalName();
            $old_path = $post->src;
            if ($old_path) File::delete($old_path);
            $file->move(public_path('images/posts/'. $user->nick_name . '/'), $fileName);
            $path = 'images/posts/' . $user->nick_name .'/'. $fileName;
            $post->src = $path;
            // $file = $request->file('avatar_src');
            // $old_path = $user->avatar_src;
            // $fileName = $file->getClientOriginalName();
            // $file->move(public_path('images/profiles/' . $user->nick_name . '/avatars/'), $fileName);
            // $path = 'images/profiles/' . $user->nick_name . '/avatars/' . $fileName;
            // $post->src = $path;
            unset($filled_datas['src']);
        }

        $hide_likes = $request->has('hide_likes');

        if ($hide_likes) {
            $post->hide_likes = true;
        } else {
            $post->hide_likes = false;
        }
        
        $post->update($filled_datas);

        $post->save();

        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
