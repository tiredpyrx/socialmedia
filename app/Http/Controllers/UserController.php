<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File; 

class UserController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            return view('front.home.index');
        }

        return redirect()->route('login.show');
    }

    public function login(Request $request, User $user)
    {
        $credentials = $request->validate([
            'name' => 'string|min:2',
            'email' => 'email',
            'password' => 'min:2|max:255'
        ]);

        Auth::attempt($credentials);
        return redirect('/');
    }

    public function create(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'min:2'],
            'nick_name' => ['required', 'string', 'min:3', 'lowercase'],
            // 'avatar_src' => ['mimes:jpg,png,jpeg,avif', 'extensions:jpg,png,jpeg,avif'],
            'email' => ['email', 'unique:users'],
            'password' => [
                'required',
                'max:255',
                Password::min(8)
                    ->numbers()
                    ->mixedCase()
            ]
        ]);

        $file = $request->file('avatar_src');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('images/profiles/'.$request->nick_name.'/avatars/'), $fileName);
        $file_path = 'images/profiles/'.$request->nick_name.'/avatars/'.  $fileName;
        $user = new User();
        $user->avatar_src = $file_path;
        $user->fill($credentials);
        $user->save();
        return redirect()->route('login.show');
    }

    public function show_login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function show_create()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function create_post(Request $request)
    {

        if ($request->hasFile('src')) {
            $file = $request->file('src');
            $fileName = $file->getClientOriginalName(); // file name and extension
            $file->move(public_path('images/posts/'), $fileName);
            $path = 'images/posts/' . $fileName;
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

    public function show_profile()
    {
        if (!auth()->check()) {
            return redirect()->route('login.show');
        }
        return view('auth.profile.index');
    }

    public function show_edit()
    {
        return view('auth.profile.edit');
    }

    public function edit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $filled_datas = array_filter($request->all(), function($data) {
            if ($data) return true;
        });

        if ($request->file('avatar_src')) {
            $file = $request->file('avatar_src');
            $old_path = $user->avatar_src;
            if ($old_path) File::delete($old_path);
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('images/profiles/'. $user->nick_name. '/avatars/'), $fileName);
            $path = 'images/profiles/'. $user->nick_name. '/avatars/'. $fileName;
            $user->avatar_src = $path;
        }

        if ($filled_datas['avatar_src']) unset($filled_datas['avatar_src']);

        $user->update($filled_datas);
        $user->save();

        return redirect()->route('profile.show');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
