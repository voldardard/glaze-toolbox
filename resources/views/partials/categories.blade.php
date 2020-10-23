@if(count($Category['childrens']) > 0)
  <ul class="categories_list"l>
  @foreach ($Category['childrens'] as $category)
      <li  class="categories_item">
        <a href="/category/{{ $category['id'] }}">{{ $category['name'] }}</a>
        @include('partials.categories-selector', ['Params'=>$Params])
      </li>
      @include('partials.categories', ['Params'=>$Params, 'Category'=>$category])
  @endforeach
  </ul>
@endif
