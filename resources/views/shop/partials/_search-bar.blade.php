<form method="GET" action="{{ route('shop') }}" 
      x-on:submit.prevent="$store.shop.apply()">
  <div class="input-group input-group-sm shadow-sm rounded">
    <span class="input-group-text bg-white border-end-0">
      <i class="bi bi-search text-secondary"></i>
    </span>

    <input type="search"
           name="q"
           class="form-control border-start-0"
           placeholder="Search products..."
           autocomplete="off"
           minlength="2"
           x-model.trim="$store.shop.state.q">

    <button class="btn btn-primary" type="submit"
            x-bind:disabled="!$store.shop.state.q || $store.shop.state.q.length < 2">
      Search
    </button>

    <button class="btn btn-outline-secondary" type="button"
            x-on:click="$store.shop.clear('q')"
            title="Clear search">
      <i class="bi bi-x-circle"></i>
    </button>
  </div>
</form>
