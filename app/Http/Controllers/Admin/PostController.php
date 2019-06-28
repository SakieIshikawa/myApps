<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;    
// 追加するとmodelが使えるようになる

class PostController extends Controller
{
  public function add()
  {
    return view('admin/post/create');
  }
  
  public function create(Request $request)
  {
      // Varidation
      $this->validate($request, Post::$rules);

      $post = new Post;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$post->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $post->image_path = basename($path);
      } else {
          $post->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $post->fill($form);
      $post->save();

    // admin/post/createにリダイレクトする
    return redirect('admin/post/create');
  } 

  // index Actionは一覧の表示画面
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Post::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてを取得する
          $posts = Post::all();
      }
      return view('admin.post.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }

  // edit Actionは編集画面
  public function edit(Request $request)
  {
      // Modelからデータを取得する
      $posts = Post::find($request->id);
      if (empty($posts)) {
        abort(404);    
      }
      return view('admin.post.edit', ['post_form' => $posts]);
  }

  // update Actionは編集画面から送信されたフォームデータを処理する
  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Post::$rules);
      // Modelからデータを取得
      $posts = Post::find($request->id);
      // 送信されてきたフォームデータを格納
      $post_form = $request->all();

      if (isset($post_form['image'])) {
        $path = $request->file('image')->store('public/image');
        $posts->image_path = basename($path);
        unset($post_form['image']);
      } elseif (0 == strcmp($request->remove, 'true')) {
        $posts->image_path = null;
      }
      unset($post_form['_token']);
      unset($post_form['remove']);

      // 該当するデータを上書きして保存する
      $posts->fill($post_form);
      $posts->save();

      return redirect('admin/post');
  }

  // delete Action  削除用
  public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $posts = Post::find($request->id);
      // 削除する
      $posts->delete();
      return redirect('admin/post/');
  }
}