@extends('layouts.default')

@section('content')
<div class="col-lg-5">
    <!-- User information and statuses -->
    @include('users.partials.userblock')
    <hr>
    @if(!$statuses->count())
        <p>{{ $user->getFirstNameOrUsername() }} hasn't posted anything, yet.</p>
        @else
            @foreach($statuses as $status)
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
                                <li><a href="{{ route('status.like', ['statusId'=>$status->id]) }}">Like</a></li>
                            @endif
                            <li>{{ $status->likesString() }}</li>
                        </ul>

                        @foreach( $status->replies as $reply)
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
                                        <li><a href="{{ route('status.like', ['statusId'=>$reply->id]) }}">Like</a></li>
                                    @endif
                                    <li>{{ $reply->likesString() }}</li>
                                </ul>
                            </div>
                        </div>
                        @endforeach

                        @if($authUserIsFriend || Auth::user()->id === $status->user->id)
                        <?php $classAdd = $errors->has("reply-{$status->id}") ? 'has-error': ''; ?>
                        <form action="{{ route('status.reply', ['statusId'=>$status->id]) }}" method="post" role="form">
                            {{ csrf_field() }}
                            <div class="form-group {{$classAdd}}">
                                <textarea name="reply-{{$status->id}}" rows="2"  class="form-control" placeholder="Reply to this status"></textarea>
                                @if ( $errors->has("reply-{$status->id}") )
                                <span class="help-block">
                                    <strong>{{ $errors->first("reply-{$status->id}") }}</strong>
                                </span>
                                @endif
                                <input type="submit" value="Reply" class="btn btn-default btn-sm">
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
            {!! $statuses->render() !!}
        @endif
</div>

<div class="col-lg-4 col-lg-offset-3">
    <!-- Friends, friends requests -->
    @if(Auth::user()->hasFriendRequestPending($user))
        <p>Waiting for {{ $user->getNameOrUsername() }} to accept your request</p>
    @elseif(Auth::user()->hasFriendRequestReceived($user))
        <a href="{{route('friend.accept', ['email'=>$user->email])}}" class="btn btn-primary">Accept friend request</a>
    @elseif (Auth::user()->isFriendsWith($user))
        <p>You and {{ $user->getNameOrUsername() }} are friends</p>

        <form action="{{route('friend.leave', ['email'=>$user->email])}}" method="post">
            {{ csrf_field() }}
            <input type="submit" value="leave friendship" class="btn btn-primary">
        </form>

    @elseif (Auth::user()->id != $user->id )
        <a href="{{route('friend.add', ['email'=>$user->email])}}" class="btn btn-primary">Add as friend</a>
    @endif

    <h4>{{ $user->getFirstNameOrUsername() }}'s friends.</h4>
    @if(!$user->friends()->count())
    <p>{{ $user->getFirstNameOrUsername() }} has no friends.</p>
    @else
        @foreach($user->friends() as $user)
            @include('users.partials.userblock')
        @endforeach
    @endif
</div>
@endsection

