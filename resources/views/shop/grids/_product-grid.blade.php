<div class="row g-4">
  @forelse($products as $product)
    <div class="col-12 col-sm-6 col-lg-3">
      @include('shop.components._product-card', ['product' => $product])
    </div>
  @empty
    @include('shop.partials._empty-state')
  @endforelse
</div>
