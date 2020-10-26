@if(!empty($Pictures))
    <div id="carousel">
        <div class="slider-container">

            <div class="slider-content">
                @foreach($Pictures as $picture)
                    <div class="slider-single">
                        <img onclick="openInFullscreen(this)" class="slider-single-image" src="{{$picture->path}}"
                             alt="{{$picture->name}}"/>
                        <h1 class="slider-single-title">{{$picture->name}}</h1>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@else
  <div id="carousel">
      <div class="slider-container">
          <div class="slider-content">
              <div class="slider-single">
                  <img onclick="openInFullscreen(this)" class="slider-single-image" src="/pictures/no-pic.jpg"
                       alt="Missing picture"/>
                  <h1 class="slider-single-title">Missing picture</h1>
              </div>
          </div>
      </div>
  </div>
@endif
