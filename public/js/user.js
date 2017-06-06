var url = "http://laravel54.dev/user";
//display modal form for user editing
$(document).on('click','.open_modal',function(){
    var user_id = $(this).val();

    $.get(url + '/' + user_id, function (data) {
        //success data
        console.log(data);
        $('#user_id').val(data.id);
        $('#firstname').val(data.firstname);
        $('#lastname').val(data.lastname);
        $('#email').val(data.email);
        $('#personal_code').val(data.personal_code);
        $('#btn-save').val("update");
        $('#myModal').modal('show');
    })
});
//display modal form for creating new user
$('#btn_add').click(function(){
    $('#btn-save').val("add");
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
            $("#user" + user_id).remove();
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
    })
    e.preventDefault();
    var formData = {
        firstname: $('#firstname').val(),
        lastname: $('#lastname').val(),
        email: $('#email').val(),
        personal_code: $('#personal_code').val()
    }
    //used to determine the http verb to use [add=POST], [update=PUT]
    var state = $('#btn-save').val();
    var type = "POST"; //for creating new resource
    var user_id = $('#user_id').val();;
    var my_url = url;
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
            var user = '<tr id="user' + data.id + '">' +
                '<td>' + data.id + '</td>' +
                '<td>' + data.firstname + '</td>' +
                '<td>' + data.lastname + '</td>'+
                '<td>' + data.email + '</td>' +
                '<td>' + data.personal_code + '</td>';
            user += '<td><button class="btn btn-warning btn-detail open_modal" value="' + data.id + '">Edit</button>';
            user += ' <button class="btn btn-danger btn-delete delete-user" value="' + data.id + '">Delete</button></td></tr>';
            if (state == "add"){ //if user added a new record
                $('#users-list').append(user);
            }else{ //if user updated an existing record
                $("#user" + user_id).replaceWith( user );
            }
            $('#formUsers').trigger("reset");
            $('#myModal').modal('hide')
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});