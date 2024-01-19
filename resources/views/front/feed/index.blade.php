@extends('layout')

@section('content')
    <div class="mx-auto grid w-5/12 gap-y-6">
        @if (!count($posts))
            <p class="text-center text-sm text-white">Sorry, we don't have nothing to show you for now :(</p>
        @endif
        @foreach ($posts as $post)
            <div class="grid overflow-hidden rounded-sm">
                <figure>
                    <img class="w-full" src="{{ $post->src }}" alt="">
                </figure>
                <div class="min-h-24 bg-gray-600 px-3 pb-3 pt-4">
                    <h6 class="font-semibold text-gray-50">{{ shortenText($post->caption, 32) }}</h6>
                    <p class="mt-0.5 text-sm text-gray-200">
                        {{ shortenText($post->description) }}
                    </p>
                    <a href="goes_to_profile" class="mt-4 flex w-fit items-center py-1 pr-4">
                        <img class="rounded-full" src="https://i.ibb.co/L1LQtBm/Ellipse-1.png" alt="avatar" />
                        <span class="ml-2 font-normal text-white">{{ $post->user->name }}</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
