@if(count($Params->categories) > 0)
<div class="selector" id="selector-{{ $categoryID }}">
  <span>{{ $function['description'] }}</span>
  <ul id="selector-list-{{ $categoryID }}" class="selector_list selector_disabled">
  <li class="selector_item" onclick="{{ $function['name'] }}({{ $categoryID }}, null)">==Add to root==</li>
  @foreach ($Params->categories as $sub_category)
    @if($categoryID==$sub_category['id'])
      <li class="selector_item selector_greyed">{{ $sub_category['name'] }}</li>
    @else
      <li class="selector_item" onclick="{{ $function['name'] }}({{ $categoryID }}, {{ $sub_category['id'] }})">{{ $sub_category['name'] }}</li>
      @include('partials.categories-selector-childrens', ['Params'=>$sub_category])
    @endif
  @endforeach
  </ul>

</div>
<script type="text/javascript">
  selector(document.getElementById("selector-{{ $categoryID }}"), document.getElementById("selector-list-{{ $categoryID }}"));
</script>
@endif
