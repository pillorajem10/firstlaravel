@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Seller Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($products->count() > 0)
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow bg-white">
                                        <img class="card-img-top w-100 h-100 object-cover" src="/storage/images/{{$product->image}}" alt="{{$product->name}}">
                                        <div class="card-body d-flex flex-column justify-content-end">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <div class="card-text">₱{{ $product->price }}</div>
                                            <div class="card-text">QTY: {{ $product->stocks }}</div>
                                            <!--<a href="/products/{{$product->id}}/edit" style="display:inline;" class="btn mb-2 btn-outline-primary">Update</a> -->
                                            <div>
                                              <a href="/products/{{$product->id}}/edit" style="display:inline;" class="btn mb-2 btn-outline-primary">Update</a>
                                              <form method="POST" action="{{ route('products.destroy', ['product' => $product->id]) }}" style="display:inline; margin-top: .5rem;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                              </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No products available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
