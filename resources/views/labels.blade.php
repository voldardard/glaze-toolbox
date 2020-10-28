<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_csrf-token" content="{{ csrf_token() }}">
    <title>Labels</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/labels.css') }}" >
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
    <script src="{{ asset('js/labels.js') }}"></script>
    <script src="{{ asset('js/errors.js') }}"></script>


</head>
<body>
@include('partials.errors')
@include('menu')
<div class="label-page">
  @if(count($Params->labels) > 0)
    <ul class="labels_list">
      <li class="labels_item labels_add">
        <input id="insert_label_name" required type="text" name="label_name" placeholder="Nom du label"/>
        <i onclick="create_name(document.getElementById('insert_label_name').value)" class="fa fa-floppy-o labels_save" aria-hidden="true"></i>
      </li>
    @foreach ($Params->labels as $label)
	   <li class="labels_item">
      <div id="name-{{ $label['id'] }}" class="label_name">
    		<a href="/{{ str_replace('_', '-', app()->getLocale()) }}/label/{{ $label['id'] }}">{{ $label['name'] }}</a>
        <i onclick="update_name({{ $label['id'] }}, '{{ $label['name'] }}')" class="fa fa-pencil-square-o" aria-hidden="true"></i>
      </div>
      <i  onclick="delete_label({{ $label['id'] }})" class="fa fa-times delete-{{ $label['id'] }} delete_label" aria-hidden="true"></i>
     </li>
    @endforeach
    </ul>

@endif
</div>

</body>
</html>
