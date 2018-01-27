@extends('layouts.app')

@section('content')

    <div class="profile">

        @include('profile.widgets.header')
        
        <div class="container profile-main">
            <div class="row">
                <div class="col-xs-12">
                    @if(Session::has('alert-success'))
                        <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> <strong>{!! session('alert-success') !!}</strong></div>
                    @endif
                    @if(Session::has('alert-danger'))
                        <div class="alert alert-danger"><i class="fa fa-times" aria-hidden="true"></i> <strong>{!! session('alert-danger') !!}</strong></div>
                    @endif
                </div>
            </div>
            <div class="row">

                <div class="col-md-9">
                    <div class="content-page-title">
                        <i class="fa fa-marker"></i> Rotas
                    </div>

                    <div class="content-page-blue-title">
                        {{ $user->name }} tem {{ $routes->count() }} rotas
                    </div>

                    <div class="row">
                    @foreach($routes as $route)
                        @include('route.widgets.routeCard', ['hiddenOptions'=>true])
                    @endforeach
                    </div>
                </div>
                
                <div class="col-xs-12 col-md-3 pull-right">
                    @include('profile.widgets.user_follow_counts')
                    
                    <div class="hidden-sm hidden-xs">
                        @include('widgets.suggested_people')
                    </div>
                </div>
                
            </div>
        </div>
    </div>

@endsection
