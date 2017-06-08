$('#addAddress').click(function(event) {
    addAddress();
    return false;
});

function addAddress() {
    var div = $('<div/>', {
        'class': 'address form-group'
    }).appendTo($('#addressContainer'));


    var addressBlock = '<div class="form-group">' +
        '<label for="country" class="col-sm-2 col-xs-2 control-label">Country</label>'+
        '<div class="col-sm-4 col-xs-4">'+
        '<input type="text" class="form-control" id="country[]" name="country[]" placeholder="Country" value="">'+
        '</div>'+
        '<label for="city" class="col-sm-1 col-xs-1 control-label">City</label>'+
        '<div class="col-sm-4 col-xs-4">'+
        '<input type="text" class="form-control" id="city[]" name="city[]" placeholder="City" value="">'+
        '</div>'+
        '<label for="address" class="col-sm-2 col-xs-2 control-label" style="padding-top: 15px;">Address</label>'+
        '<div class="col-sm-8 col-xs-8" style="padding-top: 10px;">'+
        '<input type="text" class="form-control" id="address[]" name="address[]" placeholder="Address" value="">'+
        '</div>' +
        '<div class="col-sm-1 col-xs-1" style="padding-top: 10px;">'+
        '<input value="-" type="button" class="btn btn-danger deteleAddress">'+
        '</div>'+
        '</div>';

    $(addressBlock).appendTo(div);

    $('.deteleAddress').click(function() {
        $(this).parent().parent().remove();
    });

}