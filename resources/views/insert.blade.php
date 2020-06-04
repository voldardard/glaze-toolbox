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
                <select class="ui fluid search dropdown" multiple="">
                    <option value="">State</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>

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