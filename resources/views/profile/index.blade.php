@extends('layouts.default')

@section('content')
<div class="col-lg-5">
    <!-- User information and statuses -->
    @include('users.partials.userblock')
    <hr>
    @if(!$statuses->count())
        <p>{{ $user->getFirstNameOrUsername() }} não publicou, ainda.</p>
        @else
            @foreach($statuses as $status)
                @include('timeline.status')
            @endforeach
            {!! $statuses->render() !!}
        @endif
</div>

<div class="col-lg-4 col-lg-offset-3">
    <!-- Friends, friends requests -->
    @if(Auth::user()->hasFriendRequestPending($user))
        <p>Esperando por {{ $user->getNameOrUsername() }} aceitar a sua solicitação de amizade</p>
    @elseif(Auth::user()->hasFriendRequestReceived($user))
        <a href="{{route('friend.accept', ['email'=>$user->email])}}" class="btn btn-primary">Aceitar a requisição de amizade</a>
    @elseif (Auth::user()->isFriendsWith($user))
        <p>Você e {{ $user->getNameOrUsername() }} são amigos</p>

        <form action="{{route('friend.leave', ['email'=>$user->email])}}" method="post">
            {{ csrf_field() }}
            <input type="submit" value="Deixar a amizade" class="btn btn-primary">
        </form>

    @elseif (Auth::user()->id != $user->id )
        <a href="{{route('friend.add', ['email'=>$user->email])}}" class="btn btn-primary">Adicionar como amigo</a>
    @endif

    <h4>Amigos de {{ $user->getFirstNameOrUsername() }}</h4>
    @if(!$user->friends()->count())
    <p>{{ $user->getFirstNameOrUsername() }} não possui amigos.</p>
    @else
        @foreach($user->friends() as $user)
            @include('users.partials.userblock')
        @endforeach
    @endif
</div>
@endsection

