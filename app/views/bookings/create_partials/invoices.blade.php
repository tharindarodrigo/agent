
<div class="table-responsive">
<table class="table table-responsive table-bordered">
<thead>
    <tr>
        <th>Id</th>
        <th>Reference Number</th>
        <th>Amount</th>
        <th>Manage</th>
    </tr>
</thead>
<tbody>

<tr>
    <td>{{$booking->invoice->id}}</td>
    <td>{{$booking->reference_number}}</td>
    <td align="right">USD. {{number_format($booking->inovioce,2)}}</td>
    <td><a class="btn btn-default" href="{{URL::to('invoice/'.$booking->id)}}" target="_blank">View Invoice</a></td>
</tr>

</tbody>
</table>

</div>
