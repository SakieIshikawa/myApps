<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

use App\Post;
use App\Profile;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        // $cond_title が空白でない場合は、記事を検索して取得する
        if ($cond_title != '') {
            $posts = Post::where('title', $cond_title).orderBy('updated_at', 'desc')->get();
        } else {
            $posts = Post::all()->sortByDesc('updated_at');
        }

        if (count($posts) > 0) {
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

        // post/index.blade.php ファイルを渡している
        // View テンプレートにheadline、 posts、 cond_title という変数を渡している
        return view('post.index', ['headline' => $headline, 'posts' => $posts, 'cond_title' => $cond_title]);
    }

  public function profile(Request $request) 
    {
        $cond_name = $request->cond_name;

        //$cond_name が空白でない場合は、記事を検索して取得する
        if ($cond_name != '') {
            $profiles = Profile::where('name', $cond_name).orderBy('updated_at', 'desc')->get();
        } else {
            $profiles = Profile::all()->sortByDesc('updated_at');
        }
        //post/profile.blade.php ファイルを渡している
        // View テンプレートに profiles、 cond_name という変数を渡している
    return view('post.profile', ['profiles' => $profiles, 'cond_name' => $cond_name]);
    }
}