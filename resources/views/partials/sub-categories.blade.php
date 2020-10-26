@foreach($Head['categories'] as $category)
    <span class="block"><object type="owo/uwu"><a href="/{{ str_replace('_', '-', app()->getLocale()) }}/category/{{$category['id']}}"><i
                    class="fa fa-chevron-right"></i> {{$category['name']}}</a></object></span>
@endforeach
@if(!empty($Head['name']))
<i class="fa fa-chevron-right"></i>
@endif


@if(!empty($Head['name']))<h1 class="block">{{$Head['name']}}</h1>@endif @if(!empty($Head['version']))<span class="block">{{$Head['version']}}</span>@endif

@if(!empty($Head['creator']))
<div id="author">
    <span>Created by {{$Head['creator']['fsname']." ".$Head['creator']['name']}}</span>
</div>
@endif
