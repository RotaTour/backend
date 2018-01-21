@extends('layouts.guest')
@section('content')
<div class="tab_container">
    <input id="tab1" type="radio" name="tabs" {{ old('tab') != 'register' ? 'checked' : '' }} class="radio_hidden">
    <label for="tab1" class="head"><i class="fa fa-user"></i><span>Entrar</span></label>

    <input id="tab2" type="radio" name="tabs" {{ old('tab') == 'register' ? 'checked' : '' }} class="radio_hidden">
    <label for="tab2" class="head"><i class="fa fa-user-plus"></i><span>Registrar</span></label>

    <div class="contents">
        <section id="content1" class="tab-content">
            
            @include('auth.partials.loginform')

        </section>

        <section id="content2" class="tab-content">
            @include('auth.partials.registerform')

        </section>
    </div>
</div>
@endsection