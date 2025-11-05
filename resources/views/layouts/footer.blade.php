<footer class="mt-auto bg-white border-top py-3">
  <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center text-muted small">
    <div class="mb-2 mb-sm-0">
      © {{ date('Y') }} FitStore
    </div>

    <div>
      <a href="{{ route('about') }}" class="text-decoration-none text-muted me-3">
        About
      </a>
      <a href="{{ url('/shop') }}" class="text-decoration-none text-muted">
        Shop
      </a>
    </div>
  </div>
</footer>
