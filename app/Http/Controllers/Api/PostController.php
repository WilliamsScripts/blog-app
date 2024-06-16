<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Requests\Api\PostRequest;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query();

        if ($request->has('search')) {
            $search = $request->search;
            $posts = $posts->where(function($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('body', 'LIKE', '%' . $search . '%');
            });
        }

        $records = $posts->latest()->paginate(10);
        $collection = PostResource::collection($records);
        $data = Controller::createPaginatedData($records, $collection);
        return Controller::sendResponse('Posts fetched successfully', $data);
    }

    public function store(PostRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $post = Post::create($data);
        $record = PostResource::make($post);
        return Controller::sendResponse('Posts created successfully', $record);
    }

    public function show(Post $post)
    {
        $record = PostResource::make($post);
        return Controller::sendResponse('Post detail retrieved successfully', $record);
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->all();
        $post->update($data);
        $post->refresh();
        $record = PostResource::make($post);
        return Controller::sendResponse('Post updated successfully', $record);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id === auth()->user()->id) {
            $post->delete();
            return Controller::sendResponse('Post deleted successfully');
        } else {
            return Controller::sendError('You do not have permission to delete this post', 403);
        }
    }
}
