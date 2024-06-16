<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\UserAuth;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', UserAuth::class]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $posts = Post::query();
        $posts = $posts->where('user_id', auth()->user()->id);

        if ($request->has('search')) {
            $search = $request->search;
            $posts = $posts->where(function($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('body', 'LIKE', '%' . $search . '%');
            });
        }

        $posts = $posts->latest()->paginate(10);
        return view('home', compact('posts'));
    }
}
