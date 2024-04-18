@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Posts</h1>
    <p>This is the posts page</p>

    @if(count($posts) > 0)
      <div class="list-group">
        @foreach($posts as $post)
          <a href="/posts/{{$post->id}}" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{$post->title}}</h5>
              <small>Written on {{$post->created_at}}</small>
            </div>
          </a>
        @endforeach
      </div>
      {{$posts->links()}}
    @else
      <p>No posts found</p>
    @endif
  </div>
@endsection
