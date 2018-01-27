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
                    {{ $route->name }}
                    <h5 class="text-muted">{{ $route->body }}</h5>
                </div>
                
                <div class="row">
                @if($route->itens()->count()<1)
                <h5>Nenhum lugar adicionado.</h5>
                @else
                    @foreach($route->itens()->get() as $item)
                        @include('route.widgets.itemCard')
                    @endforeach
                @endif
                </div>

            </div>
            
            <div class="col-xs-12 col-md-3 pull-right">  
                <div id="compartilhar">
                    <h3>Compartilhar</h3>
                    <div class="addthis_inline_share_toolbox"></div>
                </div>
                
                <div id="comentarios" class="tab-pane fade in active">
                    <h3>Comentários</h3>
                    <div class="col-xs-12 col-sm-6 col-lg-8">
                    <?php $localClass="route"; $localId=$route->id; ?>
                    @include('comment.partials.form')
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-8">
                    @foreach ($route->comments as $comment)
                        @include('comment.partials.comment')
                    @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
