<!-- Status->Reply -->
<div class="media">
    <a href="{{ route('profile.show', ['email'=>$reply->user->email])}}" class="pull-left">
        <img src="{{ $reply->user->getAvatarUrl()}}" alt="{{ $reply->user->getNameOrUsername()}}" class="media-object">
    </a>
    <div class="media-body">
        <h5 class="media-heading">
            <a href="{{ route('profile.show', ['email'=>$reply->user->email])}}">
            {{ $reply->user->getNameOrUsername()}}
            </a>
        </h5>
        <p>{{ $reply->body }}</p> 
        <ul class="list-inline">
            <li>{{ $reply->created_at->diffForHumans() }}</li>
            @if( $reply->user->id !== Auth::user()->id )
                <li>
                    <a href="{{ route('status.like', ['statusId'=>$reply->id]) }}">
                    @if(Auth::user()->hasLikedStatus($reply))
                    Dislike
                    @else
                    Like
                    @endif
                    </a>
                </li>
            @endif
            <li>{{ $reply->likesString() }}</li>
        </ul>
    </div>
</div>