<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('route.store') }}" method="post" role="form" class="form-vertical">
        {{ csrf_field() }}
        
        <div class="form-group {{ $errors->has('name') ? 'has-error': '' }}">
            <label for="name" class="control-label">Nome</label>
            <input type="text" name="name" class="form-control" id="name" 
            placeholder="Informe o nome que será exibido como título da rota">
            @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>
        
        <div class="form-group {{ $errors->has('location') ? 'has-error': '' }}">
            <label for="body" class="control-label">Descrição</label>
            <input type="text" name="body" class="form-control" id="body" 
                placeholder="Descreva em poucas palavras a rota a ser criada">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Criar</button>
        </div>
        </form>
    </div>
</div>