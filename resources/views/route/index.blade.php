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
                    <i class="fa fa-map-marker"></i> Minhas Rotas
                </div>

                <div class="content-page-blue-title">
                    Você tem {{ $routes->count() }} rotas

                    <div class="pull-right">
                        <button class="btn btn-success" id="addRouteButton">Criar nova rota</button>
                    </div>
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

    <div class="modal fade " id="addRouteModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">Criar rota</h5>
                </div>

                <div class="modal-body">
                @include('route.form')
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
$(function() {
    $("#addRouteButton").on('click', function(){
        console.log("clicou para adicionar ");
        $("#addRouteModal").modal('show');
    });
});

</script>
@endsection