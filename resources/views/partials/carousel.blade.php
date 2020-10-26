@if(!empty($Params->pictures))
    <div id="carousel">
        <div class="slider-container">

            <div class="slider-content">
                @foreach($Params->pictures as $key => $photo)

                    <div class="slider-single">
                        <img onclick="openInFullscreen(this)" class="slider-single-image" src="{{$photo->path}}"
                             alt="{{$photo->name}}"/>
                        <h1 class="slider-single-title">{{$photo->name}}</h1>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
