@extends('layouts.guest')
@section('content')
<div class="tab_container">
    <input id="tab1" type="radio" name="tabs" {{ old('tab') != 'register' ? 'checked' : '' }} class="radio_hidden">
    <label for="tab1" class="head"><i class="fa fa-user"></i><span>Entrar</span></label>

    <div class="contents">
        <section id="content1" class="tab-content">
            @include('auth.partials.loginform')
        </section>
    </div>
</div>
@endsection