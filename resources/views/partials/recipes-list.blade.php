@if(count($Params->recipes) > 0)
  <ul class="recipes-list">

    @foreach($Params->recipes as $recipe)
    <li class="recipes-list_item">
      <div class="recipes-list_left-pic">
        @include('partials.carousel',  ['Pictures'=>$recipe['pictures'], 'Carousel_options'=>'{ "wrapAround": true, "fullscreen": true, "lazyLoad": 1, "prevNextButtons": false, "pageDots": false }'])
      </div>
      <a href="/{{ str_replace('_', '-', app()->getLocale()) }}/recipe/{{ $recipe['id'] }}" >
        <div class="recipes-list_right-text">
          @include('partials.sub-categories', ['Head'=>$recipe])
        </div>
    </a>
  </li>
    @endforeach
  </ul>
@endif
