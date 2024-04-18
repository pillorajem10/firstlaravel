@extends('layouts.app')

@section('content')
  <div class="jumbotron text-center">
    @if (Auth::check())
      <h1>Hi, {{ Auth::user()->fname }}!</h1>
      <p>Welcome to First Laravel tutorial</p>
    @else
      <h1>Welcome to First Laravel Tutorial</h1>
    @endif
  </div>
@endsection
