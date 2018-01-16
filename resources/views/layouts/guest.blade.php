<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RotaTour') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/guest.css') }}" rel="stylesheet">
</head>
<body>

<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                Descrubra novos lugares. Compartilhe os seus planos de viagem. Conheça novas pessoas com o RotaTour!
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/guest_logo.png') }}" alt="" />
            </a>
        </div>

        <div class="col-md-6">

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

        </div>

    </div>

    @include('widgets.footer')
</div>

<!-- Scripts -->
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>