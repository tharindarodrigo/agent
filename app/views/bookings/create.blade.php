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

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        Client Details
                    </div>
                    <div class="ibox-content">
                        {{Form::open()}}
                        <div class="form-group">
                            <label for="">Booking Name * <span style="font-style: italic; font-weight: lighter;"> (First & Last Name)</span></label>
                            {{Form::text('booking_name',null,array('class'=> 'form-control'))}}
                            {{$errors->first('booking_name', '<span class="size12" style="color: red;">:message</span>') }}
                        </div>

                        <div class="form-group">
                            <label for="">Reference Number <span style="font-style: italic; font-weight: lighter;"> (Add this for your own reference)</span></label>
                            {{Form::text('agent_reference_number',null,array('class'=> 'form-control'))}}
                            {{$errors->first('agent_reference_number', '<span class="size12" style="color: red;">:message</span>') }}
                        </div>
                        <div class="form-group">
                            <label for="">Arrival Date</label>
                            {{Form::text('arrival_date',null,array('class'=> 'form-control', 'id'=>'date1'))}}
                            {{$errors->first('arrival_date', '<span class="size12" style="color: red;">:message</span>') }}
                        </div>
                        <div class="form-group">
                            <label for="">Departure Date</label>
                            {{Form::text('departure_date', null, array('class'=> 'form-control', 'id'=>'date2'))}}
                            {{$errors->first('departure_date', '<span class="size12" style="color: red;">:message</span>') }}
                        </div>
                        <div class="form-group">
                            <label for="">Pax</label>

                            <div class="row">
                                <div class="col-xs-6">
                                    {{Form::text('adults', null, array('class'=> 'form-control', 'id'=>'date2', 'placeholder'=>'Adults'))}}
                                    {{$errors->first('departure_date', '<span class="size12" style="color: red;">:message</span>') }}
                                </div>
                                <div class="col-xs-6">
                                    {{Form::text('children', null, array('class'=> 'form-control', 'id'=>'date2', 'placeholder'=>'Children'))}}
                                    {{$errors->first('departure_date', '<span class="size12" style="color: red;">:message</span>') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
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
                                <tr>
                                    <td align="center" colspan="5">No Clients Added</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-3">
                                    {{--<span class="size12" style="text-align: center">Name</span>--}}
                                    {{Form::text('client_name',null,array('class'=> 'form-control client_form', 'id'=>'name'))}}
                                </div>
                                <div class="col-md-4">
                                    {{--<span class="size12">Date of Birth</span>--}}
                                    {{Form::input('date', 'dob',null,array('class'=> 'form-control client_form', 'id'=> 'dob'))}}
                                </div>
                                <div class="col-md-3">
                                    {{--<span class="size12">Passport No.</span>--}}
                                    {{Form::text('passport_number',null,array('class'=> 'form-control client_form', 'id'=>'passport_number'))}}
                                </div>
                                <div class="col-md-2">
                                    {{--<span class="size12">Gender</span>--}}
                                    {{Form::select('gender',array('male' => 'Male', 'female'=>'Female'),null,array('class'=> 'form-control client_form', 'id'=>'gender'))}}
                                </div>

                            </div>
                        </div>
                        <div class="form-group" align="right">
                            <div class="col-md"></div>
                            <button class="btn btn-primary btn-outline" type="button" id="add_client_btn">Add Client
                            </button>
                        </div>
                        {{Form::close()}}
                    </div>
                    <div class="ibox-title">
                        Flight Details
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td align="center">Arrival</td>
                                    <td align="center">Departure</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>Flight</th>
                                    <td>{{Form::text('arrival_flight',null,array('class'=> 'form-control'))}}
                                        {{$errors->first('arrival_flight', '<span class="size12" style="color: red;">:message</span>') }}</td>
                                    <td>{{Form::text('departure_flight',null,array('class'=> 'form-control'))}}
                                        {{$errors->first('departure_flight', '<span class="size12" style="color: red;">:message</span>') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{Form::input('date','date_arrival',null,array('class'=> 'form-control date-control'))}}
                                        {{$errors->first('date_arrival', '<span class="size12" style="color: red;">:message</span>') }}</td>
                                    <td>{{Form::input('date','date_departure',null,array('class'=> 'form-control date-control'))}}
                                        {{$errors->first('date_departure', '<span class="size12" style="color: red;">:message</span>') }}</td>
                                </tr>
                                <tr>
                                    <th>Time</th>
                                    <td>{{Form::input('time','arrival_time',null,array('class'=> 'form-control time-control'))}}
                                        {{$errors->first('arrival_time', '<span class="size12" style="color: red;">:message</span>') }}
                                    </td>
                                    <td>{{Form::input('time','departure_time',null,array('class'=> 'form-control time-control'))}}
                                        {{$errors->first('arrival_time', '<span class="size12" style="color: red;">:message</span>') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            {{Form::textarea('remarks', null, array('class'=>'form-control', 'rows'=>'3'))}}
                        </div>

                    </div>
                    <div class="ibox-footer">
                        <div align="right">
                            {{Form::submit('Create Booking',array('class'=>'btn btn-primary'))}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection






