@if(count($Params['childrens']) > 0)
  <ul>
  @foreach ($Params->categories as $category)
      <li>{{ $category['name'] }}</li>
      @include('partials.categories', ['Params'=>$category])
  @endforeach
  </ul>
@endif
