@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Seus Amigos</h3>
            @if( !$friends->count() )
            <p>Você não possui amigos.</p>
            @else
                @foreach($friends as $user)
                    @include('users.partials.userblock')
                @endforeach
            @endif
        </div>
        <div class="col-lg-6">
            <h4>Solicitações de Amizades</h4>
            @if( !$requests->count() )
            <p>Você não possui solicitações de amizades</p>
            @else
                @foreach($requests as $user)
                    @include('users.partials.userblock')
                @endforeach
            @endif
        </div>
    </div>
@endsection