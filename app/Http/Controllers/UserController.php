<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;

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
        } else if ($request->has('gender')) {
            $user->gender = $request->gender;
            $file_path = $user->getUserAvatarPathByGender($user->id);
            $user->avatar_src = env('APP_URL') . $file_path;
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

    public function show(?string $id = '')
    {
        $user = User::find($id);
        $posts = $user->posts;
        // foreach ($posts as $post) {
        //     $post->load('likedByUsers');
        // }
        return view('auth.profile.index', ['posts' => $posts, 'user' => $user]);
    }

    public function settings()
    {
        return view('auth.profile.settings.index');
    }

    public function edit()
    {
        $auth = auth()->user();
        return view('auth.profile.settings.edit', ['auth' => $auth, 'gender_choices' => User::GENDER_CHOICES]);
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
            if ($old_path && !str_contains(strtolower($old_path), 'profiles/avatars/default')) File::delete($old_path);
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('images/profiles/' . $user->nick_name . '/avatars/'), $fileName);
            $path = 'images/profiles/' . $user->nick_name . '/avatars/' . $fileName;
            $user->avatar_src = env('APP_URL') . $path;
        }


        if (!$request->has('avatar_src') && $request->has('gender') && $request->gender != $user->gender) {
            $user->avatar_src = $user->getUserAvatarPathByGender($user->id, $request->gender);
        }

        $canAvatarBeDeleted = !$request->has('avatar_src') && !str_contains(strtolower($user->avatar_src), 'profiles/avatars/default/') && $request->has('destroy_avatar');

        if ($canAvatarBeDeleted) {
            $default_avatar_path = $user->getUserAvatarPathByGender($user->id);
            $user->avatar_src = $default_avatar_path;
        }

        $user->gender = $request->gender;

        if (array_key_exists('avatar_src', $filled_datas)) unset($filled_datas['avatar_src']);



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

    public function like_post(string $id)
    {
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

    public function destroy()
    {
        $user = User::all()->find(auth()->user()->id);
        $user->delete();
        session()->flush();
        return redirect()->route('login.show');
    }
}
