@if(!empty($Pictures) && !(empty($Carousel_options)))

    <!-- Flickity HTML init -->
    <div class="carousel js-flickity" data-flickity-options='{{ $Carousel_options }}'>
      @foreach($Pictures as $picture)
      <div class="carousel-cell">
          <img  class="slider-single-image" data-flickity-lazyload="{{$picture['path']}}" alt="{{$picture['name']}}"/>
          <h1 style="position:absolute; bottom:0;" class="slider-single-title">{{$picture['name']}}</h1>
      </div>
      @endforeach
    </div>
@else
<!-- Flickity HTML init -->
<div class="carousel js-flickity" >
  <div class="carousel-cell">
      <img class="slider-single-image" src="/pictures/no-pic.jpg" alt="Missing pic"/>
      <h1 style="display:none;" class="slider-single-title">Missing pic</h1>
  </div>
</div>
@endif
