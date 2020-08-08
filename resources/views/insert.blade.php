<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_csrf-token" content="{{ csrf_token() }}">

    <title>Insert</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/insert.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/autocomplete.css') }}" >


    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var lang = {"subCategory":"@lang('insert.i-013-subCategory')", "problemConnecting":"@lang('insert.i-001-problemConnecting')", "validationFailed":"@lang('insert.i-002-validationFailed')", "pictureName":"@lang('insert.i-003-pictureName')", "label":"@lang('insert.i-004-label')"};
        {{ 'var categories = '.$Params->categories }}
        {{ 'var raw = '.$Params->raw }}
    </script>
    <script src="{{ asset('js/insert.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js') }}"></script>


</head>
<body>
<div id="alert">

    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show fixed-top">
            {{ $error }}
            <button class="close" type="button" data-dissmiss="alert">x</button>
        </div>
        @endforeach
    @endif

</div>

@include('menu')
<div class="insert-page">
    <h1>@lang('insert.i-010-insertNewRecipe')</h1>
    <div class="form">
        <form autocomplete="off" class="insert-form" method="POST" action="/{{ app()->getLocale() }}/insert" enctype="multipart/form-data">

            <div class="left">

                <h1 id="title"><input value="{{ old('title') }}" type="text" autofocus required name="title" placeholder="@lang('insert.i-006-title')"/></h1>
                <div id="categories">
                    <div class="autocomplete" level="0">
                        <input type="text" id="add-categories" value="" required name="category[0]" placeholder="@lang('insert.i-007-category')"/>
                    </div>
                </div>
                <div style="clear: both"><a class="insert-categories" id="add_category" onclick="add_category(1)" ><i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('insert.i-012-addSubCategory')</a></div>

                <div id="labels">

                    <div><a class="insert-label" onclick="add_label()" ><i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('insert.i-008-addlabel')</a></div>
                    <!--<input id="label-0" type="text" placeholder="Label" name="label[]" />
                    <a id="label-remove-0" class="remove-label" onclick="remove_label(0)"><i class="fa fa-minus-square" aria-hidden="true"></i></a>-->

                </div>
            </div>

            <div class="right">
                <div id="upload">
                    <h3>@lang('insert.i-011-recipePictures')</h3>
                    <input  multiple id="upload-pic" type="file" name="pic[]" />
                    <a onclick="tmp_upload('upload-pic', 'upload-icon', 'upload')"><i id="upload-icon" class="fa fa-upload" aria-hidden="true"></i>@lang('insert.i-009-upload')</a>
<br/>


                </div>
                <div id="raw">
                    <h3>Ingrédients / matière première</h3>
                    <div id="raw-container">
                        <div id="raw-0">
                            <input type="text" id="raw-name-0" value="" required name="raw[0][name]" placeholder="Matière première"/>
                            <input type="text" id="raw-formula-0" value="" name="raw[0][formula]" placeholder="Formule"/>
                            <input type="number" id="raw-quantity-0" value="" name="raw[0][quantity]" placeholder="Quantités"/>

                            <a id="raw-remove-0" class="remove-raw" onclick="remove_raw(0)"><i class="fa fa-minus-square" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div style="clear: both; padding: 0;"><a class="insert-raw" id="add_raw" onclick="add_raw(1)" ><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter un élément</a></div>

                </div>
            </div>

            <br />
            <button class="insert-button">@lang('insert.i-005-save')</button>
            @csrf
        </form>
    </div>
</div>
<script type="text/javascript">
    autocomplete_category(document.getElementById("add-categories"), categories, 0);
    autocomplete_raw(document.getElementById("raw-name-0"), raw, 0);

</script>
</body>
</html>