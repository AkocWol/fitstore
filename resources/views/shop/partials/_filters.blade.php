<div class="card border-0 shadow-sm mt-4">
  <div class="card-body">
    <h6 class="fw-bold mb-3">Filters</h6>
    <form method="GET" class="vstack gap-3">
      <div>
        <label class="form-label">Category</label>
        <select name="category" class="form-select form-select-sm">
          <option value="">All</option>
          <option value="supplements" @selected(request('category')==='supplements')>Supplements</option>
          <option value="hydration" @selected(request('category')==='hydration')>Hydration</option>
          <option value="recovery" @selected(request('category')==='recovery')>Recovery</option>
          <option value="snacks" @selected(request('category')==='snacks')>Snacks</option>
        </select>
      </div>
      <div>
        <label class="form-label">Max Price (€)</label>
        <input
          type="number"
          name="max_price"
          class="form-control form-control-sm"
          value="{{ request('max_price') }}"
          min="0"
          step="0.01">
      </div>
      <button class="btn btn-primary btn-sm w-100">Filter</button>
    </form>
  </div>
</div>
