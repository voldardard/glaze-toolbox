@foreach($Head['categories'] as $category)
    <span class="block"><object type="owo/uwu"><a href="/{{ str_replace('_', '-', app()->getLocale()) }}/category/{{$category['id']}}"><i
                    class="fa fa-chevron-right"></i> {{$category['name']}}</a></object></span>
@endforeach
<i class="fa fa-chevron-right"></i>
<h1 class="block">{{$Head['name']}}</h1><span class="block">{{$Head['version']}}</span>
<div id="author">
    <span>Created by {{$Head['creator']['fsname']." ".$Head['creator']['name']}}</span>
</div>
