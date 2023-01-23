@extends('layouts.app')
@section('content')
<h1>Community</h1>


@foreach ($links as $link)
<small>Contributed by: {{$link->creator->name}} {{$link->updated_at->diffForHumans()}}</small>
<li>{{$link->title}}</li>

@endforeach
{{$links->links()}}
@stop