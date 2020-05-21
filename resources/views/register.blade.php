<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/register.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}" >
</head>
<body>
@include('menu-unauth')
<div class="login-page">
    <div class="form">
        <form class="login-form" method="POST" action="/{{ app()->getLocale() }}/register">
            <input type="text" required name="fsname" value="{{ old('fsname') }}"  placeholder="@lang('login.l-010-fsname')"/>
            <input type="text" required name="name"  value="{{ old('name') }}" placeholder="@lang('login.l-009-name')"/>
            <input type="email" required name="email" value="{{ old('email') }}"  placeholder="@lang('login.l-011-email')"/>
            <input type="text" required name="username" value="{{ old('username') }}" placeholder="@lang('login.l-001-username')"/>
            <input type="password" required name="password" placeholder="@lang('login.l-002-password')"/>
            <button>@lang('login.l-012-register')</button>
            @csrf
        </form>
        <p class="message">@lang('login.l-014-alreadyregistred') &nbsp;&nbsp;<a href="/{{ app()->getLocale() }}/login">@lang('login.l-015-connect')</a></p>

        @if ($errors->any())
            <div class="red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <br /> <br /><span class="red">{{ session('error') }}</span></div>
        @endif

</div>
</div>

</body>
</html>