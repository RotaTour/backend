<div class="media">
    <a href="{{ route('profile.show', ['email'=>$comment->user->email])}}" class="pull-left">
        <img src="{{ $comment->user->getAvatarUrl() }}" alt="$comment->user->getNameOrUsername()" class="media-object">
    </a>
    <div class="media-body">
        <h4 class="media-heading">
            <a href="{{ route('profile.show', ['email'=>$comment->user->email])}}">
                {{ $comment->user->getNameOrUsername() }}
            </a>
        </h4>
        <p>{{ $comment->body }}</p>
        <ul class="list-inline">
            <li>{{ $comment->created_at->diffForHumans() }}</li>
            @if($comment->user->id == Auth::user()->id)
            <li>
                <a href="{{ route('comment.delete', ['comment_id'=>$comment->id]) }}"> Excluir </a>
            </li>
            @endif
        </ul>
    </div>
</div>