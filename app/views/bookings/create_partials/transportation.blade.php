<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-responsive table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>From</th>
                <th>Vehicle</th>
                <th>Locations</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Manage</th>
            </tr>
            </thead>
            <tbody>
            @if($booking->customTrip->count())
                @foreach($booking->customTrip as $trip)
                    <tr>
                        <td>{{$trip->id}}</td>
                        <td>{{$trip->from}}</td>
                        <td>{{$trip->vehicle->vehicle_type}}</td>
                        <td>{{str_replace(',', '<br>', $trip->locations)}}</td>
                        <td>{{number_format($trip->amount, 2)}}</td>
                        <td>{{$trip->val == 1 ? 'Active' : 'Cancelled'}}</td>
                        <td>
                            @if($trip->val == 0)
                                <div class="">
                                    {{--{{ Form::open(array('route'=> array('bookings.custom-trip.update',$booking->id,$trip->id), 'method' =>'patch')) }}--}}
                                    {{--<button class="btn btn-xs btn-flat btn-success activate-item col-md-3"--}}
                                            {{--type="submit" name="val" value="1"><i class="glyphicon glyphicon-ok-circle"></i></button>--}}
                                    {{--<button class="btn btn-xs btn-flat btn-default disabled deactivate-item col-md-3"--}}
                                            {{--type="button"><i class="glyphicon glyphicon-remove-circle"></i></button>--}}
                                    {{--{{ Form::close() }}--}}
                                </div>
                            @else
                                {{ Form::open(array('route'=> array('bookings.custom-trip.update',$booking->id,$trip->id), 'method' =>'patch')) }}
                                {{--<button class="btn btn-xs btn-flat btn-default disabled activate-item col-md-3"--}}
                                        {{--type="button"><i class="glyphicon glyphicon-ok-circle"></i></button>--}}
                                <button class="btn btn-xs btn-flat btn-warning deactivate-item col-md-3"
                                        type="submit" name="val" value="0"><i class="glyphicon glyphicon-remove-circle"></i></button>
                                {{ Form::close() }}
                            @endif
                        </td>


                    </tr>
                @endforeach
            @endif

            @if($booking->predefinedTrip->count())
                @foreach($booking->predefinedTrip as $trip)
                    <tr>
                        <td>{{$trip->id}}</td>
                        <td>{{$trip->pick_up_date_time}}</td>
                        <td>{{$trip->transportPackage->vehicle->vehicle_type}}</td>
                        {{--<td>{{$trip->vehicle->vehicle_type}}</td>--}}
                        <td>{{$trip->transportPackage->destinationCity->city}}</td>
                        <td>{{number_format($trip->amount, 2)}}</td>
                        <td>{{$trip->val == 1 ? 'Active' : 'Cancelled'}}</td>

                        <td>
                            @if($trip->val == 0)
                                <div class="">
                                    {{--{{ Form::open(array('route'=> array('bookings.predefined-trip.update',$booking->id,$trip->id), 'method' =>'patch')) }}--}}
                                    {{--<button class="btn btn-xs btn-flat btn-success activate-item col-md-3"--}}
                                            {{--type="submit" name="val" value="1"><i class="glyphicon glyphicon-ok-circle"></i></button>--}}
                                    {{--<button class="btn btn-xs btn-flat btn-default disabled deactivate-item col-md-3"--}}
                                            {{--type="button"><i class="glyphicon glyphicon-remove-circle"></i></button>--}}
                                    {{--{{ Form::close() }}--}}
                                </div>
                            @else
                                {{ Form::open(array('route'=> array('bookings.predefined-trip.update',$booking->id,$trip->id), 'method' =>'patch')) }}
                                {{--<button class="btn btn-xs btn-flat btn-default disabled activate-item col-md-3"--}}
                                        {{--type="button"><i class="glyphicon glyphicon-ok-circle"></i></button>--}}
                                <button class="btn btn-xs btn-flat btn-warning deactivate-item col-md-3"
                                        type="submit" name="val" value="0"><i class="glyphicon glyphicon-remove-circle"></i></button>
                                {{ Form::close() }}
                            @endif
                        </td>

                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>

    </div>
</div>
