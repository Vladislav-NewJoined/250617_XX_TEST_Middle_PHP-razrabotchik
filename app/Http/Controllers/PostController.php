<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $posts;

    public function __construct()
    {
        $this->posts = collect(require base_path('data/posts.php'));
    }

    public function index(Request $request)
    {
        $viewedPosts = session('viewed_posts', []);

        $filtered = $this->posts->filter(function ($post) use ($viewedPosts) {
            return !in_array($post['id'], $viewedPosts) && $post['views_count'] <= 1000;
        });

        $sorted = $filtered->sortByDesc('hotness')->values();

        return response()->json($sorted->take(20));
    }

    public function markAsViewed(Request $request, $id)
    {
        $viewedPosts = session('viewed_posts', []);

        if (!in_array($id, $viewedPosts)) {
            $viewedPosts[] = (int)$id;
            session(['viewed_posts' => $viewedPosts]);
        }

        return response()->json(['message' => "Пост с ID $id отмечен как просмотренный."]);
    }
}
