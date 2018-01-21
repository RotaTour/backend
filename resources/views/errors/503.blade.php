@extends('layouts.guest')

@section('content')
<div class="tab_container">
    <input id="tab1" type="radio" name="tabs" checked class="radio_hidden">
    <label for="tab1" class="head"><i class="fa fa-cogs"></i><span>Be back soon</span></label>

    <div class="contents">
        <section id="content1" class="tab-content" style="padding-top: 100px; padding-bottom: 200px;">
            <p>We are in maintenance mode, sorry.</p>
        </section>
    </div>
</div>

@endsection

