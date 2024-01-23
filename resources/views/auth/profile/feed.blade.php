@extends('layout')

@section('content')
    <div class="mx-auto w-8/12">
        @foreach ($posts as $post)
            @include('components.boxes.post_box')
        @endforeach
    </div>
@endsection
