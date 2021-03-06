
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
                    <i class="fa fa-map"></i> Detalhes do Local
                </div>

                @if( isset($place_id))
                    @if( isset($place))
                        @include('place.details')
                    @endif

                    <div id="compartilhar">
                        <h3>Compartilhar</h3>
                        <div class="addthis_inline_share_toolbox"></div>
                    </div>

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#comentarios">Comentários</a></li>
                        <li><a data-toggle="tab" href="#fotos">Fotos</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="comentarios" class="tab-pane fade in active">
                            <h3>Comentários</h3>
                            <div class="col-xs-12 col-sm-6 col-lg-8">
                            <?php $localClass="place"; $localId=$place->id; ?>
                            @include('comment.partials.form')
                            </div>
                            <div class="col-xs-12 col-sm-6 col-lg-8" id="comment-list">
                            @foreach ($place->comments as $comment)
                                @include('comment.partials.comment')
                            @endforeach
                            </div>
                        </div>
                        <div id="fotos" class="tab-pane fade">
                            <h3>Fotos</h3>
                            <div id="preloader"></div>
                            <div id="resultado"></div>
                        </div>
                    </div>
                @else
                <p>place_id não definido</p>
                @endif
                
            </div>

            <div class="modal fade " id="placeDetails" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title">Detalhes do local</h5>
                        </div>

                        <div class="modal-body">
                        
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
var CurrentPlaceId = "{{$place_id}}";
var Key = "AIzaSyAa42oli-edAepQHbkhPmgjx6Cdtw-DMe0";
var preloader = '<img src="https://i0.wp.com/cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif?resize=48%2C48" alt="Loading..." />';
var routeUrl = "{{ route('route.index') }}";
var localPlace = {google_place_id: "", name: "", address:"", lat:"", lng:"", icon:"", scope:"", routeId: ""};

function addToRoute()
{
    localPlace.routeId = $('#addToRouteSelect').val();
    $('#resultForm').html(preloader);
    $('#addToRouteForm').hide();
    $.ajax({
        url: "{{ route('route.addToRoute') }}",
        type: "GET",
        data: localPlace,
        dataType: 'json',
        success: function (result) {
            console.log('result: ', result);
            var html = 'Sucesso: '+result.body
                +' <a href="'+routeUrl+'/show/'+localPlace.routeId+'">'+
                result.name+'</a>';
            $('#resultForm').html(html);
            $('#addToRouteForm').show();
        }
        //complete: logResultado,
    });
}

function makeHtml(obj)
{
    var preloader = '<img src="https://i0.wp.com/cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif?resize=48%2C48" alt="Loading..." />';
    $('#preloader').html(preloader);
    localPlace.google_place_id = obj.place_id;
    localPlace.name = obj.name;
    localPlace.address = obj.formatted_address;
    localPlace.icon = obj.icon;
    localPlace.scope = obj.scope;

    var html = "";
    var contagem = 0;
    for(var photo in obj.photos)
    {
        if(contagem > 2){
            contagem = 0;
            html = html.concat('<br>');
        }
        var imgUrl = obj.photos[photo].getUrl({ 'maxWidth': 400 , 'maxHeight': 400 });
        html = html.concat('<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 img-400">');
        html = html.concat('<a href="'+imgUrl+'" data-fancybox data-caption="'+obj.name+'">');
        html = html.concat('<img src="'+imgUrl+'" alt='+obj.place_id+' class="img-responsive img-rounded" />\n');
        html = html.concat('</a>\n');
        html = html.concat('</div>\n');
    }
    
    html = html.concat('<br>\n');
    
    $('#resultado').html(html);
    //$("a.grouped_elements").fancybox({});
    $('#preloader').html('');
}

function showDetails() 
{
    var request = {
        placeId: CurrentPlaceId
    };

    service = new google.maps.places.PlacesService(document.createElement('div'));
    service.getDetails(request, callback);

    function callback(place, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {
            //console.log(JSON.stringify(place));
            //console.log(place);
            makeHtml(place);
        } else {
            console.log('error: ', status);
        }
    }
}

</script>
<!-- apenas para buscar as fotos -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAa42oli-edAepQHbkhPmgjx6Cdtw-DMe0&callback=showDetails"></script>

@endsection