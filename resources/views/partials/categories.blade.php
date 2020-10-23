@if(count($Category['childrens']) > 0)
  <ul class="categories_list"l>
  @foreach ($Category['childrens'] as $category)
      <li  class="categories_item">
        <div id="name-{{ $category['id'] }}" class="category_name">
        <a href="/category/{{ $category['id'] }}">{{ $category['name'] }}</a>
        <i onclick="update_name({{ $category['id'] }}, '{{ $category['name'] }}')" class="fa fa-pencil-square-o" aria-hidden="true"></i>
      </div>
        @include('partials.categories-selector', ['Params'=>$Params, 'categoryID'=>$category['id']])
      </li>
      @include('partials.categories', ['Params'=>$Params, 'Category'=>$category])
  @endforeach
  </ul>
@endif
