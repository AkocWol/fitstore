@php
  $imgLarge = "https://picsum.photos/seed/{$product->id}/800/480";
@endphp

<div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1"
     aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="productModalLabel{{ $product->id }}">
          {{ $product->name }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <img src="{{ $imgLarge }}" class="img-fluid rounded mb-3" alt="{{ $product->name }}">
        @if(!empty($product->description))
          <p class="text-muted mb-2">{{ $product->description }}</p>
        @endif
        <p class="fw-bold fs-5">€{{ number_format($product->price, 2) }}</p>
      </div>

      <div class="modal-footer">
  <form method="POST" action="{{ route('cart.add') }}">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="qty" value="1">
    <button class="btn btn-primary">
      <i class="bi bi-cart-plus me-1"></i> Add to Cart
    </button>
  </form>
  <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
</div>


    </div>
  </div>
</div>
