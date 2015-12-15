@extends('bookings.bookings')

@section('styles')
    <style type="text/css">
        th {
            text-align: center;
        }
    </style>
@endsection

@section('bread-crumbs')
    <li>/</li>
    <li><a href="#" class="active">Bookings</a></li>
    <li>/</li>
    <li><a href="#">View</a>
        @endsection

        @section('body-content')
                <!-- CONTENT -->
        <div class="container">

            <div class="container mt25 offset-0">
                @if(!empty($booking))

                        <!-- CONTENT -->
                <div class="col-md-12 pagecontainer2 offset-0">

                    <div class="hpadding50c">
                        <div class="lato size30 slim"><h4>Booking<span
                                        class="pull-right">Reference No. {{$booking->reference_number}}</span></h4>
                        </div>
                        <p class="aboutarrow"></p>
                    </div>
                    <div class="line3"></div>

                    <div class="hpadding50c">

                        <div class="col-md-12">
                            <div class="row">
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
                                    {{Form::text('tour',null,array('class'=> 'form-control'))}}
                                    {{$errors->first('tour', '<span class="size12" style="color: red;">:message</span>') }}
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
                        <div class="col-md-12">

                            <br/><br/>

                            <!-- IMG RIGHT TEXT -->

                            <!-- END OF IMG RIGHT TEXT -->

                        </div>
                    </div>


                    <div class="clearfix"></div>
                    <br/><br/>
                </div>
                <!-- END CONTENT -->


            </div>
            <div class="container mt25 offset-0">
                <div class="col-md-12 pagecontainer2 offset-0">
                    <div class="cstyle10"></div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="presentation" class="{{!Session::has('bookings_show_tabs')? 'active': '' }}"><a
                                    href="#client_details" aria-controls="customer_details" role="tab"
                                    data-toggle="tab">Client Details</a></li>
                        <li role="presentation" class=""><a href="#vouchers" aria-controls="clients" role="tab"
                                                            data-toggle="tab">Vouchers</a></li>
                        <li role="presentation"
                            class="{{Session::get('bookings_show_tabs')=='flight-details-tab' ? 'active' : ''}}"><a
                                    href="#flightDetails" aria-controls="flightDetails" role="tab" data-toggle="tab">Flight
                                Details</a></li>
                        <li role="presentation" class=""><a href="#transportation" aria-controls="transportation"
                                                            role="tab" data-toggle="tab">Transportation</a></li>
                        <li role="presentation" class=""><a href="#excursions" aria-controls="transportation"
                                                            role="tab" data-toggle="tab">Excursions</a></li>
                        <li role="presentation" class=""><a href="#invoice" aria-controls="invoice" role="tab"
                                                            data-toggle="tab">Invoice</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content4">
                        <div role="tabpanel" class="tab-pane {{!Session::has('bookings_show_tabs')? 'active': '' }}"
                             id="client_details">
                            <div class="container">
                                @include('bookings.create_partials.client_details')
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane {{--Session::has('') ? 'active' : ''--}}" id="vouchers">
                            <div class="container">
                                @include('bookings.create_partials.vouchers')
                            </div>
                        </div>
                        <div role="tabpanel"
                             class="tab-pane {{Session::get('bookings_show_tabs')=='flight-details-tab' ? 'active' : ''}}"
                             id="flightDetails">
                            <div class="container">
                                @include('bookings.create_partials.flight_details')
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane {{--Session::has('') ? 'active' : ''--}}"
                             id="transportation">
                            @include('bookings.create_partials.transportation')
                        </div>
                        <div role="tabpanel" class="tab-pane {{--Session::has('') ? 'active' : ''--}}" id="excursions">
                            @include('bookings.create_partials.excursions')

                        </div>

                        <div role="tabpanel" class="tab-pane {{--Session::has('') ? 'active' : ''--}}" id="invoice">
                            <div class="container">
                                @include('bookings.create_partials.invoices')
                            </div>
                        </div>

                    </div>

                </div>

                @else

                    <h2>No Bookings Available!</h2>

                @endif
            </div>


        </div>
        <!-- END OF CONTENT -->

        @endsection
                <!-- Javascript  -->





