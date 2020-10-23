@if(count($Params['childrens']) > 0)
  <u class="categories_list"l>
  @foreach ($Params['childrens'] as $category)
      <li  class="categories_item">
        <a href="/category/{{ $category['id'] }}">{{ $category['name'] }}</a>
      </li>
      @include('partials.categories', ['Params'=>$category])
  @endforeach
  </ul>
@endif
