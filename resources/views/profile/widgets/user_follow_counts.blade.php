<div class="count_widget">
    <div class="row">
        <div class="col-xs-4">
            <a class="blue" href="{{ route('profile.show', ['username'=>$user->username]) }}">
            {{ $user->statuses()->notReply()->count() }}
            </a>
            Postagens
        </div>
        <div class="col-xs-4">
            <a class="orange" href="{{ route('profile.friends', ['username'=>$user->username]) }}">
            {{ $user->friends()->count() }}
            </a>
            Amigos
        </div>
        <div class="col-xs-4">
            <a class="dark-green" href="{{ route('profile.routes', ['username'=>$user->username]) }}">
            {{ $user->routes()->count() }}
            </a>
            Rotas
        </div>
    </div>
</div>
