<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$posts = Post::all();
        //return Post::where('title', 'Post Two')->get();
        //$posts = DB::select('SELECT * FROM posts');
        //$posts = Post::orderBy('title','desc')->take(1)->get();
        //$posts = Post::orderBy('title','desc')->get();
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', function ($attribute, $value, $fail) {
                if (preg_match('/shit|fuck|ass/i', $value)) {
                    $fail('Inappropriate words in title are not allowed.');
                }
            }],
            'body' => ['required', function ($attribute, $value, $fail) {
                if (preg_match('/shit|fuck|ass/i', $value)) {
                    $fail('Inappropriate words in post body are not allowed.');
                }
            }],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate a random ID
        $randomId = mt_rand(100000, 999999); // Generate a random 6-digit number
        while (Post::where('id', $randomId)->exists()) {
            $randomId = mt_rand(100000, 999999); // Regenerate if the ID already exists
        }

        // Create Post
        $post = new Post;
        $post->id = $randomId;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', function ($attribute, $value, $fail) {
                if (preg_match('/shit|fuck|ass/i', $value)) {
                    $fail('Inappropriate words in title are not allowed.');
                }
            }],
            'body' => ['required', function ($attribute, $value, $fail) {
                if (preg_match('/shit|fuck|ass/i', $value)) {
                    $fail('Inappropriate words in posts not allowed.');
                }
            }],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $post = Post::find($id);

        // Update Post
        $post->title = $request->input('title');
        $post->body = $request->input('body');

        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        //Check if post exists before deleting
        if (!isset($post)){
          return redirect('/posts')->with('error', 'No Post Found');
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }
}
