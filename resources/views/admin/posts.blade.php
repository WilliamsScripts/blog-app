@extends('layouts.admin')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between mb-4" style="gap: 10px">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

    <a href="{{ route('admin.post.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-plus fa-sm text-white-50"></i> &nbsp; Create Post</a>
</div>

<form action="{{ route('admin.post.index') }}" class="mb-3" method="GET">
    <div class="input-group" style="max-width: 310px">
        <input type="search" class="form-control" placeholder="Search..." name="search" value="{{ request('search') }}">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="table-responsive mt-5 bg-white rounded">
    <table class="table table-borderless">
        <thead>
            <tr class="border-bottom text-uppercase">
                <th>SN</th>
                <th>Title</th>
                <th>Body</th>
                <th>Author</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($posts->count() > 0)
                @php
                    $sn = 1;
                @endphp
                @foreach ($posts as $post)
                    <tr class="border-bottom">
                        <td>{{ $sn++ }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{!! \Str::limit(processText($post->body), $limit = 80) !!}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->comments()->count() }}</td>
                        <td style="white-space:nowrap">
                            <a href="{{ route('admin.post.show', $post->id) }}" title="View Post" data-toggle="tooltip" class="btn btn-sm text-primary py-0 px-2">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.post.edit', $post->id) }}"  title="Edit Post" data-toggle="tooltip" class="btn btn-sm text-secondary py-0 px-2">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.post.destroy', $post->id) }}" method="POST" class="d-inline-block">
                                @method('DELETE')
                                @csrf
                                <button type="submit" title="Delete Post" data-toggle="tooltip" class="btn btn-sm text-danger py-0 px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-muted text-center">
                        No record found
                    </td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6">
                    {{ $posts->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                </th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
