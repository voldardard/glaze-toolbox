<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_csrf-token" content="{{ csrf_token() }}">

    <title>{{$Params->name}}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/view.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/carousel.css') }}">


    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script type="text/javascript">
        var locale = "{{ str_replace('_', '-', app()->getLocale()) }}";

    </script>

</head>
<body>
<div id="alert">

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show fixed-top">
                {{ $error }}
                <button class="close" type="button" data-dissmiss="alert">x</button>
            </div>
        @endforeach
    @endif

</div>

@include('menu')
<div id="previewPic">
    <i class="fa fa-times" onclick="closeFullscreen()" aria-hidden="true"></i>
    <img id="fullscreenPic" src="/pictures/1597234559_893fc09a25ad33b27968f507dd0d4338e3850ffd.png"/>
</div>
<div id="page" class="view-page">
    <div id="head">
        @foreach($Params->categories as $category)
            <span class="block"><a href="/category/{{$category->id}}"><i class="fa fa-chevron-right"></i> {{$category->name}}</a></span>
        @endforeach
        <i class="fa fa-chevron-right"></i>
        <h1 class="block">{{$Params->name}}</h1><span class="block">{{$Params->version}}</span>
        <div id="author">
            <span>Created by {{$Params->creator->fsname." ".$Params->creator->name}}</span>
        </div>
        <div id="labels">
            @foreach($Params->labels as $label)
                <span class="label"><i class="fa fa-tag" aria-hidden="true"></i> {{$label}}</span>
            @endforeach
        </div>
    </div>
    <div id="left">
        @if(!empty($Params->pictures))
            <div id="carousel" class="container">
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
        <div id="remarks">
            <i class="fa fa-quote-left" aria-hidden="true"></i>
            {{$Params->remark}}
            <i class="fa fa-quote-right" aria-hidden="true"></i>
        </div>
    </div>
    <div id="right">
        <div id="baking">
            <h3>Cuisson</h3>
            <div id="orton"><span class="legend">Orton: </span>{{$Params->baking->orton}}</div>
            <div id="oven"><span class="legend">Four: </span>{{$Params->baking->oven}}</div>
            <div id="temperature"><span class="legend">Température: </span>{{$Params->baking->temperature}}</div>
            <div id="type"><span class="legend">Type: </span>{{$Params->baking->type}}</div>

        </div>
        <div id="components">
            <div style="display: none">{{ $quantity=100 }}</div>
            <h3>Matière première / composants de la recette</h3>
            <table class="table">
                <thead class="thead-dark table-striped">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Formule</th>
                    <th scope="col">Quantité (%)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($Params->components as $key => $value)
                    @if(! $value->extra)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->formula }}</td>
                            <td>{{ $value->quantity }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr class="table-dark">
                    <th scope="row"></th>
                    <td></td>
                    <td></td>
                    <td>{{ $quantity }}</td>
                </tr>
                </tbody>
            </table>
            <h3>Composants supplémentaires de la recette</h3>
            <table class="table">
                <thead class="thead-dark table-striped">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Formule</th>
                    <th scope="col">Quantité (%)</th>
                </tr>
                </thead>
                <tbody>

                @foreach($Params->components as $key => $value)
                    @if($value->extra)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->formula }}</td>
                            <td>{{ $value->quantity }}</td>
                        </tr>
                        <div style="display: none">{{ $quantity += $value->quantity }}</div>

                    @endif

                @endforeach
                <tr class="table-dark">
                    <th scope="row"></th>
                    <td></td>
                    <td></td>
                    <td>{{ $quantity }}</td>
                </tr>
                </tbody>
            </table>


        </div>
        <div id="sources">

        </div>
    </div>

</div>
<script>
    const container = document.querySelector('.slider-container');
    var slide = document.querySelectorAll('.slider-single');
    var slideTotal = slide.length - 1;
    var slideCurrent = -1;
    slideInitial();
</script>
</body>