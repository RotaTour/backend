<!-- Friends, friends requests -->
<div class="text-center">
    @if(Auth::user()->hasFriendRequestPending($user))
    <p>Esperando por {{ $user->getNameOrUsername() }} aceitar a sua solicitação de amizade</p>
    @elseif(Auth::user()->hasFriendRequestReceived($user))
        <a href="{{route('friend.accept', ['email'=>$user->email])}}" class="btn btn-primary">Aceitar a requisição de amizade</a>
    @elseif (Auth::user()->isFriendsWith($user))
        <!-- <p>Você e {{ $user->getNameOrUsername() }} são amigos</p> -->
        <form action="{{route('friend.leave', ['email'=>$user->email])}}" method="post">
            {{ csrf_field() }}
            <input type="submit" value="Deixar a amizade" class="btn btn-primary">
        </form>

    @elseif (Auth::user()->id != $user->id )
        <a href="{{route('friend.add', ['email'=>$user->email])}}" class="btn btn-primary">Adicionar como amigo</a>
    @endif
</div>
<!--/ Friends, friends requests -->