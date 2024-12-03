<div class="col-md-3">
  <div class="category-filter-section shadow">
    <div class="list-group">
      <h4 class="list-group-item list-group-item-action" style = "background-color:#8b8be8;color:white">Categories</h4>
      @foreach ($categories as $category)
      @php
        $url = url()->current() . '?__eq_category_id=' . $category->id;
      @endphp
        <a href="{{ $url }}" class="list-group-item list-group-item-action {{ $categoryId == $category->id ? 'active-category' : '' }}">{{ $category->name }}</a>
      @endforeach
    </div>
  </div>
</div>