@extends('layouts.default')

@section('content')
<h3>{{ $route->name }}</h3>
<hr>
<div class="row">

    @foreach($route->itens()->get() as $item)
    <div class="media">
        <div class="media-left">
            <img src="{{ $item->place->json()->result->icon }}" class="media-object" style="width:60px">
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $item->place->json()->result->name }}</h4>
            <p>{{ $item->place->json()->result->formatted_address }}</p>
            <p>Adicionado em: {{ $item->created_at->diffForHumans() }}</p>
            <p>
                <a href="{{route('place.show', ['place_id'=>$item->place->google_place_id])}}">
                    Ver detalhes do lugar
                </a>  |
                <a href="{{ route('item.delete', ['id'=>$item->id]) }}">
                    Excluir
                </a>
            </p>
        </div>
    </div>
    @endforeach

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


@endsection