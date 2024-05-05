@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Edit Category</h1>
    <p>You may edit your category here, make sure all fields are filled.</p>

    <form method="POST" action="{{ route('categories.update', ['category' => $category->id]) }}">
      @csrf
      <input type="hidden" name="_method" value="PUT">

      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" />
      </div>
      <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
  </div>
@endsection
