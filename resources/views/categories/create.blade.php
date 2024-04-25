@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Create Category</h1>
    <p>You may add a post here, make sure all fields are filled.</p>

    <form method="POST" action="{{ route('categories.store') }}">
      @csrf
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" />
      </div>
      <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
  </div>
@endsection
