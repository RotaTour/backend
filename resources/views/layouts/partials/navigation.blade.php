<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ route('index') }}" class="navbar-brand">
                {{ config('app.name', 'RotaTur') }}
            </a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            @if( Auth::check() )
            <ul class="nav navbar-nav navbar-left">
                <li><a href="{{ route('index') }}">Timeline</a></li>
                <li><a href="{{ route('friend.index') }}">Amigos</a></li>
            </ul>
            <form action="{{ route('search.results')}}" role="search" class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" name="query" id="query" class="form-control" placeholder="Encontre pessoas" >
                </div>
                <button type="submit" class="btn btn-default">Pesquisar</button>
            </form>
            @endif

            <ul class="nav navbar-nav navbar-right">
                @if( Auth::check() )
                <li>
                    <a href="{{ route('profile.show', ['email'=>Auth::user()->email])}}">
                    {{ Auth::user()->getNameOrUsername() }}
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        &nbsp;<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('profile.edit') }}">Atualizar Perfil</a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                Sair
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li>
                    @include('auth.partials.loginFormInline')
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>