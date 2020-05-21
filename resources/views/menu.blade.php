<div id='cssmenu'>
    <ul>
        <li class='active'><a href='/{{ app()->getLocale() }}/'>@lang('menu.m-001-home')</a></li>
        <li><a href='/{{ app()->getLocale() }}/categories'>@lang('menu.m-002-categories')</a></li>
        <li><a href='/{{ app()->getLocale() }}/insert'>@lang('menu.m-005-insert')</a></li>

        <li class="right" id="profileContainer"><a href='#'><i class="fa fa-user" aria-hidden="true"></i> {{session('username')}}</a>
            <div id="profile">
                <a href='/{{ app()->getLocale() }}/list'>@lang('menu.m-003-list')</a>
                <a href='/{{ app()->getLocale() }}/logout'>@lang('menu.m-004-logout')</a>
            </div>
        </li>
        <li class="right" id="langsContainer" >
            <a href="#" >Languages</a>
                <div id="langs">

                @foreach (Config::get('app.availables_locale') as $lang => $language)
                    <a href="/{{$lang}}" >{{$language}}</a>
                @endforeach
            </div>
        </li>
    </ul>
</div>