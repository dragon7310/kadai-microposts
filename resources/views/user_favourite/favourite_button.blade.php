@if (Auth::id() != $user->id)
    @if (Auth::user()->is_favouring($user->id))
        {!! Form::open(['route' => ['user.unfavour', $user->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unfavourite', ['class' => "btn btn-danger btn-block"]) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['user.favour', $user->id]]) !!}
            {!! Form::submit('Favourite', ['class' => "btn btn-primary btn-block"]) !!}
        {!! Form::close() !!}
    @endif
@endif