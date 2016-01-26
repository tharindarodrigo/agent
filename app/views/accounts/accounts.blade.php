@extends('layout.master')

@section('title')

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> srilankahotel.travel - About Us</title>

@endsection

@section('active-accounts')
    {{'active'}}
@endsection

@endsection

@section('active-invoices')
    @yield('active-invoices')
@endsection

@section('active-payments')
    @yield('active-payments')
@endsection

@section('active-payments-view-payments')
    @yield('active-payments-view-payments')
@endsection


@section('active-payments-create-payments')
    @yield('active-payments-create-payments')
@endsection

@section('style')
    {{HTML::style('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css')}}

    @yield('styles')

    {{--<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">--}}
    {{HTML::style('assets/css/jquery-ui.css')}}
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    @endsection

    @section('content')

    @yield('body-content')

    {{--{{ HTML::script('js/js-about.js') }}--}}

            <!-- Easy Pie Chart  -->
    {{--{{ HTML::script('js/jquery.easy-pie-chart.js') }}--}}
    {{ HTML::script('js/functions/add_clients.js') }}

@endsection

@section('script')

    {{HTML::script('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js')}}
    {{HTML::script('control-panel-assets/ajax/commonFunctions.js')}}


    <script type="text/javascript">


        {{--$(document).ready(function () {--}}

            {{--confirmDeleteItem();--}}

            {{--$('#date1, #date2, #date3, #date4').datepicker({--}}
                {{--dateFormat: 'yy-mm-dd',--}}
                {{--changeMonth: true,--}}
                {{--changeYear: true--}}
            {{--});--}}

            {{--$('#dob').datepicker({--}}
                {{--dateFormat: 'yy-mm-dd',--}}
                {{--changeMonth: true,--}}
                {{--changeYear: true,--}}
                {{--minDate: new Date(1900),--}}
                {{--maxDate: new Date(),--}}
                {{--numberOfMonths: 1--}}
            {{--});--}}
            {{--$('.payment-date-control').datepicker({--}}
                {{--dateFormat: 'yy-mm-dd',--}}
                {{--changeMonth: true,--}}
                {{--changeYear: true,--}}
                {{--minDate: new Date(1900),--}}
                {{--numberOfMonths: 1--}}
            {{--});--}}

{{--//        $('.my_dob').datepicker({--}}
{{--//            dateFormat: 'yy-mm-dd',--}}
{{--//            changeMonth: true,--}}
{{--//            changeYear: true,--}}
{{--//            minDate: new Date(1900),--}}
{{--//            maxDate: new Date(),--}}
{{--//            numberOfMonths: 1--}}
{{--//        });--}}

            {{--$('.date-control').datepicker({--}}
                {{--dateFormat: 'yy-mm-dd',--}}
                {{--changeMonth: true,--}}
                {{--changeYear: true--}}
            {{--});--}}

            {{--$('.time-control').timepicker();--}}
            {{--$('#time1, #time2').timepicker();--}}
            {{--$('.update_client').hide();--}}


            {{--var url = 'http://' + window.location.host + '/bookings/get-clients';--}}
            {{--//alert(url);--}}
            {{--sendData(url, null);--}}

            {{--client details--}}

            {{--$('.clients').attr('disabled', true);--}}
            {{--$('.edit_client').click(function () {--}}
                {{--var a = $(this);--}}
                {{--$('.clients').attr('disabled', true);--}}
                {{--$('tr').css('background', 'none');--}}

                {{--var client_id = client_class = $(this).val();--}}
                {{--$('.' + client_class).attr('disabled', false);--}}
                {{--$('.' + client_class).change(function () {--}}
                    {{--alert($('#update_' + client_id).attr('hidden'));--}}
                    {{--if (true) {--}}

                    {{--}--}}
                    {{--$('#update_' + client_id).effect('slide')(200);--}}
                {{--});--}}
                {{--$(this).closest('tr').css('background', '#B9F097').fadeIn(200);--}}
            {{--});--}}
        {{--});--}}

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

            sendData(url, formData);

        });
    </script>

@stop