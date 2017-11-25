<!-- Status -->
<div class="media">
    <a href="{{ route('profile.show', ['email'=>$status->user->email])}}" class="pull-left">
        <img src="{{ $status->user->getAvatarUrl() }}" alt="$status->user->getNameOrUsername()" class="media-object">
    </a>
    <div class="media-body">
        <h4 class="media-heading">
            <a href="{{ route('profile.show', ['email'=>$status->user->email])}}">
                {{ $status->user->getNameOrUsername() }}
            </a>
        </h4>
        <p>{{ $status->body }}</p>
        <ul class="list-inline">
            <li>{{ $status->created_at->diffForHumans() }}</li>
            @if( $status->user->id !== Auth::user()->id )
                <li>
                    <a href="{{ route('status.like', ['statusId'=>$status->id]) }}">
                    @if(Auth::user()->hasLikedStatus($status))
                    Dislike
                    @else
                    Like
                    @endif
                    </a>
                </li>
            @endif
            <li>{{ $status->likesString() }}</li>
        </ul>

        @foreach( $status->replies as $reply)
            @include('timeline.reply')
        @endforeach

        <?php $classAdd = $errors->has("reply-{$status->id}") ? 'has-error': ''; ?>
        <form action="{{ route('status.reply', ['statusId'=>$status->id]) }}" method="post" role="form">
            {{ csrf_field() }}
            <div class="form-group {{$classAdd}}">
                <textarea name="reply-{{$status->id}}" rows="2"  class="form-control" placeholder="Responder a publicação"></textarea>
                @if ( $errors->has("reply-{$status->id}") )
                <span class="help-block">
                    <strong>{{ $errors->first("reply-{$status->id}") }}</strong>
                </span>
                @endif
                <input type="submit" value="Responder" class="btn btn-default btn-sm">
            </div>
        </form>
    </div>
</div>