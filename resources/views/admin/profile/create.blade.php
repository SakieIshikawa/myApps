
<!--  layouts/profile.blade.phpを読み込む
      profile.blade.phpの@yield('title')に'プロフィール'を埋め込む
      profile.blade.phpの@yield('content')に以下のタグを埋め込む　　-->
@extends('layouts.admin')
@section('title', 'Profile新規作成')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>新規登録</h2>
                <form action="{{ action('Admin\ProfileController@create') }}" method="post" enctype="multipart/form-data">
                <!-- バリデーションでエラーを見つけたときには、Laravel が自動的に $errors という変数にエラーを格納
                $errors は配列で、その要素がある場合はエラーと見なし、エラーメッセージを表示します。-->

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="name">氏名</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-2" for="gender">性別</label>
                      <div class="col-md-2">
                      <input type="radio" id="gender1" name="gender" value="男性" class="form-control" value="{{ old('gender.value') }}">
                          <label for="gender1">男性</label>
                        <input type="radio" id="gender2" name="gender" value="女性" class="form-control" value="{{ old('gender.value') }}">
                          <label for="gender2">女性</label>
                      </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="hobby">趣味</label>
                        <div class="col-md-10">
                          <input type="text" class="form-control" name="hobby" value="{{ old('hobby') }}">  
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="introduction">自己紹介</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="introduction" rows="10">{{ old('introduction') }}</textarea>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <div class='btn-center'>
                      <input type="submit" class="btn btn-primary" value="Sign up">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection