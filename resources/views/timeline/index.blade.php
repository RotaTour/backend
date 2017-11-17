@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('status.store') }}" method="post" role="form">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('status') ? 'has-error': '' }}">
                <textarea name="status" rows="2" class="form-control" placeholder="What's up {{Auth::user()->getFirstNameOrUsername()}}?"></textarea>
                @if ($errors->has('status'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
                @endif
            </div>
            <button type="submit" class="btn btn-default">Update status</button>
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-5">
        <!--Timeline statuses and replies -->
        @if(!$statuses->count())
        <p>There's nothing in your timeline, yet.</p>
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
                            <li><a href="#">Like</a></li>
                            <li>10 likes</li>
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
                                    <li><a href="#">Like</a></li>
                                    <li>10 likes</li>
                                </ul>
                            </div>
                        </div>
                        @endforeach

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
                    </div>
                </div>
            @endforeach

            {!! $statuses->render() !!}
        @endif
    </div>
</div>
@endsection