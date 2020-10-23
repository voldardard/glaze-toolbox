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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/categories.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}" >

    <script src="{{ asset('js/categories.js') }}"></script>


</head>
<body>
@include('menu')
<div class="category-page">
  @if(count($Params->categories) > 0)
    <ul class="categories_list">
    @foreach ($Params->categories as $category)
	   <li class="categories_item">
      <div id="name-{{ $category['id'] }}" class="category_name">
    		<a href="/category/{{ $category['id'] }}">{{ $category['name'] }}</a>
        <i onclick="update_name({{ $category['id'] }}, '{{ $category['name'] }}')" class="fa fa-pencil-square-o" aria-hidden="true"></i>
    </div>
      @include('partials.categories-selector', ['Params'=>$Params])
	   </li>
	@include('partials.categories', ['Params'=>$Params, 'Category'=>$category])
    @endforeach
    </ul>
@else
    @include('partials.categories-none')
@endif
</div>
<script type="text/javascript">closeSelectorEvent()</script>

</body>
</html>
