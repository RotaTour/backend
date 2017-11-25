@extends('layouts.default')

@section('content')
  <div class="col-sm-6">
    <h3>Bem vindo(a) !!!</h3>
    <p>A melhor rede social para Turismo!!!</p>
    <div >
      <img src="{{ asset('./img/logo_v2.png')}}" alt="RotaTour Logo v2" class="img-responsive">
    </div>
  </div>
  <div class="col-sm-6">
    <h3>Criar uma nova conta</h3>
    @include('auth.partials.registerform')
  </div>

@endsection
