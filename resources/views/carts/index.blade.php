@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cart List</h1>
    @if($carts)
        @if(count($carts) > 0)
            <table class="table">
                <tbody>
                    @foreach($carts as $cart)
                        @foreach($cart->products as $product)
                            <tr>
                                <td class="align-middle"><img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" width="60"></td>
                                <td class="align-middle">{{ $product->name }}</td>
                                <td class="align-middle text-center">{{ $product->pivot->quantity }}</td>
                                <td class="align-middle text-end">₱{{ number_format($product->price * $product->pivot->quantity, 2) }}</td>
                                <td class="align-middle text-end">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('carts.show', ['cartid' => $cart->id, 'cartproductid' => $product->pivot->id]) }}" class="btn btn-primary me-2">View</a>
                                        <form id="delete-form" action="{{ route('carts.destroy', ['cartid' => $cart->id, 'cartproductid' => $product->pivot->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <p class="mb-0"><strong>Total: ₱{{ number_format($total, 2) }}</strong></p>
                <button class="btn btn-primary">Checkout</button>
            </div>
        @else
            <p>No items in the cart</p>
        @endif
    @else
        <p>No carts found</p>
    @endif
</div>
@endsection
