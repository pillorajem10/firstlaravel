<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        // check first if authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }
    
        // Get the currently authenticated user
        $user = Auth::user();
    
        // Retrieve the carts associated with the user where checkedout is false
        $carts = $user->carts()->where('checkedout', false)->get();
    
        // Calculate the total price
        $total = $carts->sum(function($cart) {
            return $cart->products->sum(function($product) {
                return $product->price * $product->pivot->quantity;
            });
        });
    
        // Log the carts for debugging
        Log::info('Cartssssssssssss ' . $carts);
    
        // Return a view with the carts data and total
        return view('carts.index', compact('carts', 'total'));
    }   

    public function store(Request $request)
    {
        // check first if authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please log in fist before you do that action.');
        }

        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $user = Auth::user();
    
        // Find or create the cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id, 'checkedout' => false]);

        // Generate a unique ID for the cart if it's new
        if ($cart->wasRecentlyCreated) {
            do {
                $randomId = mt_rand(100000, 999999); // Generate a random 6-digit number
            } while (Cart::where('id', $randomId)->exists());
    
            $cart->id = $randomId;
            $cart->save();
        }
    
        // Generate a unique ID for the pivot record
        $pivotId = mt_rand(100000, 999999); // Generate a random 6-digit number
        while ($cart->products()->wherePivot('id', $pivotId)->exists()) {
            $pivotId = mt_rand(100000, 999999); // Regenerate if the ID already exists
        }
    
        // Check if the product is already in the cart
        $existingProduct = $cart->products()->where('product_id', $request->product_id)->first();
    
        if ($existingProduct) {
            // Update the quantity if the product is already in the cart
            $existingProduct->pivot->quantity += $request->quantity;
            $existingProduct->pivot->save();
        } else {
            // Add the new product to the cart with the generated pivot ID
            $cart->products()->attach($request->product_id, [
                'quantity' => $request->quantity,
                'id' => $pivotId,
            ]);
        }
    
        // Update the total in the cart
        $total = $cart->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });
    
        // Update the total and save the cart
        $cart->total = $total;
        $cart->save();
    
        return redirect()->back()->with('success', 'Product added to cart!');
    }    
    
    public function show($cartid, $cartproductid)
    {
        // Check if authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Get the cart by ID
        $cart = Cart::findOrFail($cartid);

        // Check if the authenticated user owns the cart
        if ($cart->user_id !== Auth::id()) {
            return redirect('/carts')->with('error', 'Unauthorized access to cart.');
        }

        // Get the cart product by ID
        $cartProduct = $cart->products()->wherePivot('id', $cartproductid)->first();

        if (!$cartProduct) {
            return redirect('/carts')->with('error', 'Product not found in the cart.');
        }

        // Return the cart product details view
        return view('carts.show', compact('cart', 'cartProduct'));
    }

    public function update(Request $request, $cartid, $cartproductid)
    {
        // Check if authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }
    
        // Get the cart by ID
        $cart = Cart::findOrFail($cartid);
    
        // Check if the authenticated user owns the cart
        if ($cart->user_id !== Auth::id()) {
            return redirect('/carts')->with('error', 'Unauthorized access to cart.');
        }
    
        // Validate the request data
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Get the cart product by ID in the pivot table
        $cartProduct = $cart->products()->wherePivot('id', $cartproductid)->first();
    
        if (!$cartProduct) {
            return redirect('/carts')->with('error', 'Product not found in the cart.');
        }
    
        // Update the quantity in the pivot table
        $cart->products()->updateExistingPivot($cartProduct->id, [
            'quantity' => $request->quantity,
        ]);
    
        // Recalculate the total for the cart
        $total = 0;
        foreach ($cart->products as $product) {
            $total += $product->price * $product->pivot->quantity;
        }
    
        // Update the total in the carts table
        $cart->update([
            'total' => $total,
        ]);
    
        // Return a success response
        return redirect('/carts')->with('success', 'Cart updated successfully');
    }         

    public function destroy($cartid, $cartproductid)
    {
        // Check if authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Get the cart by ID
        $cart = Cart::findOrFail($cartid);

        // Check if the authenticated user owns the cart
        if ($cart->user_id !== Auth::id()) {
            return redirect('/carts')->with('error', 'Unauthorized access to cart.');
        }

        // Get the cart product by ID in the pivot table
        $cartProduct = $cart->products()->wherePivot('id', $cartproductid)->first();

        if (!$cartProduct) {
            return redirect('/carts')->with('error', 'Product not found in the cart.');
        }

        // Update the total for the cart
        $total = $cart->total - ($cartProduct->price * $cartProduct->pivot->quantity);

        // Update the total in the carts table
        $cart->update([
            'total' => $total,
        ]);

        // Detach the cart product from the cart
        $cart->products()->detach($cartProduct->id);

        // Return a success response
        return redirect('/carts')->with('success', 'Cart product deleted successfully');
    }

}

