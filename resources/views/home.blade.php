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
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        body{
            font-family: "Roboto", sans-serif;
        }
        .search-page {
            width: 80%;
            padding: 8% 0 0;
            margin: auto;
        }
        .form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        .form input {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 25px;
            padding: 25px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .form button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background-color: #151515;
            width: 100%;
            border: 0;
            padding: 25px;
            color: #FFFFFF;
            font-size: 16px;
            transition: all;
            cursor: pointer;
        }
        .form .search-button{
            position: absolute;
            right: 45px;
            width: inherit;
        }
        .form button:hover,.form button:active,.form button:focus {
            background: #434343;
        }
        .form .message {
            margin: 15px 0 0;
            color: #b3b3b3;
            font-size: 12px;
        }
        .form .message a {
            color: #151515;
            text-decoration: none;
            font-weight: bolder;
        }
        .form h1 {
            color: #5C5C5C;
            text-align: center;
            font: bold 80px arial,sans-serif;
            margin-bottom: 40px;
        }
        .red{
            color:red;
            font-weight: bolder;
            text-align: center;
        }
        .green{
            color:green;
            font-weight: bolder;
            text-align: center;
        }
        .orange{
            color: rgb(249, 190, 18);
        }
        .grey{
            color: #646460;
            cursor: auto;
        }
    </style>
</head>
<body>
@include('view.menu')
<div class="search-page">
    <div class="form">
        <form class="search-form" method="POST" action="/{{ app()->getLocale() }}/search">
            <h1>Cera.Chat - lookup</h1>
            <input type="text" autofocus required name="search" placeholder="Ex: temoku kaki"/>
            <button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
            @csrf
        </form>
    </div>
</div>

</body>
</html>