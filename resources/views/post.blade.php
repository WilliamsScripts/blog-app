@extends('layouts.app')

@section('header')
    @include('partials.header',
                [
                    'title' => $post->title,
                    'title_size' => 'sm',
                    'subtitle' => 'By ' .  $post->user->name . ' on ' . \Carbon\Carbon::parse($post->created_at)->format('M d, Y'),
                    'image' => asset('img/post-bg.jpg')
                ])
@endsection

@section('content')
<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
        <p class="mb-5">{!! $post->body !!}</p>

        @auth()
            <form action="{{ route('comment.store') }}" method="POST" class="mb-5">
                @csrf

                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                <div class="mb-3">
                    <label for="comment" class="form-label">New comment </label>
                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="3">{{ old('body') ?? "" }}</textarea>
                    @error('body')
                        <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        @endauth


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
