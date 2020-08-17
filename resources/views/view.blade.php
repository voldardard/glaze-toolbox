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


    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
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
<div class="view-page">
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
    @if(!empty($Params->pictures))
        <div id="carousel" class="container">
            <br>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    @for($i=0; $i< count($Params->pictures); $i++)
                        <li data-target="#myCarousel" data-slide-to="{{$i}}" @if($i==0)class="active"@endif></li>
                    @endfor
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    @foreach($Params->pictures as $key => $value)
                        <div class="item @if($key==0)active@endif">
                            <img src="{{$value->path}}" alt="{{$value->name}}}}" width="460" height="345">
                            <div class="carousel-caption">
                                <h3>{{$value->name}}</h3>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    @endif

</div>