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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/insert.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/autocomplete.css') }}" >


    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
    <script type="text/javascript">
        var lang = {"problemConnecting":"@lang('insert.i-001-problemConnecting')", "validationFailed":"@lang('insert.i-002-validationFailed')", "pictureName":"@lang('insert.i-003-pictureName')", "label":"@lang('insert.i-004-label')"};
        var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
    </script>
    <script src="{{ asset('js/autocomplete.js') }}"></script>
    <script src="{{ asset('js/insert.js') }}"></script>


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
                <div class="autocomplete" >
                    <input type="text" id="add-categories" value="{{ old('category') }}" required name="category" placeholder="@lang('insert.i-007-category')"/>
                </div>
                <div id="labels">

                    <div><a class="insert-label" onclick="add_label()" ><i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('insert.i-008-addlabel')</a></div>
                    <!--<input id="label-0" type="text" placeholder="Label" name="label[]" />
                    <a id="label-remove-0" class="remove-label" onclick="remove_label(0)"><i class="fa fa-minus-square" aria-hidden="true"></i></a>-->

                </div>
            </div>

            <div class="right">
                <div class="ui labeled button" tabindex="0">
                    <div class="ui button">
                        <i class="heart icon"></i> Like
                    </div>
                    <a class="ui basic label">
                        2,048
                    </a>
                </div>
                <div class="ui left labeled button" tabindex="0">
                    <a class="ui basic right pointing label">
                        2,048
                    </a>
                    <div class="ui button">
                        <i class="heart icon"></i> Like
                    </div>
                </div>
                <div class="ui left labeled button" tabindex="0">
                    <a class="ui basic label">
                        1,048
                    </a>
                    <div class="ui icon button">
                        <i class="fork icon"></i>
                    </div>
                </div>
                <div id="upload">
                    <h3>@lang('insert.i-011-recipePictures')</h3>
                    <input  multiple id="upload-pic" type="file" name="pic[]" />
                    <a onclick="tmp_upload('upload-pic', 'upload-icon', 'upload')"><i id="upload-icon" class="fa fa-upload" aria-hidden="true"></i>@lang('insert.i-009-upload')</a>

                </div>
            </div>
            <br />
            <button class="insert-button">@lang('insert.i-005-save')</button>
            @csrf
        </form>
    </div>
</div>
<script type="text/javascript">
    autocomplete(document.getElementById("add-categories"), countries);
</script>
</body>
</html>