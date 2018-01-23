<nav class="navbar navbar-default navbar-static-top navbar-around">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="" />
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <div class="navbar-form navbar-left">
                <form id="custom-search-input" method="get" action="{{ url('/search') }}">
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control input-lg" name="s" 
                        placeholder="Pesquisar..." />
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>


            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle parent" data-toggle="dropdown" role="button" aria-expanded="false">

                        <img src="{{ Auth::user()->getAvatarUrl() }}" alt="" />
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ route('profile.show', ['username'=>Auth::user()->getUsernameOrEmail()]) }}">
                                <i class="fa fa-user"></i> Meu Perfil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('friend.index') }}">
                            <i class="fa fa-users"></i> Amigos
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <i class="fa fa-map"></i> Locais
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            <i class="fa fa-map-marker"></i> Rotas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.index') }}">
                                <i class="fa fa-cog"></i> Configurações
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Sair
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>