<div class="media" id="route-card-{{$route->id}}">
    <div class="media-left">
        <img src="{{ asset('images/route-64.png') }}" class="media-object" style="width:60px"></img>
    </div>
    <div class="media-body">
        <a href="{{route('route.show', ['id'=>$route->id])}}">
            <h4 class="media-heading">{{ $route->name }}</h4>
        </a>
        <p>{{ $route->body }}</p>
        <p>Criada em: {{ $route->created_at->diffForHumans() }}</p>
        <p>Possui {{ $route->itens()->count() }} Itens</p>
        @unless( isset($hiddenOptions) )
        <p class="pull-right">
            <a href="{{ route('route.show', ['id'=>$route->id]) }}">
                <i class="fa fa-eye"></i>
            </a>
            &nbsp;&nbsp;
            @if($route->user_id == Auth::user()->id)
            <a href="javascript:;" onclick="openModalForm('editRouteModal-'+'{{ $route->id }}')">
                <i class="fa fa-pencil-square-o"></i>
            </a>
            &nbsp;&nbsp;
            <a href="{{ route('route.delete', ['id'=>$route->id]) }}">
                <i class="fa fa-trash"></i>
            </a>
            @endif
        </p>
        @endunless
    </div>
</div>

<div class="modal fade " id="editRouteModal-{{ $route->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">Editar rota - {{ $route->name }}</h5>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('route.update', ['id'=>$route->id]) }}" method="post" role="form" class="form-vertical">
                            {{ csrf_field() }}
                            
                            <div class="form-group {{ $errors->has('name') ? 'has-error': '' }}">
                                <label for="name" class="control-label">Nome</label>
                                <input type="text" name="name" class="form-control" id="name" 
                                placeholder="Informe o nome que será exibido como título da rota"
                                value="{{$route->name}}">
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="form-group {{ $errors->has('location') ? 'has-error': '' }}">
                                <label for="body" class="control-label">Descrição</label>
                                <input type="text" name="body" class="form-control" id="body" 
                                    placeholder="Descreva em poucas palavras a rota a ser criada"
                                    value="{{$route->body}}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- /modal-body -->
        </div>
    </div>

<hr>