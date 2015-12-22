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
                        <h5>Editable Table in- combination with jEditable</h5>

                        <div class="ibox-tools">
                            {{--<a class="collapse-link">--}}
                            {{--<i class="fa fa-chevron-up"></i>--}}
                            {{--</a>--}}

                        </div>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td>Ref. No</td>
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
                                        <a href="" class="btn btn-sm btn-warning"><span class="fa fa-eye"></span></a>
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
