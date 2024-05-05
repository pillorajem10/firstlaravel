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
     public function index(Request $request)
     {
         $name = $request->input('name');
         $category = $request->input('category');
         $categories = Category::all();

         $productsQuery = Product::orderBy('created_at', 'desc');

         if ($name !== null && $name !== '') {
             $productsQuery->where('name', 'like', '%' . $name . '%');
         }

         if ($category !== null && $category !== '') {
             $productsQuery->where('category_id', $category);
         }

         $products = $productsQuery->paginate(10);

         $urlParams = [];
         if ($name !== null && $name !== '') {
             $urlParams['name'] = $name;
         }

         if ($category !== null && $category !== '') {
             $urlParams['category'] = $category;
         }

         $url = count($urlParams) > 0 ? route('products.index', $urlParams) : route('products.index');

         return view('products.index')->with('products', $products)
                                       ->with('categories', $categories)
                                       ->with('url', $url);
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
                preg_match('/shit|fuck/i', $value) && $fail('Inappropriate words in product name are not allowed.');
            }],
            'description' => ['required', function($attribute, $value, $fail) {
                preg_match('/shit|fuck/i', $value) && $fail('Inappropriate words in product description are not allowed.');
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
        $product = Product::find($id);
        $categories = Category::all();

        $data = array(
          'product' => $product,
          'categories' => $categories
        );

        if (!isset($product)){
          return redirect('/dashboard')->with('error', 'No Product Found');
        }

        if(auth()->user()->id !==$product->seller_id){
            return redirect('/dashboard')->with('error', 'Product not found.');
        }

        return view('products.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', function($attribute, $value, $fail) {
                if (preg_match('/shit|fuck/i', $value)) {
                    Log::info('Inappropriate words in product name: ' . $value);
                    $fail('Inappropriate words in product name are not allowed.');
                }
            }],
            'description' => ['required', function($attribute, $value, $fail) {
                if (preg_match('/shit|fuck/i', $value)) {
                    Log::info('Inappropriate words in product description: ' . $value);
                    $fail('Inappropriate words in product description are not allowed.');
                }
            }],
            'price' => ['required', 'numeric'],
            'stocks' => ['required', 'numeric'],
            // 'image' => ['required', 'image', 'max:1999'],
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
        }

        // Create Post
        $product = Product::find($id);
        $product->id = $randomId;
        $product->seller_id = auth()->user()->id;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->stocks = $request->input('stocks');
        // $product->image = $fileNameToStore;
        if($request->hasFile('image')){
            $product->image = $fileNameToStore;
        }
        $product->save();

        return redirect('/dashboard')->with('success', 'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        //Check if post exists before deleting
        if (!isset($product)){
          return redirect('/dashboard')->with('error', 'No Product Found');
        }

        /*if($product->image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }*/

        $product->delete();
        return redirect('/dashboard')->with('success', 'Product Removed');
    }
}
