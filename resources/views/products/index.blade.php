@extends('layouts.app')

@section('content')
  <div class="container">
    <h1 class="text-center my-4">Discover Our Products</h1>

    <form action="{{ route('products.index') }}" method="GET" class="mb-4">
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Search by name" value="{{ request()->input('name') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </div>
        </div>
        <div class="input-group mb-3">
            <select class="form-control" name="category">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request()->input('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
            </div>
        </div>
    </form>

    <div class="row row-cols-1 row-cols-md-3">
      @forelse($products as $product)
        <div class="col mb-4">
          <div class="card h-100 border-0 shadow bg-white">
            <div>
              <img class="card-img-top w-100 h-100 object-cover" src="/storage/images/{{$product->image}}" alt="{{$product->name}}">
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
              <div>
                <h5 class="card-title">{{$product->name}}</h5>
              </div>
              <div>
                <p class="card-text text-primary font-weight-bold">Price: ₱{{$product->price}}</p>
                <a href="/products/{{$product->id}}" class="btn btn-primary">View Details</a>
              </div>
            </div>
          </div>
        </div>
      @empty
        <p class="text-center">No products found</p>
      @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
      {{$products->links()}}
    </div>
  </div>
@endsection
