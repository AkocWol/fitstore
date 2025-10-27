@php
/** @var \Illuminate\Pagination\LengthAwarePaginator|null $paginator */
@endphp

@if($paginator instanceof \Illuminate\Contracts\Pagination\Paginator && $paginator->hasPages())
  <div class="mt-4 d-flex flex-column align-items-center">
    {{-- Bootstrap 5 pagination --}}
    {!! $paginator->onEachSide(1)->links('pagination::bootstrap-5') !!}

    {{-- Info line --}}
    @if ($paginator->total() > 0)
      <small class="text-muted mt-2">
        Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} results
      </small>
    @endif
  </div>
@endif
