@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Edit Post</h1>
    <p>You may edit your post here, make sure all fields are filled.</p>

    <form method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}">
      @csrf
      <input type="hidden" name="_method" value="PUT">

      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" />
      </div>
      <div class="form-group">
        <label for="body">Body:</label>
        <textarea class="form-control" id="body" name="body" rows="5"></textarea>
      </div>
      <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
  </div>
@endsection
