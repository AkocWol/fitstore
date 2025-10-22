<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'FitStore'))</title>

    {{-- Bootstrap CSS + Bootstrap Icons via CDN (snel en direct werkend) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    {{-- Navigatie (optioneel) --}}
    @includeIf('layouts.navigation')

    {{-- Optionele page header --}}
    @hasSection('header')
        <header class="bg-white border-bottom py-3">
            <div class="container">
                @yield('header')
            </div>
        </header>
    @endif

    {{-- Inhoud vult de resterende hoogte; footer zakt naar onderen --}}
    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')

            {{-- Test-icoon (mag je verwijderen): --}}
            {{-- <i class="bi bi-bag-heart fs-3 text-primary"></i> --}}
        </div>
    </main>

    {{-- Sticky footer (onderaan) --}}
    @includeIf('layouts.footer')

    {{-- Bootstrap JS (bundle met Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- >>> Alpine store vóór Alpine zelf (belangrijk!) <<< --}}
    <script>
      // 1) Server-side beginsituatie uit de querystring (safe defaults)
      window.__SHOP_STATE__ = {
        q: "{{ request('q') }}",
        sort: "{{ request('sort','newest') }}",
        category: "{{ request('category') }}",
        min_price: {{ request('min_price') !== null && request('min_price') !== '' ? (int)request('min_price') : 'null' }},
        max_price: {{ request('max_price') !== null && request('max_price') !== '' ? (int)request('max_price') : 'null' }},
        page: "{{ request('page', 1) }}"
      };

      // 2) Registreer de Alpine store tijdens initialisatie
      document.addEventListener('alpine:initializing', () => {
        const toQuery = (state) => {
          const p = new URLSearchParams();
          if (state.q) p.set('q', state.q);
          if (state.sort && state.sort !== 'newest') p.set('sort', state.sort);
          if (state.category) p.set('category', state.category);
          if (state.min_price != null && state.min_price !== '') p.set('min_price', state.min_price);
          if (state.max_price != null && state.max_price !== '') p.set('max_price', state.max_price);
          if (state.page && state.page !== 1) p.set('page', state.page);
          return p;
        };

        Alpine.store('shop', {
          state: { ...window.__SHOP_STATE__ },

          init() {
            // Intercept pagination clicks
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

          toQuery() { return toQuery(this.state); },

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

            const fullQs = this.toQuery();
            history.replaceState(null, '', `{{ route('shop') }}?` + fullQs.toString());
          },
        });
      });

      // 3) Na Alpine boot, store.init() aanroepen
      document.addEventListener('alpine:initialized', () => {
        Alpine.store('shop').init();
      });
    </script>

    {{-- Alpine zelf (moet NA het init-script komen) --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- View-specifieke scripts (bijv. @push('scripts') in shop.blade.php) --}}
    @stack('scripts')

</body>
</html>
