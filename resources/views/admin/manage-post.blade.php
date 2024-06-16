@extends('layouts.admin')

@push('links')
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>
@endpush

@section('content')
<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
        <form action="{{ isset($post) ? route('admin.post.update', $post->id) : route('admin.post.store') }}" method="POST" class="mb-5">
            @if (isset($post))
                @method('PUT')
            @endif
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') ?? (isset($post) ? $post->title : '') }}" />
                @error('title')
                    <p class="text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea class="@error('body') is-invalid @enderror" id="body" name="body" row='5'>
                    {!! old('body') ?? (isset($post) ? $post->body : '') !!}
                </textarea>
                @error('body')
                    <p class="text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        new FroalaEditor("#body", {
            toolbarButtons: [
                ['fontSize', 'bold', 'italic', 'underline', 'strikeThrough'],
                [ 'alignLeft', 'alignCenter', 'alignRight', 'alignJustify','textColor', 'backgroundColor'],
                ['formatOLSimple', 'formatUL', 'insertLink'],
        ]
        });
    </script>
@endpush
@endsection
