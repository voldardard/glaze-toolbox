@if(count($Params->categories) > 0)
<div class="selector" id="{{ $category['id'] }}">
  <span>Déplacer</span>
  <ul id="selector-list-{{ $category['id'] }}" class="selector_list selector_disabled">
  @foreach ($Params->categories as $category)
    <li class="selector_item" onclick="change_category({{ $category['id'] }}, {{ $category['id'] }})">{{ $category['name'] }}</li>
    @include('partials.categories-selector-childrens', ['Params'=>$category])
  @endforeach
  </ul>
  <script type="text/javascript">
    selector(document.getElementById("selector-list-{{ $category['id'] }}"));
  </script>
</div>
@endif
