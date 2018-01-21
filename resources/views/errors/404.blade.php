@extends('layouts.guest')

@section('content')
<div class="tab_container">
    <input id="tab1" type="radio" name="tabs" checked class="radio_hidden">
    <label for="tab1" class="head"><i class="fa fa-times-circle"></i><span>Ooops</span></label>

    <div class="contents">
        <section id="content1" class="tab-content" style="padding-top: 100px; padding-bottom: 200px;">
            <p>404 page not found</p>
            <p><a href="{{ route('index') }}">click here to go back to index</a> </p>
        </section>
    </div>
</div>

@endsection
