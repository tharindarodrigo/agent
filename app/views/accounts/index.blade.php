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
                        @include('accounts.balance-sheet')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection








