<div id='cssmenu'>
    <ul>
        <li class="right" id="langsContainer" >
            <a href="#" >Languages</a>
            <div id="langs">
                @foreach (Config::get('app.availables_locale') as $lang => $language)
                    <a href="/{{$lang.session('current_route')}}" >{{$language}}</a>
                @endforeach
            </div>
        </li>
    </ul>
</div>