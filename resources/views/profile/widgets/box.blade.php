<!-- Box for user result -->
<div class="col-sm-6 col-md-4">
    <div class="card-container">
        <div class="card">
            <div class="front">
                <div class="cover"></div>
                <div class="user">
                    <a href="{{ route('profile.show', ['username'=>$user_p->getUsernameOrEmail()]) }}">
                        <img class="img-circle img-responsive" src="{{ $user_p->getAvatarUrl() }}"/>
                    </a>
                </div>
                <div class="content" style="padding-bottom: 20px">
                    <div class="main">
                        <a href="{{ route('profile.show', ['username'=>$user_p->getUsernameOrEmail()]) }}">
                            <h3 class="name">{{ $user_p->name }}</h3>
                            <p class="profession">
                                {{ '@'.$user_p->username }}
                                <small>{{ $user_p->location }}</small>
                            </p>
                        </a>
                        @include('friends.widgets.friendship', ['user' => $user_p])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>