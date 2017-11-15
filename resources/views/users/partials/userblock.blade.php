<div class="media">
    <a class="pull-left" href="{{ route('profile.show', ['email'=>$user->email])}}">
        <img src="{{ $user->getAvatarUrl() }}" 
        alt="{{ $user->getNameOrUsername() }}" 
        class="media-object">
    </a>
    <div class="media-body">
        <h4 class="media-heading">
            <a href="{{ route('profile.show', ['email'=>$user->email])}}">
            {{ $user->getNameOrUsername() }}
            </a>
        </h4>
        @if( $user->location )
        <p>{{ $user->location }}</p>
        @endif
    </div>
</div>