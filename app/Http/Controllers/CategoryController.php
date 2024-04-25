<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role != 2) return redirect('/');

        $categories = Category::orderBy('created_at','desc')->paginate(10);

        return view('categories.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', function ($attribute, $value, $fail) {
                if (preg_match('/shit|fuck|ass/i', $value)) {
                    $fail('Inappropriate words in name are not allowed.');
                }
            }],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate a random ID
        $randomId = mt_rand(100000, 999999); // Generate a random 6-digit number
        while (Category::where('id', $randomId)->exists()) {
            $randomId = mt_rand(100000, 999999); // Regenerate if the ID already exists
        }

        // Create Category
        $category = new Category;
        $category->id = $randomId;
        $category->name = $request->input('name');
        $category->save();

        return redirect('/categories')->with('success', $category->name . ' Category created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!isset($category)){
          return redirect('/categories')->with('error', 'No Category Found');
        }

        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);

        if (!isset($category)){
          return redirect('/categories')->with('error', 'No Category Found');
        }

        return view('categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', function ($attribute, $value, $fail) {
                if (preg_match('/shit|fuck|ass/i', $value)) {
                    $fail('Inappropriate words in name are not allowed.');
                }
            }],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = Category::find($id);

        // Update Category
        $category->name = $request->input('name');

        $category->save();

        return redirect('/categories')->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        //Check if category exists before deleting
        if (!isset($category)){
          return redirect('/categories')->with('error', 'No Category Found');
        }

        $category->delete();
        return redirect('/categories')->with('success', 'Category Removed');
    }
}
