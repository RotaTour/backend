<!-- Friends, friends requests -->
<div class="text-center" id="people-listed-{{ $user->id }}">
    @if(Auth::user()->hasFriendRequestPending($user))
    <p>Esperando por {{ '@'.$user->getNameOrUsername() }} aceitar a sua solicitação de amizade</p>
    @elseif(Auth::user()->hasFriendRequestReceived($user))
        <a href="javascript:;" class="btn btn-primary">Aceitar a requisição de amizade</a>

    @elseif (Auth::user()->isFriendsWith($user))
        <a href="javascript:;" class="btn btn-primary">Deixar a amizade</a>

    @elseif (Auth::user()->id != $user->id )
        <a 
            href="javascript:;" 
            onclick="friends({{$user->id}}, '#people-listed-{{ $user->id }}', 'add')" 
            class="btn btn-primary">
            Adicionar como amigo
        </a>
    @endif
</div>
<!--/ Friends, friends requests -->