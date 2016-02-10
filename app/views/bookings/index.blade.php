@extends('bookings.bookings')

@section('styles')
    {{--<style type="text/css">--}}
    {{--th {--}}
    {{--text-align: center;--}}
    {{--}--}}
    {{--</style>--}}
@endsection

@section('active-bookings')
    {{'active'}}
@endsection

@section('active-bookings-my-bookings')
    {{'active'}}
@endsection

@section('bread-crumbs')
    {{--<li>/</li>--}}
    {{--<li><a href="#" class="active">Bookings</a></li>--}}
@endsection

@section('bread-crumbs')
    <li>Hello</li>
@endsection

@section('body-content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Bookings</h5>

                        <div class="ibox-tools">
                            {{--<a class="collapse-link">--}}
                            {{--<i class="fa fa-chevron-up"></i>--}}
                            {{--</a>--}}
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            @if(Entrust::hasRole('Admin'))
                            <div class="col-lg-3">
                                <div class="row">
                                    <form action="">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{Form::text('reference_number',!empty($reference_number) ? $reference_number : null ,array('class'=> 'form-control','placeholder'=> 'Reference Number', 'required'=>'true' ))}}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            {{Form::submit('Search by Ref. No.',array('class'=>'btn btn-block btn-primary', 'name'=>'search_reference_number'))}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                            <form action="">
                                <div class="col-lg-6">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::select('tour_type',array('0'=>'Arrival','1'=>'Departure'), !empty($tour_type) ? $tour_type: null ,array('class'=> 'form-control'))}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::select('status',array('0'=>'All', '1'=>'Active', '2'=>'Inactive'), !empty($status) ? $status: null ,array('class'=> 'form-control'))}}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::input('date','from',!empty($from) ? $from : date('Y-m-d'),array('class'=> 'form-control','placeholder'=> 'From', 'required'=>'true'))}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::input('date','to',!empty($to) ? $to : date('Y-m-d'), array('class'=> 'form-control','placeholder'=> 'To', 'required'=>'true'))}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 vertical-align">
                                    @if(Entrust::hasRole('Admin'))
                                    <div class="form-group">
                                        {{Form::select('agent_id',array('%'=>'Select Agent')+Agent::lists('company', 'id'),null,array('class'=> 'form-control'))}}
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        {{Form::submit('Search', array('name'=>'search', 'class'=>'btn btn-block btn-primary'))}}
                                    </div>
                                </div>
                            </form>
                        </div>
                        @include('bookings.index_partials.all-bookings')
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
