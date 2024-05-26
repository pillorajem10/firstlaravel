@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('storage/images/' . $cartProduct->image) }}" alt="{{ $cartProduct->name }}" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2>{{ $cartProduct->name }}</h2>
                    <p>{{ $cartProduct->description }}</p>
                    <form method="POST" action="{{ route('carts.update', ['cart' => $cart->id, 'cartproductid' => $cartProduct->pivot->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="product_id" value="{{ $cartProduct->id }}">
                        <div class="form-group">
                            <label for="quantity"><strong>Quantity:</strong></label>
                            <input type="number" id="quantity" name="quantity" value="{{ $cartProduct->pivot->quantity }}" min="1" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
