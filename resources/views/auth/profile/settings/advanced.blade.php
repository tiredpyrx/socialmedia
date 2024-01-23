@extends('layout')

@section('content')
    <div class="grid gap-2 text-blue-600">
        <form profile-deletion-confirm-string="{{ $auth->nick_name . '/delete' }}" disabled="true" action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            <button type="submit"
                class="app-rounded bg-green-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Delete
                My Profile</button>
        </form>
        <div class="bg-overlay spinner-wrapper fixed inset-0 z-50 hidden h-screen w-screen">
            <div class="spinner fixed left-1/2 top-1/2"></div>
        </div>
@endsection
