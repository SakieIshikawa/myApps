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
      $profile = new Profile;
      $form = $request->all();

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
    
      // データベースに保存する
      $profile->fill($form);
      $profile->save();

      return redirect('admin/profile/create');
  }
  
    public function index(Request $request)
    {
      $cond_name = $request->cond_name;
        if ($cond_name != '') {
          // 検索されたら検索結果を取得する
          $list = Profile::where('name', $cond_name)->get();
        } else {
          // それ以外はすべての名前を取得する
          $list = Profile::all();
      }
      return view('admin.profile.index', ['list' => $list, 'cond_name' => $cond_name]);
    }
    
    public function edit(Request $request)
    {
      // Modelからデータを取得する
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
  {
      $this->validate($request, Profile::$rules);
      $profile = Profile::find($request->id);

       
      unset($profile_form['_token']);
      unset($profile_form['remove']);

       // 該当するデータを上書きして保存する
      $profile->fill($profile_form)->save();
 
       return redirect('admin/profile');
   }
     
     // delete Action  削除用
    public function delete(Request $request)
    {
      $profile = Profile::find($request->id);
      $profile->delete();
      return redirect('admin/profile/');
    }
  }
