<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_csrf-token" content="{{ csrf_token() }}">
    <title>Home</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/categories.css') }}" >
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
    <script src="{{ asset('js/categories.js') }}"></script>
    <script src="{{ asset('js/errors.js') }}"></script>


</head>
<body>
@include('partials.errors')
@include('menu')
<div class="category-page">
  @if(count($Params->categories) > 0)
    <ul class="categories_list">
      <li class="categories_item categories_add">
        <input id="insert_category_name" required type="text" name="category_name" placeholder="Nom de la catégorie"/>
        <input id="insert_parent_id" required type="hidden" name="parent_id"/>
        @include('partials.categories-selector', ['categoryID'=>"null", 'function'=>["name"=>"choose_category", "description"=>"Catégorie parente"]])
        <i onclick="create_name(document.getElementById('insert_category_name').value, document.getElementById('insert_parent_id').value)" class="fa fa-floppy-o categories_save" aria-hidden="true"></i>
      </li>
    @foreach ($Params->categories as $category)
	   <li class="categories_item">
      <div id="name-{{ $category['id'] }}" class="category_name">
    		<a href="/category/{{ $category['id'] }}">{{ $category['name'] }}</a>
        <i onclick="update_name({{ $category['id'] }}, '{{ $category['name'] }}')" class="fa fa-pencil-square-o" aria-hidden="true"></i>
      </div>
      @include('partials.categories-selector', [ 'categoryID'=>$category['id'], 'function'=>["name"=>"change_category", "description"=>"Déplacer"]])
      <i  onclick="delete_category({{ $category['id'] }})" class="fa fa-times delete-{{ $category['id'] }} delete_category" aria-hidden="true"></i>
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
