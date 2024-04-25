@extends('layouts.app')

@section('content')
  <div class="container">
      <h1>Categories</h1>
      <p>This is the category page</p>

      @if(count($categories) > 0)
          <div class="list-group">
              @foreach($categories as $category)
                  <a href="/categories/{{$category->id}}" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                          <h5 class="mb-1">{{$category->name}}</h5>
                          <small>Written on {{$category->created_at}}</small>
                      </div>
                  </a>
              @endforeach
          </div>
          {{$categories->links()}}
      @else
          <p>No categories found</p>
      @endif

      <!-- Add Category Button -->
      <a href="/categories/create" class="btn btn-primary mt-3">Add Category</a>
  </div>
@endsection
