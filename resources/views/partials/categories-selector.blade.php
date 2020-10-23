@if(count($Params->categories) > 0)
<div class="selector" id="{{ $category['id'] }}">
  <span>Déplacer</span>
  <ul class="selector_list selector_disabled">
  @foreach ($Params->categories as $category)
    <li class="selector_item" onclick="change_category({{ $category['id'] }}, {{ $category['id'] }})">{{ $category['name'] }}</li>
    @include('partials.categories-selector-childrens', ['Params'=>$category])
  @endforeach
  </ul>
</div>
@endif
