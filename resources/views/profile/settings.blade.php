@extends('layouts.app')

@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                @if(Session::has('alert-success'))
                    <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> <strong>{!! session('alert-success') !!}</strong></div>
                @endif
                @if(Session::has('alert-danger'))
                    <div class="alert alert-danger"><i class="fa fa-times" aria-hidden="true"></i> <strong>{!! session('alert-danger') !!}</strong></div>
                @endif
            </div>

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">Configurações da Conta</div>

                    <div class="panel-body">


                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/settings') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="type" value="account" />

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nome</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $user['name'] }}" required>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Endereço de E-mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $user['email'] }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Atualizar
                                    </button>
                                </div>
                            </div>

                        </form>


                    </div>
                </div>
            </div>

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">Configurações de Username</div>

                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/settings') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="type" value="username" />

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" value="{{ $user['username'] }}" required>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Atualizar
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">Avatar</div>

                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/settings') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="type" value="avatar" />

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="avatar" class="col-md-4 control-label">Endereço do Avatar</label>

                                <div class="col-md-6">
                                    <input id="avatar" type="text" class="form-control" 
                                    name="avatar" value="{{ $user->getAvatarUrl() }}" 
                                    required placeholder="Avatar URL" >

                                    @if ($errors->has('avatar'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('avatar') }}</strong>
                                        </span>
                                    @endif

                                    <img class="image-profile img-responsive" src="{{ $user->getAvatarUrl() }}" alt="{{$user->getUsernameOrEmail()}}" />
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Atualizar
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">Configuração de senha</div>

                    <div class="panel-body">


                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/settings') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="type" value="password" />

                            <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Senha atual</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="current_password">

                                    @if ($errors->has('current_password'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('current_password') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Nova senha</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Repetir a nova senha</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Atualizar
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection