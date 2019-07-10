@extends('layouts.admin')

@section('content')
    <div class="container">
        
  <div class="row contents">
            <div class="posts col-md-8 mx-auto mt-3">
                @foreach($posts as $post)
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="title">
                                    {{ str_limit($post->title, 150) }}
                                </div>
                                <div class="date">
                                    {{ $post->updated_at->format('Y年m月d日G時i分') }}
                                </div>
                                <div class="body mt-3">
                                    {{ str_limit($post->body, 1500) }}
                                </div>
                            </div>
                            <div class='like-icon'>
                              <i class="far fa-heart"></i>
                              <div id='counter' class='counter'></div>
                            </div>
                        </div>
                    </div>
                    <hr color="#c0c0c0">
                @endforeach
            </div>
        </div>
    </div>
@endsection