@extends('layouts.default')

@section('content')
<h3>Minhas Rotas</h3>
<div class="row">
    <div class="pull-right">
        <a href="{{ route('route.create') }}" class="btn btn-success">Criar nova rota</a>
    </div>
</div>

<div class="row">

    @foreach($routes as $route)
    <div class="media">
        <div class="media-body">
            <h4 class="media-heading">{{ $route->name }}</h4>
            <p>{{ $route->body }}</p>
            <p>Criada em: {{ $route->created_at->diffForHumans() }}</p>
            <p>
                <a href="{{route('route.show', ['id'=>$route->id])}}">Ver detalhes</a>  | 
                <a href="#">Excluir</a>
            </p>
        </div>
    </div>
    @endforeach

</div>


@endsection