@if(count($Params->recipes) > 0)
  <ul class="recipes-list">

    @foreach($Params->recipes as $recipe)
    <li class="recipes-list_item">
      <div class="recipes-list_left-pic">
        @include('partials.carousel',  ['Pictures'=>$recipe['pictures'], 'disableTitle'=>true])
      </div>
      <a href="/{{ str_replace('_', '-', app()->getLocale()) }}/recipe/{{ $recipe['id'] }}" >
        <div class="recipes-list_right-text">
          @include('partials.sub-categories', ['Head'=>$recipe])
          <span class="name">{{ $recipe['name'] }}</span>
          <span class="version">{{ $recipe['version'] }}</span>
          <span class="author">Created by {{ $recipe['users_fsname']." ".$recipe['users_name'] }}</span>
        </div>
    </a>
  </li>
    @endforeach
  </ul>
@endif
