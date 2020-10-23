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

</head>
<body>
@include('menu')
<div class="category-page">
  @if(count($Params->categories) > 0)
    <ul class="categories_list">
    @foreach ($Params->categories as $category)
	<li class="categories_item">
		<a href="/category/{{ $category['id'] }}">{{ $category['name'] }}</a>
		<div id="{{ $category['id'] }}">
			<span>Déplacer</span>
			<ul class="selector_list">
			@foreach ($Params->categories as $category22)
				<li class="selector_item" onclick="change_category({{ $category['id'] }}, {{ $category22['id'] }})">{{ $category22['name'] }}</li>
				@include('partials.categories', ['Params'=>$category22])
			@endforeach
			</ul>
		</div>
	</li>
	@include('partials.categories', ['Params'=>$category])
    @endforeach
    </ul>
@else
    @include('partials.categories-none')
@endif
</div>

</body>
</html>
