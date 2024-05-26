@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{$product->name}}" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2>{{$product->name}}</h2>
                    <p class="text-muted">{{$product->description}}</p>
                    <p><strong>Price:</strong> ₱{{$product->price}}</p>
                    <p><strong>Stocks:</strong> {{$product->stocks}}</p>
                    <form method="POST" action="{{ route('carts.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg mt-2">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
