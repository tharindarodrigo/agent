@extends('accounts.accounts')

@section('styles')
    {{--<style type="text/css">--}}
    {{--th {--}}
    {{--text-align: center;--}}
    {{--}--}}
    {{--</style>--}}
@endsection

@section('active-balance-sheet')
    {{'active'}}
@endsection


@section('bread-crumbs')
    <li>Accounts</li>
    <li><a href="#" class="active">Balance Sheet</a></li>
@endsection

@section('body-content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Balance Sheet</h5>
                        <div class="ibox-tools">
                            {{--<a class="collapse-link">--}}
                            {{--<i class="fa fa-chevron-up"></i>--}}
                            {{--</a>--}}

                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <form action="">

                                <div class="col-lg-12" style="">

                                    {{--<div class="col-md-6">--}}
                                        {{--<span>From :</span>--}}
                                        {{--<div class="form-group">--}}
                                            {{--{{Form::input('date','from',!empty($from) ? $from : date('Y-m-d'),array('class'=> 'form-control','placeholder'=> 'From', 'required'=>'true'))}}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-6">--}}
                                        {{--<span>To :</span>--}}
                                        {{--<div class="form-group">--}}
                                            {{--{{Form::input('date','to',!empty($to) ? $to : date('Y-m-d'),array('class'=> 'form-control','placeholder'=> 'To', 'required'=>'true'))}}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="col-md-3 col-md-offset-3">
                                        <div class="form-group">
                                            {{--Get the user_id instead of --}}
                                            {{Form::select('agent_id', array('%'=>'Select Agent')+Agent::lists('company', 'user_id'),!empty($agent_id) ? $agent_id : null,array('class'=> 'form-control','placeholder'=> 'From', 'required'=>'true'))}}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        {{Form::submit('Search', array('name'=>'search', 'class'=>'btn btn-block btn-primary'))}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="ibox-content">
                        @include('accounts.balance-sheet')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection








