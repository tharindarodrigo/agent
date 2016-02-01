{{--
    This page allows you to Update the Hotel Profile
    The page
--}}

@extends('layout.master')

@section('css')
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
    @yield('head-styles')
@endsection

@section('head-scripts')
    @yield('head-scripts')
@endsection

@section('bread-crumbs')
    @yield('bread-crumbs')
@endsection

@section('content')
    @yield('reservations-content')
@endsection

@section('script')
    <!-- Data picker -->
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    @yield('footer-scripts')
@endsection

