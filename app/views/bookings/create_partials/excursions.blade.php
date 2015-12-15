<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-responsive table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Ref. No.</th>
                <th>Excursion</th>
                <th>Date</th>
                <th>Transport Type</th>
                <th>Pax</th>
                <th>Unit Price</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Controls</th>
            </tr>
            </thead>
            <tbody>
            @foreach($booking->excursionBooking as $excursionBooking)
                <tr>
                    <td>{{$excursionBooking->id}}</td>
                    <td>{{$excursionBooking->reference_number}}</td>
                    <td>{{$excursionBooking->excursion->excursion}}</td>
                    <td>{{$excursionBooking->date}}</td>
                    <td>{{$excursionBooking->excursionTransportType->transport_type}}</td>
                    <td>{{$excursionBooking->pax}}</td>
                    <td style="text-align: right">{{number_format($excursionBooking->unit_price, 2)}}</td>
                    <td style="text-align: right">{{$excursionBooking->val==1 ? 'Active': 'Cancelled'}}</td>
                    <td style="text-align: right">{{number_format(ExcursionBooking::getTotalExcursionBookingAmount($booking),2)}}</td>
                    <td>
                        @if($excursionBooking->val == 0)
                            <div class="">
                                {{--{{ Form::open(array('route'=> array('bookings.excursion-bookings.update',$booking->id,$excursionBooking->id), 'method' =>'patch')) }}--}}
                                {{--<button class="btn btn-xs btn-flat btn-success activate-item col-md-3"--}}
                                {{--type="submit" name="val" value="1"><i class="glyphicon glyphicon-ok-circle"></i></button>--}}
                                {{--<button class="btn btn-xs btn-flat btn-default disabled deactivate-item col-md-3"--}}
                                {{--type="button"><i class="glyphicon glyphicon-remove-circle"></i></button>--}}
                                {{--{{ Form::close() }}--}}
                            </div>
                        @else
                            {{ Form::open(array('route'=> array('bookings.excursion-bookings.update',$booking->id,$excursionBooking->id), 'method' =>'patch')) }}
                            <button class="btn btn-xs btn-flat btn-warning deactivate-item col-md-3"
                                    type="submit" name="val" value="0"><i class="glyphicon glyphicon-remove-circle"></i>
                            </button>
                            {{ Form::close() }}
                        @endif
                    </td>

                </tr>
            @endforeach

            </tbody>
        </table>

    </div>
    <div class="row">
        <div class="col-md-12">

            <input data-toggle="modal" data-target="#new_excursion" class="btn bluebtn pull-right" type="button" id=""
                   value="Add New Excursion">

            <div class="modal " id="new_excursion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-aqua">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Add New Voucher</h4>
                        </div>

                        <div class="modal-body">
                            <h4>Note :</h4>

                            <p>You will be redirected to the Home Page. You can search for hotels as you normally do and
                                make
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
        </div>
    </div>
</div>

