@extends('layouts.app')

@section('content')
  <div class="container">
    <a href="/categories" class="btn btn-secondary mt-3">Go Back</a>
    <div class="card mt-3">
      <div class="card-body">
        <h1 class="card-title">{{$category->name}}</h1>
        <p class="card-text"><small class="text-muted">{{$category->created_at}}</small></p>
      </div>
    </div>
    <div class="mt-3">
      <a href="/categories/{{$category->id}}/edit" class="btn btn-primary">Edit</a>
      <form method="POST" action="{{ route('categories.destroy', ['category' => $category->id]) }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
      </form>
    </div>
  </div>
@endsection
