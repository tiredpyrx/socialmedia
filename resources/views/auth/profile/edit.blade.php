@extends('layout')

@section('content')
    <section class="h-full flex flex-col justify-between">
        <form enctype="multipart/form-data" method="POST" action="{{ route('profile.edit') }}" class="border border-gray-600 p-12 grid gap-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-x-4">
                <input class="border-1 rounded-sm border-gray-400 px-3 py-4" type="text" name="name" placeholder="Name">
                <input class="border-1 rounded-sm border-gray-400 px-3 py-4" type="text" name="nick_name" placeholder="Nickname">
            </div>
            <input class="bg-gray-600 rounded-sm px-3 py-4 text-white" type="file" name="avatar_src">
            <textarea class="px-4 py-2 rounded-sm" name="bio" placeholder="A cool description for your post"></textarea>
            <button type="submit"
                class="w-full rounded-sm bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
        </form>
        <form class="w-full text-right" action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="rounded-sm bg-green-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Log out</button>
        </form>
    </section>
@endsection
