@extends('payments.payments')

@section('active-payments')
    {{'active'}}
@endsection

@section('active-payments-view-payments')
    {{'active'}}
@endsection

@section('bread-crumbs')
    <li>Payments</li>
@endsection

@section('payment-content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Payments</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="">
                            @if(Entrust::hasRole('Admin'))
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        {{Form::select('agent_id', array('%'=>'Select Agent')+Agent::lists('company', 'id'), $agent_id, array('class'=> 'form-control'))}}
                                    </div>
                                </div>
                            @endif

                            <div class="col-lg-3">
                                <div class="form-group">
                                    {{Form::input('date', 'from_date', !empty($from) ? $from : date('Y-m-d'), array('class'=> 'form-control', 'type'=> 'date', 'required'=>'true'))}}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    {{Form::input('date', 'to_date', !empty($to) ? $to : date('Y-m-d'), array('class'=> 'form-control', 'type'=> 'date', 'required'=>'true'))}}
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    {{--<button class="btn btn-primary" name="search" type="submit"></button>--}}
                                    {{Form::submit('Search', array('name'=>'search', 'class'=> 'btn btn-primary'))}}
                                </div>
                            </div>


                        </form>
                        @include('payments._index-partials.payments-table')

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">


        $(document).ready(function () {

            confirmDeleteItem();
            $('#payments_table').dataTable(
                    confirmDeleteItem()
            );
        });
    </script>
@endsection