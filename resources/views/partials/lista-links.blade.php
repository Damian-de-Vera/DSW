@foreach ($links as $link)


<div class=" link">
    <li>


        <span class="label label-default " style="background: {{ $link->channel->color }}">
            <a class="margin-a enlace" href="/community/{{ $link->channel->slug }}" target="_blank">
                {{$link->channel->title}}
            </a>

        </span>

        <a class="margin-a " href="{{ $link->link }}" target="_blank">
            {{$link->title}}
        </a>

        <small>Contributed by: {{$link->creator->name}} {{$link->updated_at->diffForHumans()}}</small>

        <form method="POST" action="/community/votes/{{ $link->id }}">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-secondary 
{{ Auth::check() && Auth::user()->votedFor($link) ? 'btn-success' : 'btn-secondary' }}" " {{ Auth::guest() ? 'disabled' : '' }}>
                {{$link->users()->count()}}
            </button>
        </form>
    </li>
</div>
@endforeach