@extends('layouts.app')
@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('widgets.sidebar')
            </div>
            <div class="col-md-9">

                <div class="content-page-title">
                    <i class="fa fa-users"></i> Amigos
                </div>

                <div class="content-page-blue-title">
                    Você tem {{ $friends->count() }} amigos
                </div>

                <div class="row">
                @foreach($friends as $user_p)
                @include('profile.widgets.box')
                @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection