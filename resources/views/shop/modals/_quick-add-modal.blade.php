@php($id = $product['id'] ?? ($product->id ?? uniqid()))
<div class="modal fade" id="quickAdd{{ $id }}" tabindex="-1" aria-labelledby="quickAddLabel{{ $id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="{{ route('cart.add') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="quickAddLabel{{ $id }}">Quick Add: {{ $product['name'] ?? $product->name ?? 'Product' }}</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="product_id" value="{{ $id }}">
        <div class="mb-3">
          <label class="form-label">Quantity</label>
          <input type="number" name="qty" class="form-control" value="1" min="1">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i> Add</button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>
