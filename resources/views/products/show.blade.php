@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <img src="/storage/images/{{$product->image}}" alt="{{$product->name}}" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2>{{$product->name}}</h2>
                    <p class="text-muted">{{$product->description}}</p>
                    <p><strong>Price:</strong> ${{$product->price}}</p>
                    <p><strong>Stocks:</strong> {{$product->stocks}}</p>
                    <button class="btn btn-primary btn-lg">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
