<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at','desc')->paginate(10);

        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check() || Auth::user()->role != 1) return redirect('/');
        $categories = Category::all();
        return view('products.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', function($attribute, $value, $fail) {
                preg_match('/shit|fuck|ass/i', $value) && $fail('Inappropriate words in product name are not allowed.');
            }],
            'description' => ['required', function($attribute, $value, $fail) {
                preg_match('/shit|fuck|ass/i', $value) && $fail('Inappropriate words in product description are not allowed.');
            }],
            'price' => ['required', 'numeric'],
            'stocks' => ['required', 'numeric'],
            'image' => ['required', 'image', 'max:1999'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate a random ID
        $randomId = mt_rand(100000, 999999); // Generate a random 6-digit number
        while (Product::where('id', $randomId)->exists()) {
            $randomId = mt_rand(100000, 999999); // Regenerate if the ID already exists
        }

        // Handle File Upload
        if($request->hasFile('image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Post
        $product = new Product;
        $product->id = $randomId;
        $product->seller_id = auth()->user()->id;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->stocks = $request->input('stocks');
        $product->image = $fileNameToStore;
        $product->save();

        return redirect('/products')->with('success', 'Product Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!isset($product)){
          return redirect('/products')->with('error', 'No Product Found');
        }

        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
