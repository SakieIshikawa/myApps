<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;


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
      $profiles->fill($form);
      $profiles->save();

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
      $profiles = Profile::find($request->id);
      if (empty($profiles)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profile_form' => $profiles]);
    }

    public function update(Request $request)
  {
    // Validationをかける
    $this->validate($request, Profile::$rules);
    // Modelからデータを取得
    $profiles = Profile::find($request->input('id'));
    // 送信されてきたフォームデータを格納
    $profile_form = $request->all();

    // if ($request->input('remove')) {
    //     $profile_form['image_path'] = null;
    // } elseif ($request->file('image')) {
    //     $path = $request->file('image')->store('public/image');
    //     $profile_form['image_path'] = basename($path);
    // } else {
    //     $profile_form['image_path'] = $profiles->image_path;
    // }

    unset($profile_form['_token']);
    unset($profile_form['remove']);

    // 該当するデータを上書きして保存する
    $profiles->fill($profile_form);
    $profiles->save();

    //ライブラリCarbonを使って取得した現在時刻を、ProfileHistoryモデルのedited_atとして記録し保存
    $profile_history = new ProfileHistory;
    $profile_history->profile_id = $profiles->id;
    $profile_history->edited_at = Carbon::now();
    $profile_history->save();

    return redirect('admin/profile/');
  }  
     
     // delete Action  削除用
    public function delete(Request $request)
    {
      $profiles = Profile::find($request->id);
      $profiles->delete();
      return redirect('admin/profile/');
    }
  }
