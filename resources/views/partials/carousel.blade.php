@if(!empty($Pictures))

    <!-- Flickity HTML init -->
    <div class="carousel js-flickity" data-flickity-options='{ "wrapAround": true, fullscreen: true, lazyLoad: 1 }'>
      @foreach($Pictures as $picture)
      <div class="carousel-cell">
          <img  class="slider-single-image" src="{{$picture['path']}}" alt="{{$picture['name']}}"/>
          <h1 class="slider-single-title">{{$picture['name']}}</h1>
      </div>
      @endforeach
    </div>
@else
<!-- Flickity HTML init -->
<div class="carousel js-flickity" data-flickity-options='{ "wrapAround": true }'>
  @foreach($Pictures as $picture)
  <div class="carousel-cell">
      <img onclick="openInFullscreen(this)" class="slider-single-image" src="/pictures/no-pic.jpg" alt="Missing pic"/>
      <h1 class="slider-single-title">Missing pic</h1>
  </div>
  @endforeach
</div>
@endif
