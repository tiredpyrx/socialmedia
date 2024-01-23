@extends('layout')

@section('content')
    <div class="grid gap-2 text-blue-600">
        <div>
            <a href="{{ route('profile.edit') }}">
                Edit Profile
            </a>
        </div>
        <div>
            <a href="{{ route('profile.feed') }}">
                My Feed
            </a>
        </div>
        <div>
            <a href="{{ route('profile.advanced') }}">
                Advanced
            </a>
        </div>
    </div>
    <form class="fixed right-5 bottom-4" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="app-rounded bg-green-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Log out</button>
    </form>
@endsection