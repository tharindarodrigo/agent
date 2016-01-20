@extends('inquiries.rate-inquiries.rate-inquiries')
@section('bread-crumbs')
    <li>Inquires</li>
    <li>My Inquiries</li>
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Make an Inquiry</h5>
                    </div>
                    <div class="ibox-content">
                        {{Form::open(array('url'=>array('inquiries/rate-inquiries/store')))}}
                        <div class="form-group">
                            <label for="hotel_id">Hotel</label>
                            {{Form::select('hotel_id',Hotel::lists('name','id'),null,array('class'=>'form-control hotel_selector', 'id'=>'hotel_id'))}}
                        </div>
                        <div class="form-group">
                            <label for="room_type_id">Room Type</label>
                            <select name="room_type_id" id="room_id" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="room_specification_id">Room Specification</label>
                            {{Form::select('room_specification_id',RoomSpecification::lists('room_specification','id'),null,array('class'=>'form-control hotel_selector', 'multiple'=>'true'))}}
                        </div>
                        <div class="form-group">
                            <label for="meal_basis_id">Meal Basis</label>
                            {{Form::select('room_specification_id',MealBasis::lists('meal_basis','id'),null,array('class'=>'form-control hotel_selector', 'multiple'=>'true'))}}
                        </div>

                        <div class="form-group">
                            <label for="room_type_id">No. of Rooms</label>
                            {{Form::text('room_count',null,array('class'=>'form-control'))}}
                        </div>
                        <div class="form-group" id="data_5">
                            <label class="">Period</label>

                            <div class="input-daterange input-group inquiry_period" id="inquiry_period">
                                <input type="text" class="input-sm form-control" name="start"
                                       value="{{date('Y-m-d')}}"/>
                                <span class="input-group-addon">to</span>
                                <input type="text" class="input-sm form-control" name="end" value="{{date('Y-m-d')}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            {{Form::textarea('remarks',null,array('class'=>'form-control', 'rows'=>'3'))}}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Send Inquiry</button>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection