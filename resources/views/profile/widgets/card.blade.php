<div class="user-card">
    <div class="cover no-cover"></div>
    <div class="detail">
        <div class="image">
            <a data-fancybox="group" href="{{ Auth::user()->getAvatarUrl() }}">
                <img class="img-circle male" src="{{ Auth::user()->getAvatarUrl() }}" alt="" />
            </a>
        </div>
        <div class="info">
            <a href="{{ url('/'.Auth::user()->getNameOrUsername()) }}" class="name">{{ Auth::user()->name }}</a>
            <a href="{{ route('profile.show', ['username'=>Auth::user()->getUsernameOrEmail()]) }}" class="username">{{ '@'.Auth::user()->getUsernameOrEmail() }}</a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>