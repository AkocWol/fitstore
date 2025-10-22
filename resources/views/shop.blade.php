@extends('layouts.app')
@section('title', 'Shop')

@section('content')
<div class="container py-5" x-data x-init="$nextTick(() => { if ($store.shop?.init) $store.shop.init() })">

  {{-- Header --}}
  <div class="text-center mb-4">
    <h1 class="fw-bold">Shop Our Health Essentials</h1>
    <p class="text-muted">Curated products to help you feel and perform better.</p>
  </div>

  @includeIf('shop.partials._alerts')

  <div class="row g-4">
    {{-- Zijbalk: alleen filters --}}
    <aside class="col-lg-3">
      @includeIf('shop.partials._filters')
    </aside>

    {{-- Producten --}}
    <section class="col-lg-9">

      {{-- Toolbar: Search (links) + Sort (rechts) --}}
      <div class="row g-2 align-items-center mb-3">
        <div class="col-12 col-lg-8">
          @includeIf('shop.partials._search-bar')
        </div>
        <div class="col-12 col-lg-4 text-lg-end">
          @includeIf('shop.partials._sort-bar')
        </div>
      </div>

      {{-- Grid --}}
      <div id="grid">
        @include('shop.grids._product-grid', ['products' => $products])
      </div>

      {{-- Pagination --}}
      <div id="pagination" class="mt-3">
        @include('shop.partials._pagination', ['paginator' => $products])
      </div>
    </section>
  </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
  const fromQS = () => Object.fromEntries(new URLSearchParams(window.location.search));

  Alpine.store('shop', {
    state: {
      q:         '{{ request('q') }}',
      sort:      '{{ request('sort', 'newest') }}',
      category:  '{{ request('category') }}',
      min_price: {{ request('min_price') !== null && request('min_price') !== '' ? (int)request('min_price') : 'null' }},
      max_price: {{ request('max_price') !== null && request('max_price') !== '' ? (int)request('max_price') : 'null' }},
      page:      '{{ request('page', 1) }}',
    },

    init() {
      // Paginatie links intercepten (event delegation)
      document.addEventListener('click', (e) => {
        const a = e.target.closest('#pagination a.page-link');
        if (!a) return;
        e.preventDefault();
        const url = new URL(a.href);
        this.fromQuery(url.searchParams);
        this.apply({ keepPage: true });
      });
    },

    fromQuery(qs) {
      this.state.q         = qs.get('q') || '';
      this.state.sort      = qs.get('sort') || 'newest';
      this.state.category  = qs.get('category') || '';
      this.state.min_price = qs.get('min_price') ? Number(qs.get('min_price')) : null;
      this.state.max_price = qs.get('max_price') ? Number(qs.get('max_price')) : null;
      this.state.page      = qs.get('page') || 1;
    },

    toQuery() {
      const p = new URLSearchParams();
      if (this.state.q) p.set('q', this.state.q);
      if (this.state.sort && this.state.sort !== 'newest') p.set('sort', this.state.sort);
      if (this.state.category) p.set('category', this.state.category);
      if (this.state.min_price != null && this.state.min_price !== '') p.set('min_price', this.state.min_price);
      if (this.state.max_price != null && this.state.max_price !== '') p.set('max_price', this.state.max_price);
      if (this.state.page && this.state.page !== 1) p.set('page', this.state.page);
      return p;
    },

    clear(key) {
      this.state[key] = (key.includes('price')) ? null : '';
      this.state.page = 1;
      this.apply();
    },

    async apply({ keepPage = false } = {}) {
      if (!keepPage) this.state.page = 1;

      const qs = this.toQuery();
      qs.set('partial', '1');

      const resp = await fetch(`{{ route('shop') }}?` + qs.toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      if (!resp.ok) return;

      const data = await resp.json();
      document.querySelector('#grid').innerHTML = data.grid;
      document.querySelector('#pagination').innerHTML = data.pagination;

      // URL netjes bijwerken (zonder ?partial=1)
      const fullQs = this.toQuery();
      history.replaceState(null, '', `{{ route('shop') }}?` + fullQs.toString());
    },
  });
});
</script>
@endpush
