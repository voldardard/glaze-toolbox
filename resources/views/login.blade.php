<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}" >
</head>
<body>
@include('menu-unauth')
<div class="login-page">
    <div class="form">
        <form class="login-form" method="POST" action="/{{ app()->getLocale() }}/login">
            <input type="text" autofocus required name="username" value="{{ old('username') }}" placeholder="@lang('login.l-001-username')"/>
            <input type="password" required name="password" placeholder="@lang('login.l-002-password')"/>
            <button>@lang('login.l-013-login')</button>
            @csrf
        </form>
        <p class="message">@lang('login.l-003-notregistredyet') &nbsp;&nbsp;<a href="/{{ app()->getLocale() }}/register">@lang('login.l-004-createaccount')</a></p>
        <p class="message">@lang('login.l-005-forgetPassword') &nbsp;&nbsp;<a href="/{{ app()->getLocale() }}/forgot">@lang('login.l-006-resetyourpassword')</a></p>


        @if ($errors->any())
            <div class="red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <br /> <br /><span class="green">{!! session('success') !!}</span></div>
        @endif
        @if (session('error'))
                <br /> <br /><span class="red">{!! session('error') !!}</span></div>
        @endif

    </div>
</div>

</body>
</html>