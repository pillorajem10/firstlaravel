<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PagesController extends Controller
{
    public function index() {
      $title = 'First Laravel!';
      // return view('pages.index', compact('title'));
      return view('pages.index')->with('title', $title);
    }

    public function about() {
      $title = 'About page';
      // return view('pages.about');
      return view('pages.about')->with('title', $title);
    }

    public function services() {
      $data = array(
        'title' => 'Services page',
        'services' => ['Design', 'Development', 'Create']
      );

      // return view('pages.services');
      return view('pages.services')->with($data);
    }
}
