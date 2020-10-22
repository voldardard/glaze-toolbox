@if(count($Params['childrens']) > 0)
  <ul>
  @foreach ($Params['childrens'] as $category)
      <li><a href="/category/{{ $category['id'] }}">{{ $category['name'] }}</a></li>
      @include('partials.categories', ['Params'=>$category])
  @endforeach
  </ul>
@endif
