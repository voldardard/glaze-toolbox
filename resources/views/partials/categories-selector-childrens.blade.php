<div id="{{ $category['id'] }}">
  <span>Déplacer</span>
  <ul class="selector_list">
  @foreach ($Params['childrens'] as $category)
    <li class="selector_item" onclick="change_category({{ $category['id'] }}, {{ $category['id'] }})">{{ $category['name'] }}</li>
    @include('partials-selector-childrens.categories', ['Params'=>$category])
  @endforeach
  </ul>
</div>
