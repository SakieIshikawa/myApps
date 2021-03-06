@extends('layouts.admin')
@section('title', '登録済み記事の一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\PostController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\PostController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-post col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">タイトル</th>
                                <th width="50%">本文</th>
                                <th width="10%">編集</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $posts)
                                <tr>
                                    <th>{{ $posts->id }}</th>
                                    <td>{{ str_limit($posts->title, 100) }}</td>
                                    <td>{{ str_limit($posts->body, 250) }}</td>
                                    <td>
                                        <div>
                                          <a href="{{ action('Admin\PostController@edit', ['id' => $posts->id]) }}">編集</a>
                                        </div>
                                        <div>
                                          <a href="{{ action('Admin\PostController@delete', ['id' => $posts->id]) }}">削除</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection