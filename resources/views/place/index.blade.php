@extends('layouts.default')

@section('content')
<h3>Locais</h3>
<style>
#gmap_canvas {
    height: 400px;
    position: relative;
    width: 100%;
}
.actions {
    background-color: #FFFFFF;
    bottom: 30px;
    padding: 10px;
    position: absolute;
    right: 30px;
    z-index: 2;
    border-top: 1px solid #abbbcc;
    border-left: 1px solid #a7b6c7;
    border-bottom: 1px solid #a1afbf;
    border-right: 1px solid #a7b6c7;
    -webkit-border-radius: 12px;
    -moz-border-radius: 12px;
    border-radius: 12px;
}
.actions label {
    display: block;
    margin: 2px 0 5px 10px;
    text-align: left;
}
.actions input, .actions select {
    width: 85%;
}
.button {
    background-color: #d7e5f5;
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #d7e5f5), color-stop(100%, #cbe0f5));
    background-image: -webkit-linear-gradient(top, #d7e5f5, #cbe0f5);
    background-image: -moz-linear-gradient(top, #d7e5f5, #cbe0f5);
    background-image: -ms-linear-gradient(top, #d7e5f5, #cbe0f5);
    background-image: -o-linear-gradient(top, #d7e5f5, #cbe0f5);
    background-image: linear-gradient(top, #d7e5f5, #cbe0f5);
    border-top: 1px solid #abbbcc;
    border-left: 1px solid #a7b6c7;
    border-bottom: 1px solid #a1afbf;
    border-right: 1px solid #a7b6c7;
    -webkit-border-radius: 12px;
    -moz-border-radius: 12px;
    border-radius: 12px;
    -webkit-box-shadow: inset 0 1px 0 0 white;
    -moz-box-shadow: inset 0 1px 0 0 white;
    box-shadow: inset 0 1px 0 0 white;
    color: #1a3e66;
    font: normal 11px "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif;
    line-height: 1;
    margin-bottom: 5px;
    padding: 6px 0 7px 0;
    text-align: center;
    text-shadow: 0 1px 1px #fff;
    width: 150px;
}
.button:hover {
    background-color: #ccd9e8;
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ccd9e8), color-stop(100%, #c1d4e8));
    background-image: -webkit-linear-gradient(top, #ccd9e8, #c1d4e8);
    background-image: -moz-linear-gradient(top, #ccd9e8, #c1d4e8);
    background-image: -ms-linear-gradient(top, #ccd9e8, #c1d4e8);
    background-image: -o-linear-gradient(top, #ccd9e8, #c1d4e8);
    background-image: linear-gradient(top, #ccd9e8, #c1d4e8);
    border-top: 1px solid #a1afbf;
    border-left: 1px solid #9caaba;
    border-bottom: 1px solid #96a3b3;
    border-right: 1px solid #9caaba;
    -webkit-box-shadow: inset 0 1px 0 0 #f2f2f2;
    -moz-box-shadow: inset 0 1px 0 0 #f2f2f2;
    box-shadow: inset 0 1px 0 0 #f2f2f2;
    color: #163659;
    cursor: pointer;
}
.button:active {
    border: 1px solid #8c98a7;
    -webkit-box-shadow: inset 0 0 4px 2px #abbccf, 0 0 1px 0 #eeeeee;
    -moz-box-shadow: inset 0 0 4px 2px #abbccf, 0 0 1px 0 #eeeeee;
    box-shadow: inset 0 0 4px 2px #abbccf, 0 0 1px 0 #eeeeee;
}
</style>
<div id="gmap_canvas"></div>
<div class="actions">
    <div class="button">
        <label for="gmap_where">Onde:</label>
        <input id="gmap_where" type="text" name="gmap_where" /></div>
    <div id="button2" class="button" onclick="findAddress(); return false;">Pesquisar endereço</div>
    <div class="button">
        <label for="gmap_keyword">Palavras chave (opcional):</label>
        <input id="gmap_keyword" type="text" name="gmap_keyword" /></div>
    <div class="button">
        <label for="gmap_type">Tipo:</label>
        <select id="gmap_type">
            <option value="art_gallery">Galeria de Arte</option>
            <option value="atm">Autoatendimento</option>
            <option value="bank">Banco</option>
            <option value="bar">bar</option>
            <option value="cafe">café</option>
            <option value="food">Comida</option>
            <option value="hospital">Hospital</option>
            <option value="police">Polícia</option>
            <option value="store">Loja</option>
        </select>
    </div>
    <div class="button">
        <label for="gmap_radius">Raio:</label>
        <select id="gmap_radius">
            <option value="500">500</option>
            <option value="1000">1000</option>
            <option value="1500">1500</option>
            <option value="5000">5000</option>
        </select>
    </div>
    <input type="hidden" id="lat" name="lat" />
    <input type="hidden" id="lng" name="lng" />
    <div id="button1" class="button" onclick="findPlaces(); return false;">Pesquisar locais</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
var geocoder;
var map;
var markers = Array();
var infos = Array();
// Default location
var latDefault = -8.0176527;
var lngDefault = -34.9443739;

function resetLatLng()
{
    getCurrentGeo();
    document.getElementById('lat').value = latDefault;
    document.getElementById('lng').value = lngDefault;
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
        }, function() {
            //handleLocationError(true, infoWindow, map.getCenter());
            console.log('getCurrentPosition error');
        });
    } else {
        // Browser doesn't support Geolocation
        //handleLocationError(false, infoWindow, map.getCenter());
        console.log('navigation.geolocation error');
        // retorno defuault
        console.log('retorno default: ', latDefault, lngDefault);
    }
    
    
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}

function initialize() {
    // prepare Geocoder
    geocoder = new google.maps.Geocoder();
    // set initial position (New York)
    var myLatlng = new google.maps.LatLng(latDefault,lngDefault);

    var myOptions = { // default map options
        zoom: 17,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
    var marker = new google.maps.Marker({
        position: myLatlng,
        icon: "{{ asset('img/armadillo-48x.png') }}"
    });
    marker.setMap(map);
}
// clear overlays function
function clearOverlays() {
    if (markers) {
        for (i in markers) {
            markers[i].setMap(null);
        }
        markers = [];
        infos = [];
    }
}
// clear infos function
function clearInfos() {
    if (infos) {
        for (i in infos) {
            if (infos[i].getMap()) {
                infos[i].close();
            }
        }
    }
}
// find address function
function findAddress() {
    var address = document.getElementById("gmap_where").value;
    // script uses our 'geocoder' in order to find location by address name
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) { // and, if everything is ok
            // we will center map
            var addrLocation = results[0].geometry.location;
            map.setCenter(addrLocation);
            // store current coordinates into hidden variables
            document.getElementById('lat').value = results[0].geometry.location.lat();
            document.getElementById('lng').value = results[0].geometry.location.lng();
            // and then - add new custom marker
            var addrMarker = new google.maps.Marker({
                position: addrLocation,
                map: map,
                title: results[0].formatted_address,
                icon: "{{ asset('img/armadillo-48x.png') }}"
            });
            console.log('Result: ', results[0]);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}
// find custom places function
function findPlaces() {
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
}
// create markers (from 'findPlaces' function)
function createMarkers(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        // if we have found something - clear map (overlays)
        clearOverlays();
        // and create new markers by search result
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    } else if (status == google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
        alert('Desculpe, nada foi encontrado');
    }
}
// creare single marker function
function createMarker(obj) {
    // prepare new Marker object
    var mark = new google.maps.Marker({
        position: obj.geometry.location,
        map: map,
        title: obj.name
    });
    markers.push(mark);
    // prepare info window
    var infowindow = new google.maps.InfoWindow({
        content: '<img src="' + obj.icon + '" /><font style="color:#000;">' + obj.name +
        '<br />Rating: ' + obj.rating + '<br />Vicinity: ' + obj.vicinity + '</font>'
    });
    // add event handler to current marker
    google.maps.event.addListener(mark, 'click', function() {
        clearInfos();
        infowindow.open(map,mark);
    });
    infos.push(infowindow);
}
// initialization
//google.maps.event.addDomListener(window, 'load', initialize);
resetLatLng();
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAa42oli-edAepQHbkhPmgjx6Cdtw-DMe0&callback=initialize"></script>
@endsection

