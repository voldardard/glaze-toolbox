<style>
    #cssmenu,
    #cssmenu ul{
        margin: 0;
        padding: 0;
        border: 0;
        list-style: none;
        line-height: 1;
        display: block;
     /*   position: relative;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;*/
    }
    #cssmenu ul li,
    #cssmenu ul li a {
        margin: 0;
        padding: 0;
        border: 0;
        list-style: none;
        line-height: 1;
        display: block;
         position: relative;
           -webkit-box-sizing: border-box;
           -moz-box-sizing: border-box;
           box-sizing: border-box;
    }
    #cssmenu ul .right{
        float:right;
    }
    #cssmenu:after,
    #cssmenu > ul:after {
        content: ".";
        display: block;
        clear: both;
        visibility: hidden;
        line-height: 0;
        height: 0;
    }
    #cssmenu {
        width: auto;
        border-bottom: 3px solid #5C5C5C;
        font-family: Roboto, sans-serif;
        line-height: 1;
    }
    #cssmenu ul {
        background: #ffffff;
    }
    #cssmenu > ul > li {
        float: left;
    }
    #cssmenu.align-center > ul {
        font-size: 0;
        text-align: center;
    }
    #cssmenu.align-center > ul > li {
        display: inline-block;
        float: none;
    }
    #cssmenu.align-right > ul > li {
        float: right;
    }
    #cssmenu.align-right > ul > li > a {
        margin-right: 0;
        margin-left: -4px;
    }
    #cssmenu > ul > li > a {
        z-index: 2;
        padding: 18px 25px 12px 25px;
        font-size: 15px;
        font-weight: 400;
        text-decoration: none;
        color: #444444;
        -webkit-transition: all .2s ease;
        -moz-transition: all .2s ease;
        -ms-transition: all .2s ease;
        -o-transition: all .2s ease;
        transition: all .2s ease;
        margin-right: -4px;
    }
    #cssmenu > ul > li.active > a,
    #cssmenu > ul > li:hover > a,
    #cssmenu > ul > li > a:hover {
        color: #ffffff;
    }
    #cssmenu > ul > li > a:after {
        position: absolute;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: -1;
        width: 100%;
        height: 120%;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        content: "";
        -webkit-transition: all .2s ease;
        -o-transition: all .2s ease;
        transition: all .2s ease;
        -webkit-transform: perspective(5px) rotateX(2deg);
        -webkit-transform-origin: bottom;
        -moz-transform: perspective(5px) rotateX(2deg);
        -moz-transform-origin: bottom;
        transform: perspective(5px) rotateX(2deg);
        transform-origin: bottom;
    }
    #cssmenu > ul > li.active > a:after,
    #cssmenu > ul > li:hover > a:after,
    #cssmenu > ul > li > a:hover:after {
        background: #5C5C5C;
    }
    #cssmenu #langs{
        display:none;
    }
    #cssmenu #langs:hover #langs{
        display:block;
        position: absolute;
    }
    #cssmenu #langs a{
        padding: 15px 25px 12px 25px;
        font-size: 15px;
        font-weight: 400;
        text-decoration: none;
        color: white;
        background: #444;
    }
</style>
<div id='cssmenu'>
    <ul>
        <li class='active'><a href='/{{ app()->getLocale() }}/'>@lang('menu.m-001-home')</a></li>
        <li><a href='/{{ app()->getLocale() }}/categories'>@lang('menu.m-002-categories')</a></li>
        <li><a href='/{{ app()->getLocale() }}/list'>@lang('menu.m-003-list')</a></li>

        <li class="right"><a href='#'>{{session('username')}}</a></li>
        <li class="right"><a href='/{{ app()->getLocale() }}/logout'>@lang('menu.m-004-logout')</a></li>
        <li class="right" >
            <a href="#">Languages</a>
            <div id="langs">
                @foreach (Config::get('app.availables_locale') as $lang => $language)
                    <a href="href='/{{$lang}}" >{{$language}}</a>
                @endforeach
            </div>
        </li>
    </ul>
</div>