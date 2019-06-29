<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;


class ProfileController extends Controller
{
  public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
  {

      $this->validate($request, Profile::$rules);

      $profiles = new Profile;
      $form = $request->all();

     
      
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
    
      // データベースに保存する
      $profiles->file($form);
      $profiles->save();

      return redirect('admin/profile/create');
  }
    public function index(Request $request)
    {
      $cond_name = $request->cond_name;
        if ($cond_name != '') {
          // 検索されたら検索結果を取得する
          $posts = Profile::where('name', $cond_name)->get();
        } else {
          // それ以外はすべての名前を取得する
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_name' => $cond_name]);
    }
    
    public function edit(Request $request)
    {
      // Modelからデータを取得する
      $profiles = Profile::find($request->id);
      if (empty($profiles)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profile_form' => $profiles]);
    }

    public function update(Request $request)
  {
      $this->validate($request, Profile::$rules);
      $profiles = Profile::find($request->id);
      $profile_form = $request->all();

      unset($profile_form['_token']);

      // 該当するデータを上書きして保存する
      $profiles->fill($profile_form);
      $profiles->save();

      return redirect('admin/profile');
  }
    
     // delete Action  削除用
    public function delete(Request $request)
    {
      $profiles = Profile::find($request->id);
      $profiles->delete();
      return redirect('admin/profile/');
    }
  }
