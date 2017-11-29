@extends('layouts.default')

@section('content')
<h3>{{ $route->name }}</h3>
<hr>
<div class="row">

    @foreach($route->itens()->get() as $item)
    <div class="media">
        <div class="media-left">
            <img src="{{ $item->place->icon }}" class="media-object" style="width:60px">
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $item->place->name }}</h4>
            <p>{{ $item->place->address }}</p>
            <p>Adicionado em: {{ $item->created_at->diffForHumans() }}</p>
            <p>
                <a href="{{route('place.show', ['place_id'=>$item->place->google_place_id])}}">Ver detalhes do lugar</a>  |
                <a href="#">Excluir</a>
            </p>
        </div>
    </div>
    @endforeach

</div>


@endsection