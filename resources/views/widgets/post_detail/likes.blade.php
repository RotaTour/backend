@if($post->getLikeCount() == 0)
    <div class="alert alert-danger" role="alert" style="margin: 10px;">Não há likes!</div>
@else
    <p style="padding: 10px 10px 0 10px"><small>{{ $post->getLikeCount() }} @if($post->getLikeCount() > 1){{ 'likes' }}@else{{ 'like' }}@endif</small></p>
    <ul class="list-group">
        @foreach($post->likes()->limit(2000000)->with('user')->get() as $like)
        <li class="list-group-item">
            <a href="{{ url('/'.$like->user->username) }}">
                <img src="{{ $like->user->getAvatarUrl() }}" alt="{{ $like->user->name }}" class="img-circle img-100" />
                <span class="name">{{ $like->user->name }}</span><br />
                <small>{{ '@'.$like->user->username }}</small>
            </a>
            <div class="clearfix"></div>
        </li>
        @endforeach
    </ul>
@endif