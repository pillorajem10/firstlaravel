@extends('layouts.app')

@section('content')
  <div class="container">
    <h1 class="text-center my-4">Discover Our Products</h1>

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
