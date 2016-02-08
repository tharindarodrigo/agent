/**
 * Created by thilina on 2015-09-12.
 */


/********************** For Room Cart **************************/

function sendBookingData(url, formData) {
    $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        data: formData,
        success: function (data) {
            if (data == null) {
                $('#room_rates_list').hide("blind");
            } else {

                var tablecontent = generateRoomRateTable(data);
                $('#room_rates').html(tablecontent);

                $('.room_add_to_cart').click(function () {

                    var url = 'http://' + window.location.host + '/add-to-cart';
                    var room_refer_id = $(this).closest('.room_add_to_cart').attr('room_refer_key');
                    var hotel_id = $(this).closest('.room_add_to_cart').attr('hotel_id');

                    var cartData = new FormData();
                    cartData.append('room_refer_id', room_refer_id);
                    cartData.append('hotel_id', hotel_id);

                    sendBookingCartData(url, cartData);

                });

                $('.rate_request_to_cart').click(function () {

                    var url = 'http://' + window.location.host + '/request-rate';
                    var room_refer_id = $(this).closest('.rate_request_to_cart').attr('room_refer_key');

                    var requestRateData = new FormData();
                    requestRateData.append('room_refer_id', room_refer_id);

                    requestRoom(url, requestRateData);

                });

                $('.room_request_to_cart').click(function () {

                    var url = 'http://' + window.location.host + '/request-allotment';
                    var room_refer_id = $(this).closest('.room_request_to_cart').attr('room_refer_key');

                    var requestRoomData = new FormData();
                    requestRoomData.append('room_refer_id', room_refer_id);

                    requestAllotment(url, requestRoomData);

                });

                $('#room_rates_list').show("blind", 500);


                //deleteRoom();
            }

        },

        error: function () {
            //alert('There was an error signing In');
        }
    });
}

function generateRoomRateTable(data) {

    var table = '';

    if (data != null) {

        $('#hotel_name_h5').html('&nbsp;&nbsp;&nbsp;' + data.hotel_name);

        $.each(data.rooms, function (index, item) {

            table += '<div style="padding-top: 10px; padding-bottom: 10px" class="feed-element">' +
            '<div class="row">' +
            '<div class="col-md-2">' +
            '<a href="#" >' +
            '<img alt="image" class="img-circle" src="img/a7.jpg">' +
            '</a>' +
            '</div>';

            table += '<div class="col-md-5">' +
            '<strong>' + data.rooms[index]['room_type'] + '</strong> <br>' +
            '<small>' + data.rooms[index]['meal_basis'] + '</small> - <small>' + data.rooms[index]['room_specification'] + ' room</small> <br>' +
            '</div>';

            var x = data.rooms[index]['allotments'];

            if ((data.rooms[index]['low_room_rate']) != 0 && (x > 0)) {

                table += '<div style="padding-left: 0px;" class="col-md-2">' +
                '<select> ';

                for (var i = 0; i <= x; i++) {
                    table += '<option value="' + i + '">' + i + '</option>';
                }

                table += '</select> <br/>' +
                '<small style="color: #ed5565">' + data.rooms[index]['allotments'] + ' room' + '</small>' +
                '</div>';

                table += '<div class="col-md-3" style="padding-left: 10px; padding-right: 0px;">' +
                '<strong style="color: #1ab394" class=""> USD' + data.rooms[index]['low_room_rate'] + '&nbsp;&nbsp; </strong> <br/>' +
                '<a hotel_id="' + data.rooms[index]['hotel_id'] + '" room_refer_key="' + data.rooms[index]['hotel_id'] + '_' + data.rooms[index]['room_type_id'] + '_' + data.rooms[index]['room_specification_id'] + '_' + data.rooms[index]['meal_basis_id'] + '"  class="room_add_to_cart btn-xs btn-primary"> <i class="fa fa-check"></i>&nbsp;Book </a> <br/>';

            } else if (data.rooms[index]['low_room_rate'] != 0) {

                table += '<div class="col-md-5" style="padding-left: 10px; padding-right: 0px;">' +
                '<strong style="color: #1ab394" class=""> USD' + data.rooms[index]['low_room_rate'] + '&nbsp;&nbsp; </strong> <br/>' +
                '<a hotel_id="' + data.rooms[index]['hotel_id'] + '" room_refer_key="' + data.rooms[index]['hotel_id'] + '_' + data.rooms[index]['room_type_id'] + '_' + data.rooms[index]['room_specification_id'] + '_' + data.rooms[index]['meal_basis_id'] + '"  class="room_request_to_cart btn-xs btn-primary"> <i class="fa fa-check"></i>&nbsp;Request Room </a> <br/>';

            } else {

                table += '<div class="col-md-5" style="padding-left: 10px; padding-right: 0px;">' +
                '<a hotel_id="' + data.rooms[index]['hotel_id'] + '" room_refer_key="' + data.rooms[index]['hotel_id'] + '_' + data.rooms[index]['room_type_id'] + '_' + data.rooms[index]['room_specification_id'] + '_' + data.rooms[index]['meal_basis_id'] + '"  class="rate_request_to_cart btn-xs btn-primary" style="background: #d75124; border-color: #d75124"> Request Rate</a>';
            }

            table += '</div>' +
            '</div>' +
            '</div>';

        });


    }

    return table;

}

function deleteRoom() {

    $('.delete_room').click(function () {

        var formData = new FormData();
        //alert($(this).val());
        var del_room_id = $(this).val();

        var url = 'http://' + window.location.host + '/sri-lanka/get_room_rate_box/delete';

        formData.append('del_room_id', del_room_id);

        sendBookingData(url, formData);

    });

}


/********************** For Bookings Cart **************************/

function sendBookingCartData(url, cartData) {
    $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        data: cartData,
        success: function (data) {

            if (data == null) {
                toastr.success('Sorry No Rate Available...!!');
            } else {

                var hotel_id = data;
                var url = 'http://' + window.location.host + '/booking-add-to-cart';

                var bookingData = new FormData();
                bookingData.append('hotel_id', hotel_id);

                bookingCartDataAddToCart(url, bookingData);
            }
        },

        error: function () {
            //alert('There was an error signing In');
        }
    });
}


/********************** For Bookings Cart **************************/

function bookingCartDataAddToCart(url, bookingData) {
    $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        data: bookingData,
        success: function (data) {
            $('#room_rates_list').hide("blind");
            location.reload();
            toastr.success('Successfully Added To The Cart...!!');
        },

        error: function () {
            //alert('There was an error signing In');
        }
    });

}

// Request Rate

function requestRoom(url, requestRateData) {
    $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        data: requestRateData,
        success: function (data) {
            location.reload();
        },

        error: function () {
            //alert('There was an error signing In');
        }
    });
}

// Request Room

function requestAllotment(url, requestRoomData) {
    $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        data: requestRoomData,
        success: function (data) {
            location.reload();
        },

        error: function () {
            //alert('There was an error signing In');
        }
    });
}




