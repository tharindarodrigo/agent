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
            ' <div class="row">' ;
            //'<div class="col-md-1">' +
            //'<a href="#" >' +
            //'<img alt="image" class="img-circle" src="img/a7.jpg">' +
            //'</a>' +
            //'</div>';


            table += '<div class="col-md-3">';

            for ($x = 0; $x < 2; $x++) {
                table += '<img alt="image" src="images/site/adult.png">';
            }
            for ($x = 0; $x < 1; $x++) {
                table += '<img alt="image" src="images/site/child.png">';
            }


            table += '</div>' +
                '<div class="col-md-5">' +
            '<strong>' + data.rooms[index]['room_type'] + '</strong> <br>' +
            '<strong>' + data.rooms[index]['meal_basis'] + '</strong> - <strong>' + data.rooms[index]['room_specification'] + ' room</strong> <br>' +
            '</div>';


            table +=
            '<div class="col-md-3">' ;

            if (data.rooms[index]['low_hotel_rate'] != 'No Rate') {
                table += '<strong style="color: #1ab394" class=""> USD' + data.rooms[index]['low_hotel_rate'] + '&nbsp;&nbsp; </strong>';
            } else {

            }

            if (data.rooms[index]['low_hotel_rate'] != 'No Rate') {
                table += '<a hotel_id="' + data.rooms[index]['hotel_id'] + '" room_refer_key="' + data.rooms[index]['hotel_id'] + '_' + data.rooms[index]['room_type_id'] + '_' + data.rooms[index]['room_specification_id'] + '_' + data.rooms[index]['meal_basis_id'] + '"  class="room_add_to_cart btn-xs btn-primary"> <i class="fa fa-check"></i>&nbsp;Book </a>';
            } else {
                table += '<a hotel_id="' + data.rooms[index]['hotel_id'] + '" room_refer_key="' + data.rooms[index]['hotel_id'] + '_' + data.rooms[index]['room_type_id'] + '_' + data.rooms[index]['room_specification_id'] + '_' + data.rooms[index]['meal_basis_id'] + '"  class="room_request_to_cart btn-xs btn-primary"> Request </a>';
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
                var url = 'http://' + window.location.host + '/booking-aad-to-cart';

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
            toastr.success('Successfully Added To The Cart...!!');
            $('#room_rates_list').hide("blind");
        },

        error: function () {
            //alert('There was an error signing In');
        }
    });

}

function getLowestRate(url, rateData) {
    $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        data: bookingData,
        success: function (data) {
            toastr.success('Successfully Added To The Cart...!!');
        },

        error: function () {
            //alert('There was an error signing In');
        }
    });
}



