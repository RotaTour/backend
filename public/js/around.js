/**
 * Created by lvntayn on 03/06/2017.
 */

$(function() {
    $('.datepicker').datepicker();

    $('[data-toggle="tooltip"]').tooltip();

    $(".select2-multiple").select2();
    $(".js-example-placeholder-single").select2({
        placeholder: "Select a state",
        allowClear: true
    });

    
    friendsRequests();
    setInterval(function(){
        friendsRequests();
    }, 40000);
    
});

window.resetFile = function (e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
};

function makeSerializable(elem) {
    return $(elem).prop('elements', $('*', elem).andSelf().get());
}


var location_finder = "not-running";
var found_location = "";
function getLocation() {
    if (navigator.geolocation) {
        return navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        $('#errorMessageModal').modal('show');
        $('#errorMessageModal #errors').html("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    var location = {latitude: position.coords.latitude, longitude: position.coords.longitude};
    location_finder = "found";
    found_location = location;
}

function showError(error) {
    var error_msg = null;
    switch(error.code) {
        case error.PERMISSION_DENIED:
            error_msg = "You denied the request for Geolocation.";
            break;
        case error.POSITION_UNAVAILABLE:
            error_msg = "Location information is unavailable.";
            break;
        case error.TIMEOUT:
            error_msg = "The request to get user location timed out.";
            break;
        case error.UNKNOWN_ERROR:
            error_msg = "An unknown error occurred.";
            break;
    }
    $('#errorMessageModal').modal('show');
    $('#errorMessageModal #errors').html(error_msg);
    location_finder = "not-found";
}


var found_location2 = "";
var location_finder2 = "not-running";
function getLocation2() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition2);
    } else {
        location_finder2 = "not-found";
    }
}
function showPosition2(position) {
    found_location2 = {latitude: position.coords.latitude, longitude: position.coords.longitude};
    location_finder2 = "found";
}

function autoFindLocation(){

    location_finder2 = "running";

    getLocation2();


    var updated = false;
    var timer = setInterval(function(){
        if (location_finder2 == 'found'){

            $.ajax({
                url: BASE_URL+'/save-my-location',
                type: "GET",
                timeout: 5000,
                data: "latitude="+found_location2.latitude+"&longitude="+found_location2.longitude,
                contentType: false,
                cache: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': CSRF},
                success: function(response){

                },
                error: function(){
                }
            });

            clearInterval(timer);
        }else{
            if (updated == false) {
                $.ajax({
                    url: BASE_URL + '/save-my-location2',
                    type: "GET",
                    timeout: 5000,
                    data: "",
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function (response) {

                    },
                    error: function () {
                    }
                });
            }
            updated = true;
        }

    }, 1);
}

function friends(user_id, element, action){

    var data = new FormData();
    data.append('user_id', user_id);
    var ActionUrl = "";

    if(action=="add"){
        ActionUrl = BASE_URL + '/friends/add/'+user_id;
    } else if (action=="accept") {
        ActionUrl = BASE_URL + '/friends/accept/'+user_id;
    } else if (action=="leavefriendship"){
        ActionUrl = BASE_URL + '/friends/leavefriendship/'+user_id;
    }

    if(ActionUrl=="") return false;

    $.ajax({
        url: ActionUrl,
        type: "GET",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                $(element).html(response.html);
            } else {
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html(response.message);
            }
        },
        error: function () {
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
        }
    });
}

function friendsRequests()
{
    //var ActionUrl = BASE_URL + '/friends/requests/';
    var ActionUrl = '/friends/requests/';
    var Ul = $("#friendsNotification");
    var CountSpan = $("#friendsNotificationCount");

    $.ajax({
        url: ActionUrl,
        type: "GET",
        timeout: 5000,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                var html = "";
                var count = response.requests.length;
                if(count>0){
                    response.requests.forEach( function(item, index) {
                        var userUrl = BASE_URL +'/'+ response.requests[index].username;
                        var name = response.requests[index].name;
                        var elem = '<li><a href="'+userUrl+'"><i class="fa fa-user"></i>'+name+'</a><br></li>';
                        html = html.concat(elem);
                    });
                    Ul.html(html);
                    CountSpan.html(count);
                } else {
                    var elem = '<li style="padding: 10px"><a href="javascript:;">Não há notificações.</a></li>';
                    Ul.html(elem);
                    CountSpan.html('');
                }
            } else {
              console.log("response code is not 200");
            }
        },
        error: function () {
            console.log("Server error response");
        }
    });
}



function follow(following, follower, element, size){

    var data = new FormData();
    data.append('following', following);
    data.append('follower', follower);
    data.append('element', element);
    data.append('size', size);


    $.ajax({
        url: BASE_URL + '/follow',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                $(element).html(response.button);
                if (response.refresh == 1 && size != '.btn-no-refresh'){
                    location.reload();
                }
            } else {
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
            }
        },
        error: function () {
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
        }
    });

}

function followRequest(type, id){

    var data = new FormData();
    data.append('type', type);
    data.append('id', id);

    $.ajax({
        url: BASE_URL + '/follower/request',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                $('#approve-buttons-'+id+' .btn').remove();
                if (type == 1){
                    $('#approve-buttons-'+id+' .approved').show();
                }else{
                    $('#approve-buttons-'+id+' .denied').show();
                }
            } else {
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
            }
        },
        error: function () {
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
        }
    });

}

function deniedFollow(me, follower, element, size){

    var data = new FormData();
    data.append('me', me);
    data.append('follower', follower);
    data.append('element', element);
    data.append('size', size);


    $.ajax({
        url: BASE_URL + '/follower/denied',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                location.reload();
            } else {
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
            }
        },
        error: function () {
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
        }
    });

}


function relativeRequest(type, id){

    var data = new FormData();
    data.append('type', type);
    data.append('id', id);

    $.ajax({
        url: BASE_URL + '/relative/request',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                $('#approve-buttons-'+id+' .btn').remove();
                if (type == 1){
                    $('#approve-buttons-'+id+' .approved').show();
                }else{
                    $('#approve-buttons-'+id+' .denied').show();
                }
            } else {
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
            }
        },
        error: function () {
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
        }
    });

}

function removeRelation(type, id){

    BootstrapDialog.show({
        title: 'Relationship Delete!',
        message: 'Are you sure to delete ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('type', type);
                data.append('id', id);


                $.ajax({
                    url: BASE_URL + '/relative/delete',
                    type: "POST",
                    timeout: 5000,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        dialog.close();
                        if (response.code == 200){
                            location.reload();
                        }else{
                            $('#errorMessageModal').modal('show');
                            $('#errorMessageModal #errors').html('Something went wrong!');
                        }
                    },
                    error: function(){
                        dialog.close();
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html('Something went wrong!');
                    }
                });
            }
        }, {
            label: 'No!',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
}