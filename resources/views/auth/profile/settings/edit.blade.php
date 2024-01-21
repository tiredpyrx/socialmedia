@extends('layout')

@section('content')
    <section class="h-full flex flex-col justify-between">
        <form enctype="multipart/form-data" method="POST" action="{{ route('profile.update') }}" class="border border-gray-600 p-12 grid gap-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-x-4">
                <input class="border-1 app-rounded border-gray-400 px-3 py-4" type="text" name="name" placeholder="Name">
                <input class="border-1 app-rounded border-gray-400 px-3 py-4" type="text" name="nick_name" placeholder="Nickname">
            </div>
            <input class="bg-gray-600 app-rounded px-3 py-4 text-white" type="file" name="avatar_src">
            <textarea class="px-4 py-2 app-rounded" name="bio" placeholder="A cool description for your post"></textarea>
            <select class="border-1 app-rounded border-gray-400 px-3 py-4" type="text" name="gender">
                <option value="{{ null }}">I don't want to share</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <button type="submit"
                class="w-full app-rounded bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
        </form>
    </section>
@endsection
