<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
var geocoder;
var map;
var markers = Array();
var currentMarker;
var infos = Array();
var showInfoPage = "{{ route('place.show') }}";
var CurrentPlaceId = "";
var routeUrl = "{{ route('route.index') }}";
var getdetailsUrl = "{{ route('place.getdetails') }}";
var localPlace = {google_place_id: "", name: "", address:"", lat:"", lng:"", icon:"", scope:"", routeId: ""};
var showMap = true;

// Default location
var latDefault = -8.0176527;
var lngDefault = -34.9443739;

function resetLatLng()
{
    document.getElementById('lat').value = latDefault;
    document.getElementById('lng').value = lngDefault;
}

function resetLatLngParam(lat, lgn)
{
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lgn;
    return true;
}

function resetCeagri()
{
    latDefault = -8.0176527;
    lngDefault = -34.9443739;
    document.getElementById('lat').value = latDefault;
    document.getElementById('lng').value = lngDefault;
    initialize();
}

function resetResults()
{
    $("#markCount").html("");
    $("#div-message-danger").hide();
    $("#markersResult").html("");

}

/*
 * getCurrentGeo() = return pos {lat, lng}
 */
function getCurrentGeo()
{
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            /*
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            */

            latDefault = position.coords.latitude;
            lngDefault = position.coords.longitude

            //infoWindow.setPosition(pos);
            //infoWindow.setContent('Você está aqui.');
            //map.setCenter(pos);
            console.log('vai retornar a posição: ', latDefault, lngDefault);
            if (resetLatLngParam(latDefault, lngDefault)) {
                initialize();
            }
            
        }, function() {
            //handleLocationError(true, infoWindow, map.getCenter());
            console.log('getCurrentPosition error');
            resetCeagri();
        });
    } else {
        // Browser doesn't support Geolocation
        //handleLocationError(false, infoWindow, map.getCenter());
        console.log('navigation.geolocation error');
        // retorno defuault
        console.log('retorno default: ', latDefault, lngDefault);
        resetCeagri();
    }
        
}

function handleLocationError(browserHasGeolocation, infoWindow, pos)
{
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}

function initialize()
{
    // prepare Geocoder
    geocoder = new google.maps.Geocoder();
    // set initial position (New York)
    console.log('pos padrão: ', latDefault, lngDefault);
    var myLatlng = new google.maps.LatLng(latDefault,lngDefault);

    var myOptions = { // default map options
        zoom: 17,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map-render'), myOptions);
    currentMarker = new google.maps.Marker({
        position: myLatlng,
        icon: "{{ asset('images/armadillo-48x.png') }}"
    });
    currentMarker.setMap(map);
}

// clear overlays function
function clearOverlays()
{    
    if (markers) {
        for (i in markers) {
            markers[i].setMap(null);
        }
        markers = [];
        infos = [];

    }

}
// clear infos function
function clearInfos()
{
    if (infos) {
        for (i in infos) {
            if (infos[i].getMap()) {
                infos[i].close();
            }
        }
    }
}

// find address function
function findAddress()
{
    var address = document.getElementById("gmap_where").value;
    resetResults();
    // script uses our 'geocoder' in order to find location by address name
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) { // and, if everything is ok
            // we will center map
            var addrLocation = results[0].geometry.location;
            map.setCenter(addrLocation);
            // store current coordinates into hidden variables
            document.getElementById('lat').value = results[0].geometry.location.lat();
            document.getElementById('lng').value = results[0].geometry.location.lng();

            // if we have found something - clear map (overlays)
            clearOverlays();

            // and then - add new custom marker
            currentMarker.setMap(null);
            currentMarker = new google.maps.Marker({
                position: addrLocation,
                map: map,
                title: results[0].formatted_address,
                icon: "{{ asset('images/armadillo-48x.png') }}"
            });
            //console.log('Result: ', results[0]);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

// find custom places function
function findPlaces()
{
    // prepare variables (filter)
    var type = document.getElementById('gmap_type').value;
    var radius = document.getElementById('gmap_radius').value;
    var keyword = document.getElementById('gmap_keyword').value;
    var lat = document.getElementById('lat').value;
    var lng = document.getElementById('lng').value;
    var cur_location = new google.maps.LatLng(lat, lng);
    // prepare request to Places
    var request = {
        location: cur_location,
        radius: radius,
        types: [type]
    };
    if (keyword) {
        request.keyword = [keyword];
    }
    // send request
    service = new google.maps.places.PlacesService(map);
    service.search(request, createMarkers);
    $("#radValue").html(radius);
}
// create markers (from 'findPlaces' function)
function createMarkers(results, status)
{
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        // if we have found something - clear map (overlays)
        clearOverlays();
        resetResults();
        var markCount = results.length;
        $("#markCount").html(markCount);
        // and create new markers by search result
        for (var i = 0; i < markCount; i++) {
            createMarker(results[i]);
        }

    } else if (status == google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
        $("#div-message-danger").html("<h4>Desculpe, nada foi encontrado</h4>").show();
    }
}
// creare single marker function
function createMarker(obj)
{
    // prepare new Marker object
    var mark = new google.maps.Marker({
        position: obj.geometry.location,
        map: map,
        title: obj.name
    });
    markers.push(mark);
    
    // prepare info window
    var infowindow = new google.maps.InfoWindow({
        content: '<div class="card"><img class="img-fluid" src="' + obj.icon + '" />'+
        '<div class="card-body"><h4 class="card-title">'+obj.name+'</h4>'+
        '<p class="card-text">' + obj.vicinity + '</p>'+ 
        '<a href="javascript:;" onclick="getPlaceDetail(\''+obj.place_id+'\')" class="btn btn-primary">'+
        'Ver detalhes</a>' +
        '</div></div>'
    });

    // add event handler to current marker
    google.maps.event.addListener(mark, 'click', function() {
        clearInfos();
        infowindow.open(map,mark);
    });
    infos.push(infowindow);
    $("#markersResult").append('<div class="col-sm-6 col-md-4">'+infowindow.content+'</div>');
    //console.log('infoWindow: ', infowindow);
}

/* funções do RotaTour */
function getPlaceDetail(google_place_id)
{
    $.ajax({
        url: getdetailsUrl + "?place_id=" +google_place_id,
        type: "GET",
        dataType: 'html',
        success: function (result) {
            $("#placeDetails .modal-body").html(result);
            $(".select2").select2();
            $("#placeDetails").modal('show');
            localPlace.google_place_id = google_place_id;     
        }
    });

    return false;
}

function addToRoute()
{
    localPlace.routeId = $('#addToRouteSelect').val();
    var preloader = '<img src="https://i0.wp.com/cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif?resize=48%2C48" alt="Loading..." />';
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
        },
        error: function(){
            console.log('Server error');
            $('#resultForm').html("");
            $('#addToRouteForm').show();
        }
    });
}


// initialization
//google.maps.event.addDomListener(window, 'load', initialize);
//resetLatLng();

//getCurrentGeo();

</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAa42oli-edAepQHbkhPmgjx6Cdtw-DMe0&callback=getCurrentGeo"></script>
