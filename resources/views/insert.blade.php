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

    <!-- Scripts -->
    <script src="{{ asset('js/insert.js') }}"></script>


</head>
<body>
@include('menu')
<div class="insert-page">
    <h1>Insert a new recipe</h1>
    <div class="form">
        <form class="insert-form" method="POST" action="/{{ app()->getLocale() }}/insert">
            <div class="left">

                <h1 id="title"><input type="text" autofocus required name="title" placeholder="Title"/></h1>
                <input type="text"  required name="category" placeholder="Categories"/>
                <div id="labels">
                    <a onclick="add_label()" ><i class="fa fa-plus-circle" aria-hidden="true"></i> Add a label</a>
                    <input type="text" placeholder="Label" name="label[0]" ><a class="remove_label" onclick="remove_label(0)"><i class="fa fa-minus-square" aria-hidden="true"></i></a>

                </div>
            </div>

            <div class="right">

            </div>
            <button class="insert-button">Enregistrer</button>
            @csrf
        </form>
    </div>
</div>

</body>
</html>