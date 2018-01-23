<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RotaTur') }}</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/pace-master/themes/white/pace-theme-flash.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/fancybox/dist/jquery.fancybox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet">
        <link href="{{ asset('css/around.css') }}" rel="stylesheet">

        @yield('header')
    </head>
    <body>
    <div id="app">
        @include('widgets.navigation')

        <div class="main-content">
            @yield('content')
        </div>

        <div class="container">
            @include('widgets.footer')
        </div>
    </div>
    <div class="loading-page">
        <img src="{{ asset('images/rolling.gif') }}" alt="">
    </div>
    @include('widgets.error')
    <!-- Scripts -->
    <script type="text/javascript">
        var BASE_URL = "{{ route('index') }}";
        var REQUEST_URL = "<?=url()->current()?>";
        var CSRF = "{{ csrf_token() }}";
        var WALL_ACTIVE = false;
    </script>
    <script src="{{ asset('plugins/jquery/jquery-2.1.4.min.js')  }}"></script>
    <script src="{{ asset('plugins/pace-master/pace.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery.serializeJSON/jquery.serializejson.min.js') }}"></script>
    <script src="{{ asset('plugins/fancybox/dist/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- <script src="//maps.google.com/maps/api/js?key=<?=config('google.places.key')?>"></script> -->
    <!-- <script src="{{ asset('plugins/gmaps/gmaps.min.js') }}"></script> -->
    
    
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a39c44a0b3c086c"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    
    <!-- <script src="{{ asset('js/notifications.js') }}"></script> -->
    <script src="{{ asset('js/around.js') }}"></script>
    <script src="{{ asset('js/wall.js') }}"></script>
    @yield('scripts')

</body>
</html>
