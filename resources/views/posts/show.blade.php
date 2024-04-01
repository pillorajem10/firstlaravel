@extends('layouts.app')

@section('content')
  <a href="/posts" class="btn btn-default">Go Back</a>
  <h1>{{$post->title}}</h1>
  <p>{{$post->body}}</p>
  <small>{{$post->created_at}}</small>
  <div>
   <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
   <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}" style="display:inline;">
     @csrf
     @method('DELETE')
     <button type="submit" class="btn btn-danger">Delete</button>
   </form>
 </div>
@endsection
