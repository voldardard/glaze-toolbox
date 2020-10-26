<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="_csrf-token" content="{{ csrf_token() }}">
      <title>Catégorie</title>

      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

      <!-- Styles -->
      <!--<link rel="stylesheet" type="text/css" href="{{ asset('css/category.css') }}" >-->
      <link rel="stylesheet" type="text/css" href="{{ asset('css/recipes-list.css') }}" >
      <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}" >
      <link rel="stylesheet" type="text/css" href="{{ asset('css/errors.css') }}" >

      <script type="text/javascript">
          var locale = "{{ str_replace('_', '-', app()->getLocale()) }}";
          var lang = {
            "problemConnecting": "@lang('insert.i-001-problemConnecting')",
            "validationFailed": "@lang('insert.i-002-validationFailed')",
          };


      </script>
      <script src="{{ asset('js/utils.js') }}"></script>
      <!--<script src="{{ asset('js/category.js') }}"></script>-->
      <script src="{{ asset('js/recipes-list.js') }}"></script>
      <script src="{{ asset('js/errors.js') }}"></script>


  </head>
  <body>
    @include('partials.errors')
    @include('menu')
    <div class="category-page">
      @include('partials.recipes-list')

    </div>

  </body>
</html>
