@extends('payments.payments')

@section('active-payments-create')
    {{'active'}}
@endsection

@section('payment-content')
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"> Create Payments</h3>
            </div>
            <div class="box-body">
                {{Form::open(array('route'=>array('payments.store')))}}
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
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#payments_table').dataTable();

            $('#date').datepicker({
                format : 'yyyy-mm-dd'
            });
        });
    </script>
@endsection