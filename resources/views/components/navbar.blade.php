<nav class="navbar navbar-expand-md navbar-dark bg-dark p-1">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('snapShopLogo.png') }}" alt="Logo" width="150" height="80">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/posts">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/products">Products</a>
                </li>
                @auth
                    @if(auth()->user()->role == 2)
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="/categories">Categories</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle fs-5" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->fname }} {{ Auth::user()->lname }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <a class="dropdown-item" href="/posts/create">Create Post</a>
                            <a class="dropdown-item" href="/dashboard">Dashboard</a>
                            @auth
                                @if(auth()->user()->role == 1)
                                    <a class="dropdown-item" href="/products/create">Add Product</a>
                                @endif
                            @endauth

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
