@extends('layout.master')

@section('title')

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> srilankahotel.travel - About Us</title>

@endsection

@section('style')

    @yield('styles')

    {{HTML::style('assets/css/jquery-ui.css')}}

@endsection

@section('')

@endsection

@section('content')

    @yield('body-content')

@endsection

@section('script')
    {{HTML::script('ajax/commonFunctions.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('.delete-button').click(function () {
                confirm();
            });
        });
    </script>

@stop