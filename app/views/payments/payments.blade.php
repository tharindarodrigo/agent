{{--
    This page allows you to Update the Hotel Profile
    The page
--}}

@extends('layout.master')

@section('head-scripts')
    {{--{{ HTML::style('control-panel-assets/plugins/datepicker/datepicker3.css') }}--}}
@endsection

@section('bread-crumbs')
    @yield('bread-crumbs')
@endsection

{{--Title--}}
@section('control-title')
    {{'Payments'}}
@endsection

{{--Sub Title--}}


{{--Breadcrumbs--}}
@section('bread-crumbs')
    <li class="active">Hotel</li>
    <li class="active">Profile</li>
    <li class="active">Details</li>
@endsection

{{--Active Main Menu Item--}}
@section('active-accounts')
    {{ 'active' }}
@endsection

@section('active-payments')
    {{ 'active' }}
@endsection

{{--Active Sub menu Item--}}
@section('active-payments-index')
    @yield('active-payments-create')
@endsection

@section('active-payments-create')
    @yield('active-payments-create')
@endsection

@section('bread-crumbs')
    @yield('bread-crumbs')
@endsection

@section('content')
    @yield('payment-content')
@endsection



@section('scripts')
    {{ HTML::script('control-panel-assets/plugins/datepicker/bootstrap-datepicker.js')}}
    @yield('scripts')
@endsection

