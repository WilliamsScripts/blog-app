 <!-- Post preview-->
 <div class="post-preview">
    <a href="{{ route('post', $post->id) }}">
        <h2 class="post-title">{{ $post->title }}</h2>
        <div class="post-subtitle mb-3">{!! \Str::limit(processText($post->body), $limit = 100) !!}</div>
    </a>
    <div class="post-meta d-flex align-items-center justify-content-between">
        <p class="my-0">
            Posted by
            <span class="text-dark">{{ $post->user->name }}</span>
            on {{ \Carbon\Carbon::parse($post->created_at)->format('M d, Y') }}
        </p>

        @auth()
            @if (auth()->user()->id === $post->user_id)
                <div>
                    <a href="{{ route('post.edit', $post->id) }}" class="btn py-0 px-1 text-primary">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button type="button" class="btn py-0 px-1 text-danger"
                        onclick="event.preventDefault(); document.getElementById('delete-post-form-{{ $post->id }}').submit();">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </div>
            @endif

            <form id="delete-post-form-{{ $post->id }}" action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-none">
                @method('DELETE')
                @csrf
            </form>
        @endauth
    </div>
</div>
<hr class="my-4" />
