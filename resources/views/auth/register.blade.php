@extends('layouts.guest')
@section('content')
<div class="tab_container">
    <input id="tab1" type="radio" name="tabs" checked class="radio_hidden">
    <label for="tab1" class="head"><i class="fa fa-user-plus"></i><span>Registrar</span></label>

    <div class="contents">
        <section id="content1" class="tab-content" style="display: block;">
            @include('auth.partials.registerform')
        </section>
    </div>
</div>
@endsection