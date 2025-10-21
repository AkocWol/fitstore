@php($trail = $trail ?? ['Shop'])
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    @foreach($trail as $i => $crumb)
      <li class="breadcrumb-item {{ $i+1===count($trail)?'active':'' }}" {{ $i+1===count($trail)?'aria-current=page':'' }}>
        {{ $crumb }}
      </li>
    @endforeach
  </ol>
</nav>
