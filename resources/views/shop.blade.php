@extends('layouts.app')
@section('title', 'Shop')

@section('content')
<div class="container py-5">

  {{-- Alerts + breadcrumbs + header --}}
  @includeIf('shop.partials._alerts')
  @includeIf('shop.partials._breadcrumbs')
  @includeIf('shop.sections._header')

  {{-- Sort-bar boven de lijst --}}
  <div class="d-flex justify-content-end mb-3">
    @includeIf('shop.partials._sort-bar')
  </div>

  <div class="row g-4">
    {{-- Zijbalk met filters en categorieën --}}
    <aside class="col-lg-3">
      @includeIf('shop.partials._filters')
      <div class="mt-3">
        @includeIf('shop.partials._category-sidebar')
      </div>
    </aside>

    {{-- Producten --}}
    <section class="col-lg-9">
      {{-- Grid (gebruikt intern jouw components/_product-card & _price-badge) --}}
      @include('shop.grids._product-grid', ['products' => $products])

      {{-- Promo banner (optioneel) --}}
      <div class="my-4">
        @includeIf('shop.sections._promo-banner')
      </div>

      {{-- Paginatie --}}
      @include('shop.partials._pagination', ['paginator' => $products])

      {{-- Empty state fallback --}}
      @if($products->isEmpty())
        @include('shop.partials._empty-state')
      @endif
    </section>
  </div>
</div>

{{-- Modals (per product + quick-add) --}}
@foreach($products as $product)
  @include('shop.modals._product-modal', ['product' => $product])
@endforeach
@includeIf('shop.modals._quick-add-modal')
@endsection
