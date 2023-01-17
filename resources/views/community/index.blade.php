@foreach ($links as $link)
<small>Contributed by: {{$link->creator->name}} {{$link->updated_at->diffForHumans()}}</small>
<li>{{$link->title}}</li>

@endforeach
{{$links->links()}}