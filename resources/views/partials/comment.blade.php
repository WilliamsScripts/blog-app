<div class="d-flex border-bottom py-3">
    <div class="flex-shrink-0 pt-1">
        <i class="fa fa-user-circle text-muted"></i>
    </div>
    <div class="flex-grow-1 ms-3 ml-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
            <h6 class="mb-0">{{ auth()->user()->id === $comment->user->id ? "You" : $comment->user->name }} <small class="text-muted"><i>Posted on {{ \Carbon\Carbon::parse($comment->created_at)->format('M d, Y') }}</i></small></h6>

            @auth()
                @if (auth()->user()->id === $comment->user->id || auth()->user()->role === 'admin')
                    <div>
                        <button type="button" class="btn py-0 px-1 text-danger"
                            onclick="event.preventDefault(); document.getElementById('delete-comment-form-{{ $comment->id }}').submit();">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                @endif

                <form id="delete-comment-form-{{ $comment->id }}" action="{{ route('comment.destroy', $comment->id) }}" method="POST" class="d-none">
                    @method('DELETE')
                    @csrf
                </form>
            @endauth
        </div>
        <small class="text-muted mb-0">{{ $comment->body }}</small>
    </div>
</div>
