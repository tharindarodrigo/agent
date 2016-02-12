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
    <li>Accounts</li>
    <li>Invoices</li>
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
                            <div class="row">
                                <div class="col-lg-4">
                                    <form action="">
                                        <span>&nbsp;</span>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{Form::text('reference_number',!empty($reference_number) && $reference_number!='%' ? $reference_number:null, array('class'=> 'form-control','placeholder'=> 'Reference Number'))}}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            {{Form::submit('Search  By Ref. No',array('class'=>'btn btn-block btn-primary', 'name'=>'search_reference_number'))}}
                                        </div>
                                    </form>
                                </div>

                                <form action="">

                                    <div class="col-lg-8" style="">

                                        <div class="col-md-6">
                                            <span>From :</span>
                                            <div class="form-group">
                                                {{Form::input('date','from',!empty($from) ? $from : date('Y-m-d'),array('class'=> 'form-control','placeholder'=> 'From', 'required'=>'true'))}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <span>To :</span>
                                            <div class="form-group">
                                                {{Form::input('date','to',!empty($to) ? $to : date('Y-m-d'),array('class'=> 'form-control','placeholder'=> 'To', 'required'=>'true'))}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{--Get the user_id instead of --}}
                                                {{Form::select('agent_id', array('%'=>'Select Agent')+Agent::lists('company', 'user_id'),!empty($agent_id) ? $agent_id : null,array('class'=> 'form-control','placeholder'=> 'From', 'required'=>'true'))}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::submit('Search', array('name'=>'search', 'class'=>'btn btn-block btn-primary'))}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
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
                                        <td>{{$booking->arrival_date}}</td>
                                        <td>{{$booking->booking_name}}</td>
                                        <td align="right">{{number_format($booking->invoice->first()->amount,2)}}</td>
                                        <td>
                                            <a href="{{URL::to('invoice/'.$booking->id)}}"
                                               class="btn btn-sm btn-default" target="_blank"><span
                                                        class="fa fa-eye"></span></a>
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
    </div>

@endsection
