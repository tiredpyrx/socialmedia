@extends('layout')

@section('content')
    <div class="mx-auto grid w-5/12 gap-y-6">
        @if (!count($posts))
            <p class="text-center text-sm text-white">Sorry, we don't have nothing to show you for now :(</p>
        @endif
        @foreach ($posts as $post)
            @include('components.boxes.post_box')
        @endforeach
    </div>
@endsection
