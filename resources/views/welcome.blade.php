@extends('layouts.app')

@section('header')
    @include('partials.header',
                [
                    'title' => 'Home',
                    'subtitle' => 'My blog app',
                    'image' => asset('img/home-bg.jpg')
                ])
@endsection

@section('content')
<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
        @if ($posts->count() > 0)
            <form action="{{ url('/') }}" method="GET">
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
            <p class="text-center text-muted"><i>No post found</i></p>
        @endif
    </div>
</div>
@endsection
