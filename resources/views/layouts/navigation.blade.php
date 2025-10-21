<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
  <div class="container">
    {{-- Brand --}}
    <a class="navbar-brand fw-bold" href="{{ url('/') }}">
      <i class="bi bi-activity me-2 text-primary"></i> FitStore
    </a>

    {{-- Toggler --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Content --}}
    <div class="collapse navbar-collapse" id="mainNav">
      {{-- Left: nav links --}}
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        {{-- Shop (altijd zichtbaar) --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->is('shop*') ? 'active fw-semibold' : '' }}" href="{{ url('/shop') }}">
            <i class="bi bi-bag me-1"></i> Shop
          </a>
        </li>

        @auth
          @php($cartCount = session('cart_count', 0))
          {{-- Cart (alleen ingelogd) --}}
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('cart') ? 'active fw-semibold' : '' }}" href="{{ route('cart') }}">
              <i class="bi bi-cart3 me-1"></i> Cart
              @if($cartCount > 0)
                <span class="badge bg-primary ms-1">{{ $cartCount }}</span>
              @endif
            </a>
          </li>

          {{-- Checkout (alleen ingelogd) --}}
          <li class="nav-item">
            <a class="nav-link {{ request()->is('checkout') ? 'active fw-semibold' : '' }}" href="{{ url('/checkout') }}">
              <i class="bi bi-credit-card me-1"></i> Checkout
            </a>
          </li>
        @endauth
      </ul>

      {{-- Right: auth actions --}}
      <ul class="navbar-nav mb-2 mb-lg-0">
        @guest
          @if (Route::has('login'))
            <li class="nav-item me-2">
              <a class="btn btn-outline-primary" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right me-1"></i> Log In
              </a>
            </li>
          @endif
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="btn btn-primary" href="{{ route('register') }}">
                <i class="bi bi-person-plus me-1"></i> Register
              </a>
            </li>
          @endif
        @else
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
              </button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
