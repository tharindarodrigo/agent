@extends('payments.payments')

@section('active-payments')
    {{'active'}}
@endsection

@section('active-payments-create-payments')
    {{'active'}}
@endsection

@section('payment-content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Horizontal form</h5>

                    </div>
                    <div class="ibox-content">
                        {{Form::open(array('route'=>array('accounts.payments.store')))}}
                        <div class="form-group">
                            <label for="amount">Agent</label>
                            {{Form::select('agent_id', [''=> 'Select agent']+Agent::orderBy('company')->lists('company','id'), null, array('class'=> 'form-control'))}}
                            <p>{{$errors->first('agent_id', '<span class="size12" style="color: red;">:message</span>') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            {{Form::text('amount', null, array('class'=> 'form-control'))}}
                            <p>{{$errors->first('amount', '<span class="size12" style="color: red;">:message</span>') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="payment_date_time">Date Time</label>
                            {{Form::text('payment_date_time', null, array('class'=> 'form-control', 'id'=>'date', 'autocomplete' => 'off'))}}
                            <p>{{$errors->first('payment_date_time', '<span class="size12" style="color: red;">:message</span>') }}</p>

                        </div>
                        <div class="form-group">
                            <label for="">Details</label>
                            {{Form::textarea('details', null, array('class'=> 'form-control', 'rows'=>'3'))}}
                            <p>{{$errors->first('details', '<span class="size12" style="color: red;">:message</span>') }}</p>

                        </div>
                        <div class="form-group">
                            {{Form::submit('Add Payment', array('class'=>'btn btn-primary'))}}
                        </div>

                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
