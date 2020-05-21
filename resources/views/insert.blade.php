<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/insert.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}" >

</head>
<body>
@include('menu')
<div class="insert-page">
    <div class="form">
        <form class="insert-form" method="POST" action="/{{ app()->getLocale() }}/insert">
            <input type="text" autofocus required name="title" placeholder="Title"/>
            <input type="text" autofocus required name="category" placeholder="Catégorie"/>
            <input type="text" autofocus required name="category" placeholder="Catégorie"/>

            <button class="insert-button"></button>
            @csrf
        </form>
    </div>
</div>

</body>
</html>