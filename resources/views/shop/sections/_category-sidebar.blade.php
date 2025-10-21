<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">
    <h6 class="fw-bold mb-3">Categories</h6>
    <div class="list-group list-group-flush">
      @foreach(($categories ?? ['Supplements','Hydration','Recovery','Snacks']) as $c)
        <a href="{{ url('/shop?category='.\Illuminate\Support\Str::slug($c)) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          <span>{{ $c }}</span>
          <i class="bi bi-chevron-right small"></i>
        </a>
      @endforeach
    </div>
  </div>
</div>
