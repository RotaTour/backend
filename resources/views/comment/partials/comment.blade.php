<div class="media" id="comment-{{$comment->id}}">
    <a href="{{ route('profile.show', ['username'=>$comment->user->username])}}" class="pull-left">
        <img src="{{ $comment->user->getAvatarUrl() }}" alt="$comment->user->getNameOrUsername()" class="media-object img-100">
    </a>
    <div class="media-body">
        <h4 class="media-heading">
            <a href="{{ route('profile.show', ['username'=>$comment->user->username])}}">
                {{ $comment->user->getNameOrUsername() }}
            </a>
        </h4>
        <p>{{ $comment->body }}</p>
        <ul class="list-inline">
            <li>{{ $comment->created_at->diffForHumans() }}</li>
            @if($comment->user->id == Auth::user()->id)
            <li>
                <a href="javascript:;" onclick="deleteComment('{{$comment->id}}')">
                    <i class="fa fa-trash"></i>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>