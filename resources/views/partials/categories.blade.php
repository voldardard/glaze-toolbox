@if (count($projects) > 0)
    <ul>
    @foreach ($projects as $project)
        @include('partials.project', $project)
    @endforeach
    </ul>
@else
    @include('partials.projects-none')
@endif

@if(count($Params->childrens) > 0)
  <ul>
  @foreach ($Params->categories as $category)
      <li>{{ $category->name }}</li>
      @include('partials.categories', ['Params'=>$category])
  @endforeach
  </ul>
@endif
