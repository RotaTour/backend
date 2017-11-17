@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Your Friends</h3>
            @if( !$friends->count() )
            <p>You has no friends.</p>
            @else
                @foreach($friends as $user)
                    @include('users.partials.userblock')
                @endforeach
            @endif
        </div>
        <div class="col-lg-6">
            <h4>Friend requests</h4>
            @if( !$requests->count() )
            <p>You have not friend requests</p>
            @else
                @foreach($requests as $user)
                    @include('users.partials.userblock')
                @endforeach
            @endif
        </div>
    </div>
@endsection