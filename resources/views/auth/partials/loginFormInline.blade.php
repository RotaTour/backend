<form id="signin" method="POST" action="{{ route('login') }}" class="navbar-form navbar-right" role="form">
    {{ csrf_field() }}
    <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input id="email" type="email" class="form-control" 
        name="email" value="" placeholder="Endereço de e-mail"
        required autofocus>
    </div>

    <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="password" type="password" class="form-control" 
        name="password" value="" placeholder="Senha" 
        required>
    </div>

    <button type="submit" class="btn btn-primary btn-xs">Entrar</button>
</form>