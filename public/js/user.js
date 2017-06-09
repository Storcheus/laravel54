var url = "http://laravel54.dev";
//display modal form for user editing


$(document).on('click','.open_modal',function(){
    var user_id = $(this).val();
    $('#formUsers').find('.address').remove();
    $('#formUsers').find('.alert-danger').remove();
    $('#deletedAddress').val('');

    $.get(url + '/' + user_id, function (data) {
        //success data
        console.log(data);
        $('#user_id').val(data.id);
        $('#firstname').val(data.firstname);
        $('#lastname').val(data.lastname);
        $('#email').val(data.email);
        $('#personal_code').val(data.personal_code);

        if (data.address.length > 0) {

            for(i = 0; i < data.address.length; i++) {

                var div = $('<div/>', {
                    'class': 'address form-group'
                }).appendTo($('#addressContainer'));


                var addressBlock = '<div class="form-group">' +
                    '<label for="country" class="col-sm-2 col-xs-2 control-label">Country</label>'+
                    '<div class="col-sm-4 col-xs-4">'+
                    '<input type="text" class="form-control" id="country[]" name="country[]" placeholder="Country" value="'+data.address[i].country+'">'+
                    '</div>'+
                    '<label for="city" class="col-sm-1 col-xs-1 control-label">City</label>'+
                    '<div class="col-sm-4 col-xs-4">'+
                    '<input type="text" class="form-control" id="city[]" name="city[]" placeholder="City" value="'+data.address[i].city+'">'+
                    '</div>'+
                    '<label for="address" class="col-sm-2 col-xs-2 control-label" style="padding-top: 15px;">Address</label>'+
                    '<div class="col-sm-8 col-xs-8" style="padding-top: 10px;">'+
                    '<input type="text" class="form-control" id="address[]" name="address[]" placeholder="Address" value="'+data.address[i].address+'">'+
                    '</div>' +
                    '<input type="hidden" id="address_id[]" name="address_id[]" value="'+data.address[i].id+'">'+
                    '<div class="col-sm-1 col-xs-1" style="padding-top: 10px;">'+
                    '<input value="-" type="button" class="btn btn-danger deteleAddress">'+
                    '</div>'+
                    '</div>';

                $(addressBlock).appendTo(div);

                $('.deteleAddress').click(function() {
                    var id = $(this).parent().parent().find('input[name^="address_id"]').val();
                    $('#deletedAddress').val($('#deletedAddress').val()+id+',');
                    $(this).parent().parent().remove();
                });
            }
        }
        $('#btn-save').val("update");
        $('#myModal').modal('show');
    })
});

//display modal form for creating new user
$('#btn_add').click(function(){
    $('#btn-save').val("add");
    $('#formUsers').find('.address').remove();
    $('#formUsers').trigger("reset");
    $('#myModal').modal('show');
});
//delete user and remove it from list
$(document).on('click','.delete-user',function(){
    var user_id = $(this).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        type: "DELETE",
        url: url + '/' + user_id,
        success: function (data) {
            console.log(data);
            if(data.errors) {
                $('#messages').text('').append(''+data.message+'').css('display', 'block');
                $('#messages').delay(3000).hide(0);
            }
            else {
                $('#messages').text('').append(''+data.message+'').css('display', 'block');
                $('#messages').delay(3000).hide(0);
                $("#user" + user_id).remove();
            }
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});
//create new user / update existing user
$("#btn-save").click(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    e.preventDefault();

    //used to determine the http verb to use [add=POST], [update=PUT]
    var state = $('#btn-save').val();
    var type = "POST"; //for creating new resource
    var user_id = $('#user_id').val();
    var my_url = url;
    var addressList = [];

    var country = '';
    var city = '';
    var address = '';

    $('.address').each(function() {

        country = $(this).find('input[name^="country"]').val();
        city = $(this).find('input[name^="city"]').val();
        address = $(this).find('input[name^="address"]').val();
console.log("country");
        if (country != undefined || city != undefined || address != undefined ) {
            console.log("    country10");
            if (country.length != 0 || city.length != 0 || address.length != 0) {
                addressList.push({
                    user_id: parseInt(user_id),
                    id: parseInt($(this).find('input[name^="address_id"]').val()),
                    country: country,
                    city: city,
                    address: address
                });
            }
        }
    });

    var formData = {
        firstname: $('#firstname').val(),
        lastname: $('#lastname').val(),
        email: $('#email').val(),
        personal_code: $('#personal_code').val(),
        address: addressList,
        deletedAddress: $('#deletedAddress').val(),
    };

    if (state == "update"){
        type = "PUT"; //for updating existing resource
        my_url += '/' + user_id;
    }
    console.log(formData);
    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#formUsers').find('.alert-danger').remove();
            if (data.errors) {
                    $('#formUsers').prepend('<div class="alert alert-danger">'+
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                        '<strong></strong>'+data.errors.join('<br/>')+
                        '</div>');
            } else {
                $('#messages').text('').append(''+data.message+'').css('display', 'block');
              //  $('#messages').append(''+data.message+'');
               // $('#messages').css('display', 'block');
                $('#messages').delay(3000).hide(0);

                var user = '<tr id="user' + data.user.id + '">' +
                    '<td>' + data.user.id + '</td>' +
                    '<td>' + data.user.firstname + '</td>' +
                    '<td>' + data.user.lastname + '</td>' +
                    '<td>' + data.user.email + '</td>' +
                    '<td>' + data.user.personal_code + '</td>';
                user += '<td><button class="btn btn-warning btn-detail open_modal" value="' + data.user.id + '">Edit</button>';
                user += ' <button class="btn btn-danger btn-delete delete-user" value="' + data.user.id + '">Delete</button></td></tr>';

                if (state == "add" && $('tr[id^="user"]').length < 5) { //if user added a new user
                    $('#users-list').append(user);
                } else { //if user updated an existing user
                    $("#user" + user_id).replaceWith(user);
                }
                $('#formUsers').trigger("reset");
                $('#myModal').modal('hide')
            }
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});
