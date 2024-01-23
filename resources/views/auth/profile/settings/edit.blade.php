@extends('layout')

@section('content')
    <button data-session-message="" data-alert-type="" class="show-alert-button hidden"></button>
    @if (session('error'))
        @push('js')
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const SHOW_ALERT_BUTTON = document.querySelector(".show-alert-button")
                    if (SHOW_ALERT_BUTTON) {
                        SHOW_ALERT_BUTTON.setAttribute("data-alert-type", "error")
                        SHOW_ALERT_BUTTON.setAttribute("data-session-message", "{{ session('error') }}");
                        SHOW_ALERT_BUTTON.click()
                    }
                })
                document.querySelector(".show-alert-button").click()
            </script>
        @endpush
    @endif
    <section class="flex h-full flex-col justify-between">
        <form enctype="multipart/form-data" method="POST" action="{{ route('profile.update') }}"
            class="grid gap-y-4 border border-gray-600 p-12">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-x-4">
                <input class="border-1 app-rounded border-gray-400 px-3 py-4" type="text" name="name"
                    placeholder="Name">
                <input class="border-1 app-rounded border-gray-400 px-3 py-4" type="text" name="nick_name"
                    placeholder="Nickname">
            </div>
            <input class="app-rounded bg-gray-600 px-3 py-4" type="file" name="avatar_src">
            <textarea class="app-rounded px-4 py-2" name="bio" placeholder="A cool description for your post">{{ $auth->bio }}</textarea>
            <select class="border-1 app-rounded border-gray-400 px-3 py-4" type="text" name="gender">
                @foreach ($gender_choices as $key => $val)
                    <option @selected($auth->gender == $val) value="{{ $val }}">{{ $key }}</option>
                @endforeach
            </select>
            <div class="flex gap-x-2 text-gray-50">
                <label>Delete Current Profile Picture</label>
                <input type="checkbox" name="destroy_avatar">
            </div>
            <button type="submit"
                class="app-rounded w-full bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
        </form>
    </section>
@endsection
