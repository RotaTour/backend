@extends('layouts.app')
@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('widgets.sidebar')
            </div>
            <div class="col-md-6">

                <div class="content-page-title">
                    <i class="fa fa-users"></i> Minhas Rotas
                </div>

                <div class="content-page-blue-title">
                    Você tem {{ $routes->count() }} rotas
                </div>

                <div class="row">

                @foreach($routes as $route)
                @include('route.widgets.routeCard')
                @endforeach
                </div>

            </div>

            <div class="col-xs-12 col-md-3 pull-right">
                <div class="hidden-sm hidden-xs">
                    @include('widgets.suggested_people')
                </div>
            </div>
        </div>
    </div>
@endsection