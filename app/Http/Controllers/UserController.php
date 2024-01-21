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
        $credentials = [
            'nick_name' => $request->nick_name,
            'password' => $request->password
        ];

        Auth::attempt($credentials);
        return redirect()->route('home');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'min:2'],
            'nick_name' => ['required', 'string', 'min:3', 'lowercase'],
            'gender' => 'in:null,male,female,other|nullable',
            'email' => ['email', 'unique:users'],
            'password' => [
                'required',
                'max:255',
                Password::min(8)
                    ->numbers()
                    ->mixedCase()
            ]
        ]);

        $user = new User();

        if ($request->file('avatar_src')) {
            $file = $request->file('avatar_src');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('images/profiles/' . $request->nick_name . '/avatars/'), $fileName);
            $file_path = 'images/profiles/' . $request->nick_name . '/avatars/' . $fileName;
            
            $user->avatar_src = $file_path;
        } else {
            if ($credentials['gender'] === null) {
                $fileName = 'nogender';
            }
            else if ($credentials['gender'] === 'male') {
                $fileName = 'male';
            }
            if ($credentials['gender'] === 'female') {
                $fileName = 'female';
            }

            $file_path = 'images/profiles/avatars/default/' . $fileName . '.jpeg';
            $user->avatar_src = $file_path;
        }

        if (array_key_exists('gender', $credentials)) {
            $user->gender = $request->gender;
        }


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

    public function create()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function show_profile()
    {
        if (!auth()->check()) {
            return redirect()->route('login.show');
        }
        $posts = auth()->user()->posts;
        return view('auth.profile.index', ['posts' => $posts]);
    }

    public function settings()
    {
        return view('auth.profile.settings.index');
    }

    public function edit()
    {
        return view('auth.profile.settings.edit');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $filled_datas = array_filter($request->all(), function ($data) {
            if ($data) return true;
        });

        if ($request->file('avatar_src')) {
            $file = $request->file('avatar_src');
            $old_path = $user->avatar_src;
            if ($old_path) File::delete($old_path);
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('images/profiles/' . $user->nick_name . '/avatars/'), $fileName);
            $path = 'images/profiles/' . $user->nick_name . '/avatars/' . $fileName;
            $user->avatar_src = $path;
        }

        if (array_key_exists('avatar_src', $filled_datas)) unset($filled_datas['avatar_src']);

        $user->gender = $request->gender;

        $user->update($filled_datas);
        $user->save();

        return redirect()->route('profile.settings');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function like_post(string $id) {
        $user = auth()->user();

        /** @var \App\Models\User $user */
        $post = Post::all()->find($id);
        if ($post->likedByUsers()->find($user->id)) {
            $user->likedPosts()->detach($id);
            return redirect()->back();
        }
        $user->likedPosts()->attach($id);

        return redirect()->back();
    }
}
