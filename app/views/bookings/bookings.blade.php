@extends('layout.master')

@section('title')

    <title> srilankahotel.travel - Bookings</title>

@endsection

@section('style')

    @yield('styles')

    {{HTML::style('assets/css/jquery-ui.css')}}

@endsection

@section('bread-crumbs')
    @yield('bread-crumbs')
@endsection

@section('main-title')
    Bookings
@endsection

@section('content')

    @yield('body-content')

@endsection

@section('script')
    {{HTML::script('js/functions/add_clients.js')}}
    {{HTML::script('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js')}}
    {{HTML::script('ajax/commonFunctions.js')}}


    <script type="text/javascript">


        $(document).ready(function () {

            confirmDeleteItem();

//            $('#date1, #date2, #date3, #date4').datepicker({
//                dateFormat: 'yy-mm-dd',
//                changeMonth: true,
//                changeYear: true
//            });
//
//            $('#dob').datepicker({
//                dateFormat: 'yy-mm-dd',
//                changeMonth: true,
//                changeYear: true,
//                minDate: new Date(1900),
//                maxDate: new Date(),
//                numberOfMonths: 1
//            });
//            $('.payment-date-control').datepicker({
//                dateFormat: 'yy-mm-dd',
//                changeMonth: true,
//                changeYear: true,
//                minDate: new Date(1900),
//                numberOfMonths: 1
//            });

//        $('.my_dob').datepicker({
//            dateFormat: 'yy-mm-dd',
//            changeMonth: true,
//            changeYear: true,
//            minDate: new Date(1900),
//            maxDate: new Date(),
//            numberOfMonths: 1
//        });

//            $('.date-control').datepicker({
//                dateFormat: 'yy-mm-dd',
//                changeMonth: true,
//                changeYear: true
//            });
//
//            $('.time-control').timepicker();
//            $('#time1, #time2').timepicker();
//            $('.update_client').hide();


            var url = 'http://' + window.location.host + '/bookings/get-clients';
            //alert(url);
            sendData(url, null);

            {{--client details--}}

            $('.clients').attr('disabled', true);
            $('.edit_client').click(function () {
                var a = $(this);
                $('.clients').attr('disabled', true);
                $('tr').css('background', 'none');

                var client_id = client_class = $(this).val();
                $('.' + client_class).attr('disabled', false);
                $('.' + client_class).change(function () {
                    alert($('#update_' + client_id).attr('hidden'));
                    if (true) {

                    }
                    $('#update_' + client_id).effect('slide')(200);
                });
                $(this).closest('tr').css('background', '#B9F097').fadeIn(200);
            });
        });

        $('#add_client_btn').click(function () {
            var name = $('#name').val();
            var passport_number = $('#passport_number').val();
            var dob = $('#dob').val();
            var gender = $('#gender').val();

            var formData = new FormData();

            formData.append('name', name.trim());
            formData.append('gender', gender.trim());
            formData.append('dob', dob.trim());
            formData.append('passport_number', passport_number.trim());

//        alert(name+' '+passport_number+' '+dob+' '+gender);
            var url = 'http://' + window.location.host + '/bookings/create-client';

            for (var c = 0; c <= formData.length; c++) {
                alert(formData[c]);
            }
            sendData(url, formData);

        });
    </script>

@stop