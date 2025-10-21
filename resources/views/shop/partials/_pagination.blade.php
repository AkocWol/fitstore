@php
/** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
@endphp

@if($paginator instanceof \Illuminate\Contracts\Pagination\Paginator)
  <div class="mt-4 d-flex flex-column align-items-center">
    {!! $paginator->onEachSide(1)->links('pagination::bootstrap-5') !!}
    <small class="text-muted mt-2">
      Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
    </small>
  </div>
@endif
