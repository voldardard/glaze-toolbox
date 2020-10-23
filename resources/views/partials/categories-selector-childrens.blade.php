@if(count($Params['childrens']) > 0)
  <ul class="selector_list">
    {{ $Params['name'] }}
  @foreach ($Params['childrens'] as $category)
    <li class="selector_item" onclick="change_category({{ $Params['id'] }}, {{ $category['id'] }})">{{ $category['name'] }}</li>
    @include('partials.categories-selector-childrens', ['Params'=>$category])
  @endforeach
  </ul>
@endif
