<ul class="media-list">
@foreach ($microposts as $micropost)
    <?php $user = $micropost->user; ?>
    <li class="media">
        <div class="media-left">
            <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
        </div>
        @include('user_follow.follow_button', ['user' => $user])
        <div class="media-body">
            <div>
                {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted">posted at {{ $micropost->created_at }}</span>
            </div>
            <div>
                <p>{!! nl2br(e($micropost->content)) !!}</p>
            </div>
            <div>
                    @if (Auth::user()->is_favouring($micropost->id))
                        {!! Form::open(['route' => ['user.unfavour', $micropost->id], 'method' => 'delete']) !!}
                            {!! Form::submit('Unfavourite', ['class' => "btn btn-success btn-xs"]) !!}
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(['route' => ['user.favour', $micropost->id]]) !!}
                            {!! Form::submit('Favourite', ['class' => "btn btn-default btn-xs"]) !!}
                        {!! Form::close() !!}
                @endif
           
            </div>
        </div>
    </li>
@endforeach
</ul>
{!! $microposts->render() !!}