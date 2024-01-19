@extends('layout')

@section('content')
    <div class="border border-gray-400 p-12">
        <form method="POST" action="{{ route('post.create') }}" method="POST" class="grid gap-4" enctype="multipart/form-data">
            @csrf
            <input required class="border-1 rounded-sm border-gray-400 px-3 py-4" type="text" name="caption" placeholder="Post caption">
            <input required class="bg-gray-600 rounded-sm px-3 py-4 text-white" type="file" name="src">
            <textarea class="px-4 py-2 rounded-sm" name="description" placeholder="A cool description for your post"></textarea>
            <button type="submit"
                class="w-full rounded-sm bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
        </form>
    </div>
@endsection
