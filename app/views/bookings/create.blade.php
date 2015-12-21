<?php

$total_cost = 0;
$total_cost_transport = 0;
$total_cost_predefine_transport = 0;
$total_cost_excursion = 0;

if (Session::has('predefined_transport')) {
    $predefined_transports = Session::get('predefined_transport');
} else {
    $predefined_transports = '';
}

if (Session::has('excursion_cart_details')) {
    $excursion_cart_details = Session::get('excursion_cart_details');
} else {
    $excursion_cart_details = '';
}

?>

@extends('bookings.bookings')

@section('styles')
    <style type="text/css">
        th {
            text-align: center;
        }

        .table {
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('bread-crumbs')
    <li>/</li>
    <li>{{link_to_route('bookings.index', 'Bookings')}}</li>
    <li>/</li>
    <li>{{link_to_route('bookings.create', 'create')}}</li>
@endsection

@section('body-content')

    <div class="container">

        <div class="container mt25 offset-0">

            <!-- CONTENT -->
            <div class="col-md-8 pagecontainer2 offset-0">
                <div class="padding30 grey">
                    <span class="size16px bold dark left">Client Details </span>

                    <div class="roundstep active right">1</div>
                    <div class="clearfix"></div>
                    <div class="line4"></div>

                    {{Form::open(array('route' => array('bookings.store')))}}

                    <div class="col-md-3 textright">
                        <span class="size12">&nbsp;</span>

                        <div class="margtop15"><span class="dark">Booking Name:</span><span class="red">*</span></div>
                    </div>
                    <div class="col-md-6">
                        <span class="size12">First and Last Name*</span>
                        {{Form::text('booking_name',null,array('class'=> 'form-control'))}}
                        {{$errors->first('booking_name', '<span class="size12" style="color: red;">:message</span>') }}
                    </div>
                    <div class="col-md-3 textleft margtop15">
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3 textright">
                        <span class="size12">&nbsp;</span>

                        <div class="margtop15"><span class="dark">Ref. No:</span><span class="red">*</span></div>
                    </div>
                    <div class="col-md-6">
                        <span class="size12">Add a reference number for your own convenience</span>
                        {{Form::text('agent_reference_number',null,array('class'=> 'form-control'))}}
                        {{$errors->first('agent_reference_number', '<span class="size12" style="color: red;">:message</span>') }}
                    </div>

                    <div class="col-md-3 textleft margtop15">
                    </div>
                    <div class="clearfix"></div>

                    <br/>
                    {{----------------------------------------------------------------------------------------------------------------------------------}}


                    <div class="col-md-3 textright">
                        <div class="margtop15"><span class="dark">Arrival Date:</span><span class="red">*</span></div>
                    </div>
                    <div class="col-md-6">
                        {{Form::text('arrival_date',null,array('class'=> 'form-control', 'id'=>'date1'))}}
                        {{$errors->first('arrival_date', '<span class="size12" style="color: red;">:message</span>') }}
                    </div>

                    <div class="col-md-3 textleft margtop15">
                    </div>
                    <div class="clearfix"></div>

                    <br/>
                    {{----------------------------------------------------------------------------------------------------------------------------------}}


                    <div class="col-md-3 textright">
                        <div class="margtop15"><span class="dark">Departure Date:</span><span class="red">*</span></div>
                    </div>
                    <div class="col-md-6">
                        {{Form::text('departure_date', null, array('class'=> 'form-control', 'id'=>'date2'))}}
                        {{$errors->first('departure_date', '<span class="size12" style="color: red;">:message</span>') }}
                    </div>

                    <div class="col-md-3 textleft margtop15">
                    </div>
                    <div class="clearfix"></div>
                    <br/>

                    {{----------------------------------------------------------------------------------------------------------------------------------}}

                    @if(!Auth::check())
                        <div class="col-md-3 textright">
                            <div class="margtop15"><span class="dark">Email:</span><span class="red">*</span></div>
                        </div>
                        <div class="col-md-6">
                            {{Form::text('email', null, array('class'=> 'form-control'))}}
                            {{$errors->first('email', '<span class="size12" style="color: red;">:message</span>') }}
                        </div>

                        <div class="col-md-3 textleft margtop15">
                        </div>
                        <div class="clearfix"></div>
                        <br/>

                        {{----------------------------------------------------------------------------------------------------------------------------------}}


                        <div class="col-md-3 textright">
                            <div class="margtop15"><span class="dark">Phone:</span><span class="red">*</span></div>
                        </div>
                        <div class="col-md-6">
                            {{Form::text('phone', null, array('class'=> 'form-control'))}}
                            {{$errors->first('phone', '<span class="size12" style="color: red;">:message</span>') }}
                        </div>

                        <div class="col-md-3 textleft margtop15">
                        </div>
                        <div class="clearfix"></div>
                        <br/>

                        {{----------------------------------------------------------------------------------------------------------------------------------}}

                        <div class="col-md-3 textright">
                            <div class="margtop15"><span class="dark">Passport Number:</span><span class="red">*</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{Form::text('passport_number', null, array('class'=> 'form-control'))}}
                            {{$errors->first('passport_number', '<span class="size12" style="color: red;">:message</span>') }}
                        </div>

                        <div class="col-md-3 textleft margtop15">
                        </div>
                        <div class="clearfix"></div>
                        <br/>

                        {{----------------------------------------------------------------------------------------------------------------------------------}}

                    @endif


                    {{----------------------------------------------------------------------------------------------------------------------------------}}


                    @if(Entrust::hasRole('Agent'))


                        <div class="col-md-3 textright">
                            <span class="size12">&nbsp;</span>

                            <div class="margtop15"><span class="dark">Pax:</span><span class="red">*</span></div>
                        </div>
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-3 textleft margtop15">

                        </div>
                        <div class="clearfix"></div>
                        <br/>
                        {{--Client Information--}}
                        <span class="size16px bold dark left">Client Information </span>
                        <div class="roundstep active right">2</div>
                        <div class="clearfix"></div>
                        <div class="line4"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>DoB</th>
                                    <th>Passport No</th>
                                    <th>Gender</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody id="clients_table">

                                </tbody>
                            </table>
                        </div>
                        <br/><br/>

                        <div>
                            <div class="col-md-3">
                                <span class="size12" style="text-align: center">Name</span>
                                {{Form::text('client_name',null,array('class'=> 'form-control', 'id'=>'name'))}}
                            </div>
                            <div class="col-md-3">
                                <span class="size12">Date of Birth</span>
                                {{Form::text('dob',null,array('class'=> 'form-control', 'id'=> 'dob'))}}
                            </div>
                            <div class="col-md-3">
                                <span class="size12">Passport No.</span>
                                {{Form::text('passport_number',null,array('class'=> 'form-control', 'id'=>'passport_number'))}}
                            </div>
                            <div class="col-md-3">
                                <span class="size12">Gender</span>
                                {{Form::select('gender',array('male' => 'Male', 'female'=>'Female'),null,array('class'=> 'form-control', 'id'=>'gender'))}}
                            </div>
                        </div>
                        <div class="pull-right">
                            <button class="bluebtn margtop20" type="button" id="add_client_btn">Add Client</button>
                        </div>
                        <div class="clearfix"></div>
                        <br/><br/>

                        {{----------------------------------------------------------------------------------------------------------------------------------}}

                        <span class="size16px bold dark left">Flight Details </span>
                        <div class="roundstep active right">3</div>
                        <div class="clearfix"></div>
                        <div class="line4"></div>

                        <div class="col-md-3 textright">
                            <span>&nbsp;</span>

                            <div class="margtop15"><span class="dark">Flight:</span><span class="red"></span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-xs-6">
                                    <span>Arrival</span>
                                    {{Form::text('arrival_flight',null,array('class'=> 'form-control'))}}
                                    {{$errors->first('arrival_flight', '<span class="size12" style="color: red;">:message</span>') }}
                                </div>

                                <div class="col-xs-6">
                                    <span>Departure</span>
                                    {{Form::text('departure_flight',null,array('class'=> 'form-control'))}}
                                    {{$errors->first('departure_flight', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 textleft margtop15">

                        </div>

                        <div class="clearfix"></div>
                        <br/>
                        {{----------------------------------------------------------------------------------------------------------------------------------}}


                        <div class="col-md-3 textright">
                            <div class="margtop15"><span class="dark">Date:</span><span class="red"></span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-xs-6">
                                    {{Form::text('date_arrival',null,array('class'=> 'form-control date-control'))}}
                                    {{$errors->first('date_arrival', '<span class="size12" style="color: red;">:message</span>') }}
                                </div>
                                <div class="col-xs-6">
                                    {{Form::text('date_departure',null,array('class'=> 'form-control date-control'))}}
                                    {{$errors->first('date_departure', '<span class="size12" style="color: red;">:message</span>') }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 textleft margtop15">
                        </div>

                        <div class="clearfix"></div>
                        <br/>
                        {{----------------------------------------------------------------------------------------------------------------------------------}}


                        <div class="col-md-3 textright">
                            <div class="margtop15"><span class="dark">Time:</span><span class="red"></span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-xs-6">
                                    {{Form::text('arrival_time',null,array('class'=> 'form-control time-control'))}}
                                    {{$errors->first('arrival_time', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>
                                <div class="col-xs-6">
                                    {{Form::text('departure_time',null,array('class'=> 'form-control time-control'))}}
                                    {{$errors->first('arrival_time', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>

                            </div>
                        </div>

                        <div class="col-md-3 textleft margtop15">

                        </div>
                        <div class="clearfix"></div>

                        <br/>
                        <br/>
                        {{----------------------------------------------------------------------------------------------------------------------------------}}

                        <span class="size16px bold dark left">Remarks</span>

                        <div class="roundstep active right">4</div>
                        <div class="clearfix"></div>
                        <div class="line4"></div>

                        <div class="col-md-3 textright">
                            <div class="margtop15"><span class="dark">Remarks:</span><span class="red"></span></div>
                        </div>
                        <div class="col-md-6">
                            {{Form::textarea('remarks',null,array('class'=> 'form-control'))}}
                        </div>
                        <div class="col-md-3 textleft margtop15">
                        </div>
                        <div class="clearfix"></div>

                        <br/>
                    @endif

                    <div class="col-md-12 ">
                        <div class="pull-right">
                            <button class="bluebtn" type="submit">Add Booking</button>
                        </div>
                    </div>


                    <!-- IMG RIGHT TEXT -->

                    <!-- END OF IMG RIGHT TEXT -->
                    {{Form::close()}}

                </div>


                <div class="clearfix"></div>


                <br/><br/>
            </div>
            <!-- END CONTENT -->

            <div class="col-md-4">

                <div class="pagecontainer2 paymentbox grey">
                    <div class="padding30">
                        <span class="opensans size18 dark bold">Exotic Holidays International (Pvt ) Limited </span><br/>
                        <span class="opensans size13 grey">No 07, Barnes Avenue, Mount Lavinia, Sri Lanka.</span><br/>
                    </div>
                    <div class="line3"></div>

                    <div class="hpadding30 margtop30">

                        @if(Session::has('rate_box_details'))
                            <table class="table table-bordered ">
                                <tr>
                                    <td>
                                        <h5 style="font-weight: 600" class="dark">Hotel Bookings</h5>

                                        <!-- Collapse 1 -->
                                        <button type="button" class="collapsebtn3 collapsed mt-5" data-toggle="collapse"
                                                data-target="#collapse1">

                                        </button>

                                        <div id="collapse1" class="collapse">
                                            <?php
                                            $x = 0;

                                            if (Session::has('market')) {
                                                $market = Session::get('market');
                                            } else {
                                                $market = 1;
                                            }
                                            ?>

                                            @foreach($hotel_bookings as $hotel_booking)
                                                <div class="size12 lblue">
                                                    {{ $hotel_booking['hotel_name']  }}
                                                    <br/>
                                                    @for($x=0 ; $x < count($hotel_booking)-3; $x++)
                                                        {{ $hotel_booking[$x]['room_specification'] }} room <br/>
                                                        @if($market == 1)
                                                            <span class="green"> {{ Session::get('currency'). '&nbsp;'  . number_format(($hotel_booking[$x]['room_cost'] + ($hotel_booking[$x]['hotel_tax'] + $hotel_booking[$x]['hotel_handling_fee'])), 2, '.', '') }} </span>
                                                            <?php $total_cost = $total_cost + $hotel_booking[$x]['room_cost'] + ($hotel_booking[$x]['hotel_tax'] + $hotel_booking[$x]['hotel_handling_fee'] + $hotel_booking[$x]['supplement_rate']); ?>
                                                        @else
                                                            <span class="green">{{ Session::get('currency'). '&nbsp;'  . number_format(($hotel_booking[$x]['room_cost'] ), 2, '.', '') }} </span>
                                                            <?php $total_cost = $total_cost + $hotel_booking[$x]['room_cost'] ?>
                                                        @endif
                                                    @endfor
                                                </div>

                                                <div class="size12 lblue">

                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="line3"></div>
                                            @endforeach
                                        </div>

                                    </td>
                                    <td class="center green">
                                        Total Cost <br/>
                                        {{ Session::get('currency') }} <br/>
                                        {{ number_format(($total_cost * Session::get('currency_rate')), 2, '.', '') }}
                                        <br/>
                                    </td>
                                </tr>
                            </table>
                        @endif

                        @if(Session::has('transport_cart_box'))
                            <table class="table table-bordered ">
                                <tr>
                                    <td>
                                        <h5 style="font-weight: 600" class="dark">Transport Bookings</h5>

                                        <!-- Collapse 1 -->
                                        <button type="button" class="collapsebtn3 collapsed mt-5" data-toggle="collapse"
                                                data-target="#collapse2">

                                        </button>

                                        <div id="collapse2" class="collapse">

                                            @foreach($transport_bookings as $transport_booking)
                                                <div class="size12 lblue">

                                                    Vehicle - {{ $transport_booking['vehicle_type']  }}
                                                    <br/>

                                                    From - {{ $transport_booking['origin'] }} <br/>
                                                    To - {{ $transport_booking['destination_1'] }} <br/>

                                                </div>

                                                <span class="green">{{ Session::get('currency'). '&nbsp;'  . number_format(($transport_booking['cost'] ), 2, '.', '') }} </span>
                                                <?php $total_cost_transport = $total_cost_transport + $transport_booking['cost']; ?>
                                                <div class="clearfix"></div>
                                                <div class="line3"></div>
                                            @endforeach
                                        </div>

                                    </td>
                                    <td class="center green">
                                        Total Cost <br/>
                                        {{ Session::get('currency') }} <br/>
                                        {{ number_format(($total_cost_transport * Session::get('currency_rate')), 2, '.', '') }}

                                        <br/>
                                    </td>
                                </tr>
                            </table>
                        @endif

                        @if(Session::has('predefined_transport'))
                            <table class="table table-bordered ">
                                <tr>
                                    <td>
                                        <h5 style="font-weight: 600" class="dark">Predefined Transport Bookings</h5>

                                        <!-- Collapse 1 -->
                                        <button type="button" class="collapsebtn3 collapsed mt-5" data-toggle="collapse"
                                                data-target="#collapse3">

                                        </button>

                                        <div id="collapse3" class="collapse">

                                            @foreach($predefined_transports as $predefined_transport)
                                                <div class="size12 lblue">

                                                    Vehicle
                                                    - {{ Vehicle::where('id', TransportPackage::where('id', $predefined_transport['predefine_id'])->first()->vehicle_id)->first()->vehicle_type }}
                                                    <br/>

                                                    From
                                                    - {{ City::where('id' , TransportPackage::where('id', $predefined_transport['predefine_id'])->first()->origin)->first()->city; }}
                                                    <br/>
                                                    To
                                                    - {{ City::where('id' , TransportPackage::where('id', $predefined_transport['predefine_id'])->first()->destination)->first()->city; }}
                                                    <br/>

                                                </div>

                                                <span class="green">{{ Session::get('currency'). '&nbsp;'  . number_format((TransportPackage::where('id', $predefined_transport['predefine_id'])->first()->rate), 2, '.', '') }} </span>
                                                <?php $total_cost_predefine_transport = $total_cost_predefine_transport + TransportPackage::where('id', $predefined_transport['predefine_id'])->first()->rate; ?>
                                                <div class="clearfix"></div>
                                                <div class="line3"></div>

                                            @endforeach
                                        </div>

                                    </td>
                                    <td class="center green">
                                        Total Cost <br/>
                                        {{ Session::get('currency') }} <br/>
                                        {{ number_format(($total_cost_predefine_transport * Session::get('currency_rate')), 2, '.', '') }}

                                        <br/>
                                    </td>
                                </tr>
                            </table>
                        @endif

                        @if(Session::has('excursion_cart_details'))
                            <table class="table table-bordered ">
                                <tr>
                                    <td>
                                        <h5 style="font-weight: 600" class="dark">Excursion Bookings</h5>

                                        <!-- Collapse 1 -->
                                        <button type="button" class="collapsebtn3 collapsed mt-5" data-toggle="collapse"
                                                data-target="#collapse4">

                                        </button>

                                        <div id="collapse4" class="collapse">
                                            @foreach($excursion_cart_details as $excursion_cart_detail)
                                                <div class="size12 lblue">

                                                    {{ Excursion::where('id', $excursion_cart_detail['excursion'])->first()->excursion }}
                                                    <br/>

                                                    From -
                                                    {{ $excursion_cart_detail['excursion_city'] }}
                                                    <br/>
                                                    Date -
                                                    {{ $excursion_cart_detail['excursion_date'] }}
                                                    <br/>

                                                </div>

                                                <span class="green">{{ Session::get('currency'). '&nbsp;'  . number_format((substr($excursion_cart_detail['excursion_total'], 9)), 2, '.', '') }} </span>
                                                <?php $total_cost_excursion = $total_cost_excursion + substr($excursion_cart_detail['excursion_total'], 9) ?>
                                                <div class="clearfix"></div>
                                                <div class="line3"></div>
                                            @endforeach
                                        </div>

                                    </td>
                                    <td class="center green">
                                        Total Cost <br/>
                                        {{ Session::get('currency') }} <br/>
                                        {{ number_format(($total_cost_excursion * Session::get('currency_rate')), 2, '.', '') }}
                                        <br/>
                                    </td>
                                </tr>
                            </table>
                        @endif

                    </div>

                    <div class="line3"></div>
                    <div class="padding30">
                        <span class="lred2 bold size20"> Total Amount </span>

                        <span class="right lred2 bold size20"> :
                            {{ Session::get('currency') }}
                            {{ number_format(($total_cost + $total_cost_transport + $total_cost_predefine_transport + $total_cost_excursion * Session::get('currency_rate')), 2, '.', '') }}
                        </span>

                        <div class="clearfix"></div>
                    </div>

                </div>
                <br/>

                <div class="pagecontainer2 needassistancebox">
                    <div class="cpadding1">
                        <span class="icon-help"></span>

                        <h3 class="opensans">Need Assistance?</h3>

                        <p class="size14 grey">Our team is 24/7 at your service to help you with your booking issues or
                            answer any related questions</p>

                        <p class="opensans size30 lblue xslim">+ 94 (0) 11 5235872</p>
                    </div>
                </div>
                <br/>

            </div>
        </div>


    </div>

@endsection






