<div class="table-responsive">
    <table class="table table-responsive table-bordered" id="agent-bookings">
        <thead>
        <tr>
            <th style="text-align:center;">Id</th>
            <th style="text-align:center;">Hotel</th>
            <th style="text-align:center;">Check In</th>
            <th style="text-align:center;">Check Out</th>
            <th style="text-align:center;">Room</th>
            <th style="text-align:center;">Basis</th>
            <th style="text-align:center;">Spec</th>
            <th style="text-align:center;">Amount</th>
            <th style="text-align:center;">Status</th>
            <th style="text-align:center;">Controls</th>
        </tr>
        </thead>
        <tbody>
        <style type="text/css">
            td {
                vertical-align: middle;
            }
        </style>
        @foreach($booking->voucher as $voucher)
            <tr class="{{$voucher->val == 0 ? 'danger' : ''}}" >
                <td>{{$voucher->id}}</td>
                <td>{{$voucher->hotel->name}}</td>
                <td>{{$voucher->check_in}}</td>
                <td>{{$voucher->check_out}}</td>
                <td>
                    @foreach($voucher->roomBooking as $roomBooking)
                        <div style="text-align: center;">{{$roomBooking->roomType->room_type}}</div>
                    @endforeach
                </td>

                <td>
                    @foreach($voucher->roomBooking as $roomBooking)
                        <div style="text-align: center;">{{$roomBooking->mealBasis->meal_basis}}</div>
                    @endforeach
                </td>
                <td>
                    @foreach($voucher->roomBooking as $roomBooking)
                        <div style="text-align: center;">{{$roomBooking->roomSpecification->room_specification}}</div>
                    @endforeach
                </td>
                <td align="right">{{number_format(Voucher::getVoucherAmount($voucher),2)}}</td>
                <td align="center">{{$voucher->val ==0 ? 'Cancelled':'Active'}}</td>
                <td>

                    @if($voucher->val == 1)
                        {{link_to('vouchers/'.$voucher->id.'/cancel','Cancel',array('class' => 'btn btn-warning', 'onclick'=>'confirmDelete()'))}}
                    @endif

                    <a href="{{URL::to('voucher/'.$voucher->id)}}" class="btn btn-default"><span
                                class="glyphicon glyphicon-eye-open"></span></a>
                    {{--<button class="btn btn-sm" data-toggle="modal" data-target="#voucherModal_{{$voucher->id}}" ><span class="glyphicon glyphicon-eye-open"></span></button>--}}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

</div>


<input data-toggle="modal" data-target="#new_voucher" class="btn bluebtn pull-right" type="button" id
       value="Add New Voucher">
<div class="modal " id="new_voucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-aqua">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Voucher</h4>
            </div>

            <div class="modal-body">
                <h4>Note :</h4>

                <p>You will be redirected to the Home Page. You can search for hotels as you normally do and make
                    bookings</p>

                <div class="check-box">
                    {{Form::checkbox("dont_show")}}
                    I don't want to see this again
                </div>
            </div>
            <div class="modal-footer">

                {{link_to_route('bookings.vouchers.create','Proceed',array($booking->id),array('class'=>'btn btn-primary'))}}
                <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
            </div>

        </div>
    </div>
</div>

