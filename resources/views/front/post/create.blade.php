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
    <div class="flex h-full items-center justify-center">
        <form method="POST" action="{{ route('post.store') }}" method="POST"
            class="mx-auto grid w-fit gap-3 border border-app-white p-12" enctype="multipart/form-data">
            @csrf
            <label class="flex flex-col">
                <div class="mb-2 text-base text-app-white">Post caption</div>
                <input class="border-1 app-rounded border-gray-400 px-3 py-4" type="text" name="caption"
                    placeholder="{{ primarySetDefault(trim($auth->posts->last()?->caption), 'My new car!!') }}">
            </label>
            <label class="flex flex-col">
                <div class="mb-2 text-base text-app-white">Image/s</div>
                <input class="app-rounded bg-gray-600 px-3 py-4 text-white" type="file" name="files[]" multiple>
            </label>
            <label class="flex flex-col">
                <div class="mb-2 text-base text-app-white">Description</div>
                <textarea class="app-rounded px-4 py-2" name="description"
                    placeholder="{{ primarySetDefault(trim($auth->posts->last()?->description), 'I got a new car...') }}"></textarea>
            </label>
            <button type="submit"
                class="app-rounded mt-2 w-full bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
        </form>
    </div>
@endsection
