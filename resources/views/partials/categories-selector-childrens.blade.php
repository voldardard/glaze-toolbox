@if(count($Params['childrens']) > 0)
  <ul class="selector_list">
  @foreach ($Params['childrens'] as $category)
    @if($categoryID==$category['id'])
      <li class="selector_item selector_greyed">{{ $category['name'] }}</li>
    @else
      <li class="selector_item" onclick="change_category({{ $categoryID }}, {{ $category['id'] }})">{{ $category['name'] }}</li>
    @endif

    @include('partials.categories-selector-childrens', ['Params'=>$category])
  @endforeach
  </ul>
@endif
