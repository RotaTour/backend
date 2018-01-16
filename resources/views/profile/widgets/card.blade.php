<div class="user-card">
    <div class="cover no-cover"></div>
    <div class="detail">
        <div class="image">
            <a data-fancybox="group" href="{{ Auth::user()->getAvatarUrl() }}">
                <img class="img-circle male" src="{{ Auth::user()->getAvatarUrl() }}" alt="" />
            </a>
        </div>
        <div class="info">
            <a href="{{ url('/'.Auth::user()->getNameOrUsername()) }}" class="name">{{ Auth::user()->getNameOrUsername() }}</a>
            <a href="{{ url('/'.Auth::user()->email) }}" class="username">{{ '@'.Auth::user()->email }}</a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>