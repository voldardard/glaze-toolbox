@if(count($Params['childrens']) > 0)
  <u class="categories_list"l>
  @foreach ($Params['childrens'] as $category)
      <li  class="categories_item">
        <a href="/category/{{ $category['id'] }}">{{ $category['name'] }}</a>
        <div id="{{ $category['id'] }}">
          <span>Déplacer</span>
          <ul class="selector_list">
          @foreach ($Params->categories as $category22)
            <li class="selector_item" onclick="change_category({{ $category['id'] }}, {{ $category22['id'] }})">{{ $category22['name'] }}</li>
            @include('partials.categories', ['Params'=>$category])
          @endforeach
          </ul>
        </div>
      </li>
      @include('partials.categories', ['Params'=>$category])
  @endforeach
  </ul>
@endif
