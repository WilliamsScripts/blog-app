@extends('layouts.admin')

@section('content')
<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
        <p class="mb-5">{!! $post->body !!}</p>

        <div class="card border-0">
            <div class="card-header">Comments ({{ $post->comments()->count() }})</div>
            <div class="card-body">
                @if ($post->comments()->count() > 0)
                    @foreach ($post->comments as $comment)
                        @include('partials.comment', ['comment' => $comment])
                    @endforeach
                @else
                    <small class="text-center text-muted">This post has no comment</small>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
