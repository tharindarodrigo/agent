@extends('bookings.bookings')

@section('styles')
    <style type="text/css">
        th {
            text-align: center;
        }
    </style>
@endsection

@section('bread-crumbs')
    <li><a href="#" class="active">Bookings</a></li>
    <li><a href="#">View</a></li>
@endsection

@section('body-content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Basic form
                            <small>Simple login form example</small>
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        {{Form::model($booking,array('route'=>array('bookings.update',$booking->id), 'method'=>'patch'))}}
                        <div class="col-md-6">

                            <span class="size12">Booking Name *</span>
                            {{Form::text('booking_name',null,array('class'=> 'form-control'))}}
                            {{$errors->first('booking_name', '<span class="size12" style="color: red;">:message</span>') }}
                            <div class="clearfix"></div>

                            <br/>
                            {{----------------------------------------------------------------------------------------------------------------------------------}}

                            @if(Entrust::hasRole('Agent'))
                                <span class="size12">Agent Reference Number *</span>
                                {{Form::text('agent_reference_number',null,array('class'=> 'form-control'))}}
                                {{$errors->first('agent_reference_number', '<span class="size12" style="color: red;">:message</span>') }}
                                <br/>
                            @endif

                            <span class="size12">Remark *</span>
                            {{Form::textarea('remarks', null, array('class'=> 'form-control', 'rows'=>3))}}
                            {{$errors->first('remarks', '<span class="size12" style="color: red;">:message</span>') }}
                            <div class="clearfix"></div>

                            <br/>
                        </div>

                        <div class="col-md-2">&nbsp;</div>
                        <div class="col-md-4">
                            <span class="size12">Arrival Date *</span>
                            {{Form::text('arrival_date',null,array('class'=> 'form-control', 'id'=>'date1'))}}
                            {{$errors->first('arrival_date', '<span class="size12" style="color: red;">:message</span>') }}
                            <div class="clearfix"></div>

                            <br/>

                            <span class="size12">Departure Date *</span>
                            {{Form::text('departure_date', null, array('class'=> 'form-control', 'id'=>'date2'))}}
                            {{$errors->first('departure_date', '<span class="size12" style="color: red;">:message</span>') }}
                            <div class="clearfix"></div>

                            <br/>

                            <div class="row">
                                <div class="col-xs-6">
                                    <span class="size12">adults</span>
                                    {{Form::text('adults',null,array('class'=> 'form-control'))}}
                                    {{$errors->first('adults', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>

                                <div class="col-xs-6">
                                    <span class="size12">children</span>
                                    {{Form::text('children',null,array('class'=> 'form-control'))}}
                                    {{$errors->first('children', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>
                            </div>
                            <br/>

                            <div class="clearfix"></div>
                            <br/>
                        </div>

                        <div class="col-md-12">
                            {{Form::submit('update Booking Info',array('class'=>'btn bluebtn pull-right'))}}
                        </div>


                        {{----------------------------------------------------------------------------------------------------------------------------------}}

                        <div class="clearfix"></div>
                        <br/>

                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="{{!Session::has('bookings_show_tabs')? 'active': '' }}"><a
                                href="#client_details" role="tab"
                                data-toggle="tab">Client Details</a></li>
                    <li class=""><a href="#vouchers"
                                    data-toggle="tab">Vouchers</a></li>
                    <li class="{{Session::get('bookings_show_tabs')=='flight-details-tab' ? 'active' : ''}}"><a
                                href="#flightDetails" data-toggle="tab">Flight
                            Details</a></li>
                    <li class=""><a href="#transportation" data-toggle="tab">Transportation</a></li>
                    {{--<li class=""><a href="#excursions" data-toggle="tab">Excursions</a></li>--}}
                    <li class=""><a href="#invoice" data-toggle="tab">Invoice</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane {{!Session::has('bookings_show_tabs')? 'active': '' }}"
                         id="client_details">
                        <div class="panel-body">
                            @include('bookings.create_partials.client_details')
                        </div>
                    </div>
                    <div class="tab-pane {{--Session::has('') ? 'active' : ''--}}"
                         id="vouchers">
                        <div class="panel-body">

                            @include('bookings.create_partials.vouchers')
                        </div>
                    </div>
                    <div role="tabpanel"
                         class="tab-pane {{Session::get('bookings_show_tabs')=='flight-details-tab' ? 'active' : ''}}"
                         id="flightDetails">
                        <div class="panel-body">

                            @include('bookings.create_partials.flight_details')
                        </div>
                    </div>
                    <div class="tab-pane {{--Session::has('') ? 'active' : ''--}}"
                         id="transportation">
                        <div class="panel-body">

                            @include('bookings.create_partials.transportation')
                        </div>
                    </div>
                    {{--<div class="tab-pane --}}{{--Session::has('') ? 'active' : ''--}}{{--"--}}
                         {{--id="excursions">--}}
                        {{--<div class="panel-body">--}}

                            {{--@include('bookings.create_partials.excursions')--}}

                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="tab-pane {{--Session::has('') ? 'active' : ''--}}" id="invoice">
                        <div class="panel-body">

                            @include('bookings.create_partials.invoices')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--@endsection--}}

{{--@section('scripts')--}}

    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function () {--}}
            {{--$('.delete-button').click(function () {--}}
                {{--alert('asdasd');--}}
            {{--});--}}
        {{--});--}}

    {{--</script>--}}
@stop






