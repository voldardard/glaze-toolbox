@if(count($Params->categories) > 0)
<div class="selector" id="{{ $category['id'] }}">
  <span>Déplacer</span>
  <ul id="selector-list-{{ $category['id'] }}" class="selector_list selector_disabled">
  @foreach ($Params->categories as $sub_category)
    <li class="selector_item" onclick="change_category({{ $sub_category['id'] }}, {{ $sub_category['id'] }})">{{ $sub_category['name'] }}</li>
    @include('partials.categories-selector-childrens', ['Params'=>$sub_category])
  @endforeach
  </ul>
  <script type="text/javascript">
    console.log("Activate selector-list-{{ $category['id'] }}")
    selector(document.getElementById("selector-list-{{ $category['id'] }}"));
  </script>
</div>
@endif
