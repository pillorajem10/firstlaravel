@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Edit Product</h1>
    <p>You may edit your product here, make sure all fields are filled.</p>

    <form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT') <!-- Use PUT method for updating -->

      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" />
      </div>
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="5">{{ $product->description }}</textarea>
      </div>
      <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}" />
      </div>
      <div class="form-group">
        <label for="stocks">Stocks:</label>
        <input type="text" class="form-control" id="stocks" name="stocks" value="{{ $product->stocks }}" />
      </div>
      <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" class="form-control" id="image" name="image" value="{{ $product->image }}" />
        @if($product->image)
          <img src="/storage/images/{{$product->image}}" alt="{{$product->name}}" style="max-width: 200px; margin-top: 10px;" />
        @endif
      </div>
      <div class="form-group">
          <label for="category_id">Category:</label>
          <select class="form-control" id="category_id" name="category_id">
              <option value="">Select category</option>
              @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
              @endforeach
          </select>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
  </div>
@endsection
