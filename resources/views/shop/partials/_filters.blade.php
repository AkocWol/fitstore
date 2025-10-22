<div class="card border-0 shadow-sm">
  <div class="card-body">
    <h6 class="fw-bold mb-3">Filters</h6>

    <form class="vstack gap-3" x-on:change="$store.shop.apply()">

      {{-- Category (optioneel; werkt alleen als je een 'category' kolom hebt) --}}
      <div>
        <label class="form-label">Category</label>
        <select name="category" class="form-select form-select-sm"
                x-model="$store.shop.state.category">
          <option value="">All</option>
          <option value="supplements">Supplements</option>
          <option value="hydration">Hydration</option>
          <option value="recovery">Recovery</option>
          <option value="snacks">Snacks</option>
        </select>
      </div>

      {{-- Alleen Max price --}}
      <div>
        <label class="form-label d-flex justify-content-between align-items-center">
          <span>Max price (€)</span>
          <span class="badge text-bg-light">
            <span x-text="$store.shop.state.max_price ?? '—'"></span>
          </span>
        </label>

        <input
          type="range" min="0" max="500" step="1"
          class="form-range"
          x-model.number="$store.shop.state.max_price"
          x-on:input.debounce.250ms="$store.shop.apply()">

        {{-- Fallback voor non-JS/hard refresh --}}
        <input type="hidden" name="max_price" :value="$store.shop.state.max_price ?? ''">
      </div>

    </form>
  </div>
</div>
