<form class="d-flex gap-2" x-on:submit.prevent="$store.shop.apply()">
  <select name="sort" class="form-select form-select-sm"
          x-model="$store.shop.state.sort" x-on:change="$store.shop.apply()">
    <option value="newest">Newest</option>
    <option value="price_asc">Price Low → High </option>
    <option value="price_desc">Price High → Low </option>
    <option value="name_asc">Name A–Z</option>
    <option value="name_desc">Name Z–A</option>
  </select>
</form>
