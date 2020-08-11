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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/insert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/autocomplete.css') }}">


    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var locale = "{{ str_replace('_', '-', app()->getLocale()) }}";
        var lang = {
            "formula": "@lang('insert.i-017-formula')",
            "quantity": "@lang('insert.i-018-quantity')",
            "rawMaterials": "@lang('insert.i-016-RawMaterials')",
            "subCategory": "@lang('insert.i-013-subCategory')",
            "problemConnecting": "@lang('insert.i-001-problemConnecting')",
            "validationFailed": "@lang('insert.i-002-validationFailed')",
            "pictureName": "@lang('insert.i-003-pictureName')",
            "label": "@lang('insert.i-004-label')",
            "sources_type": "@lang('insert.i-023-type')",
            "author": "@lang('insert.i-024-author')",
            "description": "@lang('insert.i-025-description')",
            "year": "@lang('insert.i-022-year')",
            "name": "@lang('insert.i-021-name')"
        };
        {!! 'var categories = '.$Params->categories !!}
        {!! 'var lands = '.$Params->lands !!}
        {!! 'var raw = '.$Params->raw !!}
        {!! 'var authors = '.$Params->sources_author !!}
        {!! 'var types = '.$Params->sources_type !!}


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

                    <div><a class="insert-label" onclick="add_label()" ><i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('insert.i-008-addlabel')</a>
                    </div>
                    <!--<input id="label-0" type="text" placeholder="Label" name="label[]" />
                    <a id="label-remove-0" class="remove-label" onclick="remove_label(0)"><i class="fa fa-minus-square" aria-hidden="true"></i></a>-->

                </div>
                <div id="information">
                    <h3>Détails</h3>
                    <div id="information-container" class="boxed">
                        <div id="information-land">
                            <label>Land</label>
                            <div class="autocomplete">
                                <input type="text" id="land-name" value="" required name="land"
                                       placeholder="Name"/>
                            </div>

                        </div>

                        <div id="information-bake">
                            <label>Baking</label>
                            <input type="number" id="bake-orton" value="" required name="bake[orton]"
                                   placeholder="Orton"/>
                            <input type="text" id="bake-oven" value="" required name="bake[oven]"
                                   placeholder="Oven"/>
                            <input type="number" id="bake-temp" value="" required name="bake[temp]"
                                   placeholder="Température (C°)"/>
                            <input type="text" id="bake-type" value="" name="bake[type]"
                                   placeholder="Type"/>
                        </div>

                        <div id="information-remarks">
                            <label>Remarque</label>
                            <textarea id="remarks" value="" name="remarks" placeholder="Remarques"></textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="right">
                <div id="upload">
                    <h3>@lang('insert.i-011-recipePictures')</h3>
                    <input multiple id="upload-pic" type="file" name="pic[]"/>
                    <a onclick="tmp_upload('upload-pic', 'upload-icon', 'upload')"><i id="upload-icon"
                                                                                      class="fa fa-upload"
                                                                                      aria-hidden="true"></i>@lang('insert.i-009-upload')
                    </a>
                    <br/>


                </div>
                <div id="raw">
                    <h3>@lang('insert.i-015-MaterialsRaw')</h3>
                    <div id="raw-container" class="boxed">
                        <div id="raw-0" class="raw-subdiv">
                            <div class="autocomplete">
                                <input type="text" id="raw-name-0" value="" required name="raw[0][name]"
                                       placeholder="@lang('insert.i-016-RawMaterials')"/>
                            </div>
                            <input type="text" id="raw-formula-0" value="" name="raw[0][formula]"
                                   placeholder="@lang('insert.i-017-formula')"/>
                            <input type="number" required id="raw-quantity-0" value="" name="raw[0][quantity]"
                                   placeholder="@lang('insert.i-018-quantity')"/>

                            <a id="raw-remove-0" class="remove-raw" onclick="remove_raw(0)"><i
                                        class="fa fa-minus-square" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div style="clear: both; padding: 0;">
                        <a class="insert-raw" id="add_raw" onclick="add_raw(1)">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('insert.i-014-addAnElement')
                        </a>
                    </div>
                    <!--<span id="raw-total">Total : --------------------------------------------------------------------------------- 100% (sur 100gr)</span>-->

                    <div id="raw-extra-container" class="boxed">
                    </div>
                </div>
                <div style="clear: both; padding: 0;">
                    <a class="insert-raw-extra" id="add_raw_extra" onclick="add_raw_extra(1)">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('insert.i-019-addAnExtraElement')
                    </a>
                </div>
                <div id="sources">
                    <h3>@lang('insert.i-020-sources')</h3>
                    <div id="sources-container">
                        <div id="sources-0" class="boxed">
                            <a id="sources-remove-0" class="remove-sources" onclick="remove_sources(0)">
                                <i class="fa fa-minus-square" aria-hidden="true"></i>
                            </a>
                            <div class="line">
                                <div class="block">
                                    <input type="text" id="sources-name-0" value="" required
                                           name="sources[0][name]" placeholder="@lang('insert.i-021-name')"/>
                                </div>
                                <div class="block">
                                    <input type="number" id="sources-year-0" value="" min="1700"
                                           max="2100" name="sources[0][year]" placeholder="@lang('insert.i-022-year')"/>
                                </div>
                            </div>
                            <div class="line">
                                <div class="autocomplete block">
                                    <input type="text" id="sources-type-0" value="" required name="sources[0][type]"
                                           placeholder="@lang('insert.i-023-type')"/>
                                </div>
                                <div class="autocomplete block">
                                    <input type="text" id="sources-author-0" value="" required name="sources[0][author]"
                                           placeholder="@lang('insert.i-024-author')"/>
                                </div>
                            </div>
                            <div class="line">
                                <textarea id="sources-description-0" value="" name="sources[0][description]"
                                          placeholder="@lang('insert.i-025-description')"></textarea>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both; padding: 0;">
                        <a class="insert-source" id="add_sources" onclick="add_sources(1)">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('insert.i-026-addASource')
                        </a>
                    </div>
                </div>

            </div>
            <br/>
            <button style="margin-top:40px;" class="insert-button">@lang('insert.i-005-save')</button>
            @csrf
        </form>
    </div>
</div>
<script type="text/javascript">
    autocomplete_complex(document.getElementById("add-categories"), categories, new autocomplete_categories_callback(0, '/' + locale + '/category/'));
    autocomplete_raw(document.getElementById("raw-name-0"), raw, 0);
    autocomplete(document.getElementById("land-name"), lands);
    autocomplete(document.getElementById("sources-author-0"), authors);
    autocomplete_complex(document.getElementById("sources-type-0"), types, new autocomplete_author_callback(0, '/' + locale + '/sources/author/type/'));


</script>
</body>
</html>