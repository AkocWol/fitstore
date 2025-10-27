{{-- resources/views/shop/grids/_product-grid.blade.php --}}
@if ($products->count())
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    @foreach ($products as $product)
      @php
        // Losse, robuuste placeholderlogica (zonder accessor vereist)
        $rawImg = $product->image_url ?? $product->image ?? $product->image_path ?? null;
        $isFull = is_string($rawImg) && (str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://'));
        $imgSrc = $rawImg
          ? ($isFull ? $rawImg : asset('storage/' . ltrim($rawImg, '/')))
          : 'https://placehold.co/600x400?text=Product';
      @endphp

      <div class="col">
        <div class="card h-100 shadow-sm border-0">
          <img src="{{ $imgSrc }}" class="card-img-top" alt="{{ $product->name }}">

          <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-1">{{ $product->name }}</h5>
            <p class="text-muted mb-3">€{{ number_format($product->price ?? 0, 2) }}</p>

            <p class="text-secondary small mb-3" style="min-height:2.5rem; max-height:2.5rem; overflow:hidden;">
              {{ \Illuminate\Support\Str::limit($product->description, 80) }}
            </p>

            <div class="mt-auto d-flex gap-2">
              {{-- VIEW → opent modal (event-delegation in shop.blade.php) --}}
              <button
                type="button"
                class="btn btn-outline-secondary w-50"
                data-product-view
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ number_format($product->price ?? 0, 2) }}"
                data-description="{{ trim($product->description) }}"
                data-image="{{ $imgSrc }}"
              >
                View
              </button>

              {{-- Add to cart --}}
              <form method="POST" action="{{ route('cart.add') }}" class="w-50">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="qty" value="1">
                <button class="btn btn-primary w-100" type="submit">Add</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@else
  <div class="alert alert-info text-center my-4">Geen producten gevonden.</div>
@endif
