@extends('layouts.app')
@section('title', 'Winkelwagen')

@section('content')
<div class="container py-5">
  <h1 class="fw-bold mb-4">Your cart</h1>

  {{-- Server flash messages (fallback; blijven werken zonder JS) --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if (empty($items))
    <div id="cart-empty" class="alert alert-info d-flex align-items-center justify-content-between">
      <span>Your cart is empty</span>
      <a href="{{ route('shop') }}" class="btn btn-primary">Continue shopping</a>
    </div>
  @else
    <div id="cart-panel">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th style="width:90px;">Photo</th>
              <th>Product</th>
              <th class="text-end">Price</th>
              <th style="width:160px;">Quantity</th>
              <th class="text-end">Subtotal</th>
              <th style="width:110px;"></th>
            </tr>
          </thead>
          <tbody id="cart-body">
            @foreach ($items as $line)
              @php
                // Probeer image uit cart data, anders relation, anders DB lookup, anders nette fallback
                $raw = data_get($line, 'image')
                    ?? data_get($line, 'product.image')
                    ?? optional(\App\Models\Product::find(data_get($line, 'id')))->image;

                $isAbs  = is_string($raw) && (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://'));
                $imgSrc = $raw
                  ? ($isAbs ? $raw : asset('storage/' . ltrim($raw, '/')))
                  : 'https://picsum.photos/seed/cart-'.data_get($line,'id').'/120/120';
              @endphp

              <tr data-id="{{ $line['id'] }}" data-price="{{ (float)$line['price'] }}">
                <td>
                  <img
                    src="{{ $imgSrc }}"
                    alt="{{ $line['name'] }}"
                    class="img-thumbnail"
                    style="width:70px;height:70px;object-fit:cover;"
                    onerror="this.onerror=null;this.src='https://placehold.co/120x120?text=No+Image';"
                  >
                </td>

                <td class="fw-semibold">
                  {{ $line['name'] }}
                </td>

                <td class="text-end">€{{ number_format($line['price'], 2) }}</td>

                <td>
                  {{-- Progressive enhancement: werkt zonder JS, JS onderschept submit --}}
                  <form action="{{ route('cart.update') }}" method="POST" class="d-flex gap-2 js-update">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $line['id'] }}">
                    <input type="number" name="qty" value="{{ $line['qty'] }}" min="1"
                           class="form-control form-control-sm" style="width:90px;">
                    <button class="btn btn-outline-secondary btn-sm" type="submit">Update</button>
                  </form>
                </td>

                <td class="text-end subtotal-cell">€{{ number_format($line['subtotal'], 2) }}</td>

                <td class="text-end">
                  <form action="{{ route('cart.remove') }}" method="POST" class="js-remove">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $line['id'] }}">
                    <button class="btn btn-outline-danger btn-sm" type="submit"
                            onclick="return confirm('Dit product verwijderen?')">Verwijder</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-3 gap-3">
        <form action="{{ route('cart.clear') }}" method="POST" class="js-clear" onsubmit="return confirm('Winkelwagen legen?')">
          @csrf
          <button class="btn btn-outline-secondary" type="submit">Empty cart</button>
        </form>

        <div class="ms-md-auto text-end">
          <div class="fs-5 fw-bold">Totaal: €{{ number_format($total, 2) }}</div>

          {{-- ⬇️ PLAATS HIER DEZE NIEUWE FORM --}}
          <form action="{{ route('checkout.start') }}" method="POST" class="mt-2">
            @csrf
            <button class="btn btn-primary">Go to checkout</button>
          </form>
        </div>
      </div>

    </div>
  @endif

  {{-- Toast container --}}
  <div class="position-fixed top-0 end-0 p-3" style="z-index:1080">
    <div id="cartToast" class="toast align-items-center border-0 text-white" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div id="cartToastBody" class="toast-body">—</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
  // Vereist in layout: <meta name="csrf-token" content="{{ csrf_token() }}">
  // Bootstrap bundle via CDN is al globaal beschikbaar als 'bootstrap'

  const money = (n) => new Intl.NumberFormat('nl-NL', { style:'currency', currency:'EUR' }).format(n || 0);

  function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
  }

  function showToast(message, variant='primary') {
    const toastEl = document.getElementById('cartToast');
    const bodyEl  = document.getElementById('cartToastBody');
    if (!toastEl || !bodyEl || !window.bootstrap?.Toast) return;

    // reset + kleur
    toastEl.className = 'toast align-items-center border-0 text-white';
    const map = {
      primary:'bg-primary', success:'bg-success', danger:'bg-danger',
      warning:'bg-warning text-dark', info:'bg-info text-dark', secondary:'bg-secondary'
    };
    (map[variant] || 'bg-primary').split(' ').forEach(c => toastEl.classList.add(c));
    bodyEl.textContent = message;

    const t = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 2200 });
    t.show();
  }

  function recalcTotal() {
    const rows = document.querySelectorAll('#cart-body tr[data-id]');
    let sum = 0;
    rows.forEach(r => {
      const price = parseFloat(r.dataset.price || '0');
      const qty = parseInt(r.querySelector('input[name="qty"]')?.value || '1', 10);
      sum += price * Math.max(1, qty);
    });
    const totalEl = document.getElementById('cart-total');
    if (totalEl) totalEl.textContent = money(sum);
    return rows.length;
  }

  async function postForm(url, payload) {
    const fd = new FormData();
    Object.entries(payload || {}).forEach(([k, v]) => fd.append(k, v));

    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken(),
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: fd
    });

    // We verwachten geen JSON verplicht; HTML/redirect is ook ok voor onze client-side updates
    return res.ok;
  }

  // Update qty (AJAX via FormData)
  document.addEventListener('submit', async (e) => {
    const form = e.target.closest('form.js-update');
    if (!form) return;
    e.preventDefault();

    const row = form.closest('tr[data-id]');
    const product_id = parseInt(form.querySelector('input[name="product_id"]').value, 10);
    const qty        = Math.max(1, parseInt(form.querySelector('input[name="qty"]').value, 10));

    const ok = await postForm(form.action, { product_id, qty });
    if (!ok) return showToast('couldnt change Amounth changed.', 'danger');

    const price = parseFloat(row.dataset.price || '0');
    const subEl = row.querySelector('.subtotal-cell');
    if (subEl) subEl.textContent = money(price * qty);

    recalcTotal();
    showToast('Amounth changed', 'success');
  });

  // Remove item (AJAX via FormData)
  document.addEventListener('submit', async (e) => {
    const form = e.target.closest('form.js-remove');
    if (!form) return;
    e.preventDefault();

    const row = form.closest('tr[data-id]');
    const product_id = parseInt(form.querySelector('input[name="product_id"]').value, 10);

    const ok = await postForm(form.action, { product_id });
    if (!ok) return showToast('Kon product niet verwijderen.', 'danger');

    row.remove();

    if (recalcTotal() === 0) {
      const panel = document.getElementById('cart-panel');
      if (panel) panel.remove();
      const empty = document.createElement('div');
      empty.id = 'cart-empty';
      empty.className = 'alert alert-info d-flex align-items-center justify-content-between';
      empty.innerHTML = `<span>Your cart is empty</span>
                         <a href="{{ route('shop') }}" class="btn btn-primary">Continue shopping</a>`;
      document.querySelector('.container.py-5')?.appendChild(empty);
    }

    showToast('Product verwijderd.', 'danger');
  });

  // Clear cart (AJAX via FormData)
  document.addEventListener('submit', async (e) => {
    const form = e.target.closest('form.js-clear');
    if (!form) return;
    e.preventDefault();

    const ok = await postForm(form.action, {});
    if (!ok) return showToast('Kon winkelwagen niet legen.', 'danger');

    const panel = document.getElementById('cart-panel');
    if (panel) panel.remove();

    let empty = document.getElementById('cart-empty');
    if (!empty) {
      empty = document.createElement('div');
      empty.id = 'cart-empty';
      empty.className = 'alert alert-info d-flex align-items-center justify-content-between';
      empty.innerHTML = `<span>Your cart is empty</span>
                         <a href="{{ route('shop') }}" class="btn btn-primary">Continue shopping</a>`;
      document.querySelector('.container.py-5')?.appendChild(empty);
    }

    showToast('Winkelwagen geleegd.', 'secondary');
  });
})();
</script>
@endpush
