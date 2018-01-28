@extends('layouts.app')

@section('content')
    <div class="h-20"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('widgets.sidebar')
            </div>
            <div class="col-md-9">

                <div class="content-page-title">
                    <i class="fa fa-map"></i> Encontre locais próximos
                </div>

                <div id="map-render" style="width: 100%; height: 500px">

                </div>

                <div class="content-page-blue-title">
                    0 locais dentro do raio de XX m!
                </div>
                
                <div class="alert-message alert-message-danger">
                    <h4>locais não encontrados.</h4>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('footer')
<script type="text/javascript">
        
</script>
@endsection