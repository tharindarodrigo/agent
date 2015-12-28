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

@section('body-content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Editable Table in- combination with jEditable</h5>

                        <div class="ibox-tools">
                            {{--<a class="collapse-link">--}}
                            {{--<i class="fa fa-chevron-up"></i>--}}
                            {{--</a>--}}

                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="row">
                                    {{Form::open(array('url'=>array('bookings/post-bookings')))}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{Form::text('reference_number',null,array('class'=> 'form-control','placeholder'=> 'Reference Number'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        {{Form::submit('Search',array('class'=>'btn btn-block btn-primary', 'name'=>'search_reference_number'))}}
                                    </div>
                                    {{Form::close()}}


                                </div>
                            </div>
                            {{Form::open(array('url'=>array('bookings/post-bookings')))}}
                            <div class="col-lg-6">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::select('tour_type',array('arrival'=>'Arrival','departure'=>'Departure'),null,array('class'=> 'form-control'))}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::select('status',array('any'=>'Any', 'active'=>'Active', 'inactive'=>'Inactive'),null,array('class'=> 'form-control'))}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::text('from',null,array('class'=> 'form-control','placeholder'=> 'From'))}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::text('to',null,array('class'=> 'form-control','placeholder'=> 'To'))}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 vertical-align">
                                <button class="btn btn-block  btn-primary btn-lg" type="submit">
                                    Search
                                </button>
                            </div>
                            {{Form::close()}}
                        </div>


                    </div>


                    @include('bookings.index_partials.all-bookings')


                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
