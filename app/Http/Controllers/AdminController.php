<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\AdminAuth;
use App\Models\Post;
use App\Http\Requests\PostRequest;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', AdminAuth::class]);
    }

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

        $posts = $posts->latest()->paginate(10);
        return view('admin.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.manage-post');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        Post::create($data);
        return redirect()->route('admin.post.index')->with('success', 'Post created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.manage-post', compact('post'));
    }

        /**
     * Show the form for editing the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.post-detail', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $data = $request->all();
        $post->update($data);
        return redirect()->route('admin.post.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully');
    }
}
