@extends('layouts.app')


@section('header')
    @include('partials.header',
                [
                    'title' => 'My Posts',
                    'subtitle' => Auth::user()->name,
                    'image' => asset('img/about-bg.jpg')
                ])
@endsection

@section('content')
<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($posts->count() > 0)
            <form action="{{ route('home') }}" method="GET">
                <div class="input-group">
                    <input type="search" class="form-control" placeholder="Search..." name="search" value="{{ request('search') }}" />
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            <hr />

            @foreach ($posts as $post)
                @include('partials.post-preview', ['post' => $post])
            @endforeach

            {{ $posts->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        @else
            <div class="text-center">
                <p class="text-muted"><i>No post found. Click the button below to create a post.</i></p>
                <a href="{{ route('post.create') }}" class="btn btn-primary">Create Post</a>
            </div>
        @endif
    </div>
</div>
@endsection
