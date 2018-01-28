<div class="menu">
    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ route('index') }}" class="menu-home">
                <i class="fa fa-home"></i>
                Home
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('friend.index') }}" class="menu-groups">
                <i class="fa fa-users"></i>
                Amigos
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('place.index') }}" class="menu-nearby">
                <i class="fa fa-map"></i>
                Locais
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('route.index') }}" class="menu-routes">
                <i class="fa fa-map-marker"></i>
                Rotas
            </a>
        </li>
    </ul>
</div>