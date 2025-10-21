<div class="text-center mb-4">
  <h1 class="fw-bold">{{ $title ?? 'Shop' }}</h1>
  @isset($subtitle)
    <p class="text-muted">{{ $subtitle }}</p>
  @endisset
</div>
