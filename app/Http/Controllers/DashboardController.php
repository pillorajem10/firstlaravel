<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function index()
     {
         $user_id = auth()->user()->id;
         $user = User::find($user_id);

         if (Auth::check() && Auth::user()->role === 1) {
           return view('sellerDashboard')->with('products', $user->products);
         } else {
           return view('dashboard')->with('posts', $user->posts);
         }
     }
}
