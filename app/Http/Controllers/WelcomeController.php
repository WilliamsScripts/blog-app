<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class WelcomeController extends Controller
{
    /**
     * Show the list of posts
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
        return view('welcome', compact('posts'));
    }

    public function post(Post $post)
    {
        return view('post', compact('post'));
    }
}
