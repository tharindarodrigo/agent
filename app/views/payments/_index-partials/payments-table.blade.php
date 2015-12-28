<table class="table table-bordered table-striped" id="payments_table">
    <thead>
    <tr>
        <th>#</th>
        <th>Ref. No.</th>
        <th>Agent</th>
        <th>Date Time</th>
        <th>Amount</th>
        <th>Controls</th>
    </tr>
    </thead>
    @if(!empty($payments))
        <tbody>
        @foreach($payments as $payment)
            <tr>

                <td>{{$payment->id}}</td>
                <td>{{$payment->reference_number}}</td>
                <td>{{$payment->agent->company or 'individual'}}</td>
                <td align="center">{{date('Y-m-d',strtotime($payment->payment_date_time))}}</td>
                <td align="right">{{number_format($payment->amount,2)}}</td>
                <td>
                    {{Form::open(array('route' => array('accounts.payments.destroy', $payment->id), 'method'=>'delete'))}}
                    {{link_to_route('accounts.payments.edit','', [$payment->id], ['class' => 'btn btn-sm btn-primary glyphicon glyphicon-edit '])}}
                    <button type="button" class="btn btn-sm btn-danger delete-button"><span
                                class="glyphicon glyphicon-trash "></span></button>
                    {{Form::close()}}
                </td>
            </tr>
        @endforeach
        </tbody>
    @endif
</table>