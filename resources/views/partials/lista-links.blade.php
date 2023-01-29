@foreach ($links as $link)

<div class=" link">
    <li>


        <span class="label label-default " style="background: {{ $link->channel->color }}">
            {{ $link->channel->title }}
        </span>

        <a class="margin-a" href="{{$link->link}}" target="_blank">
            {{$link->title}}
        </a>
        <small>Contributed by: {{$link->creator->name}} {{$link->updated_at->diffForHumans()}}</small>
    </li>
</div>
@endforeach