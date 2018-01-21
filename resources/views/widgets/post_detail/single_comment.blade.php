<div class="panel-default post-comment" id="post-comment-{{ $comment->id }}">
    <div class="panel-body">
        <div class="pull-left">
            <a href="{{ url('/'.$comment->user->username) }}">
                <img class="media-object img-circle comment-profile-photo" src="{{ $comment->user->getAvatarUrl() }}">
            </a>
        </div>
        <div class="pull-left comment-info">
            <a href="{{ url('/'.$comment->user->username) }}" class="name">{{ $comment->user->name }}</a>
            <a href="{{ url('/'.$comment->user->username) }}" class="username">{{ '@'.$comment->user->username }}</a>
            <span class="date"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at->diffForHumans() }}</span>
            @if($post->user_id == Auth::id() || $comment->user_id == Auth::id())
                <a href="javascript:;" class="remove pull-right" onclick="removeComment({{ $comment->id }}, {{ $post->id }})"><i class="fa fa-times"></i></a>
            @endif
            <div class="clearfix"></div>
        </div>
        <br />
        <p>
            {{ $comment->body }}
        </p>
    </div>
</div>

<div class="clearfix"></div>

<hr />