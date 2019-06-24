<ol class="breadcrumb">
    @foreach($links as $link => $url)
        @if($url == 'active')
            <li class="active">{{$link}}</li>
        @else
        <li><a href="{{$url}}">{{$link}}</a></li>
        @endif
    @endforeach
</ol>
    