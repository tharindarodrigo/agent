@extends('accounts.accounts')

@section('styles')
    {{--<style type="text/css">--}}
    {{--th {--}}
    {{--text-align: center;--}}
    {{--}--}}
    {{--</style>--}}
@endsection

@section('active-invoices')
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
                        <h5>Invoices List</h5>

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
                            {{Form::open(array('url'=>array('bookings/post-invoices')))}}
                            <div class="col-lg-6">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::text('date',null,array('class'=> 'form-control','placeholder'=> 'From'))}}
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        {{Form::text('name',null,array('class'=> 'form-control','placeholder'=> 'To'))}}
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

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td>Ref. No</td>
                                <td>Date</td>
                                <td>Name</td>
                                <td>Amount</td>
                                <td>Controls</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{$booking->invoice->id}}</td>
                                    <td>{{$booking->reference_number}}</td>
                                    <td align="right">{{number_format($booking->invoice->amount,2)}}</td>
                                    <td>
                                        <a href="{{URL::to('invoice/'.$booking->id)}}" class="btn btn-sm btn-default"><span class="fa fa-eye"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
