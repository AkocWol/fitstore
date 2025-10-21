<form method="GET" class="d-flex gap-2">
  <select name="sort" class="form-select form-select-sm">
    <option value="">Sort</option>
    <option value="newest" @selected(request('sort')==='newest')>Newest</option>
    <option value="price_asc" @selected(request('sort')==='price_asc')>Price ↑</option>
    <option value="price_desc" @selected(request('sort')==='price_desc')>Price ↓</option>
  </select>
  <button class="btn btn-outline-secondary btn-sm">Apply</button>
</form>
