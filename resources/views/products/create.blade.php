@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Create Product</h1>
    <p>You may add a product here, make sure all fields are filled.</p>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" />
      </div>
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="5"></textarea>
      </div>
      <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" class="form-control" id="price" name="price" />
      </div>
      <div class="form-group">
        <label for="stocks">Stocks:</label>
        <input type="text" class="form-control" id="stocks" name="stocks" />
      </div>
      <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" class="form-control" id="image" name="image" />
      </div>
      <div class="form-group">
          <label for="category_id">Category:</label>
          <select class="form-control" id="category_id" name="category_id">
              <option value="">Select category</option>
              @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
          </select>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
  </div>
@endsection
