{{--{{dd($bookings->toArray())}}--}}


<div class="">

    <table class="table table-bordered table-striped" id="agent-bookings">
        <thead>
        <tr>
            <th>ID</th>
            <th>Ref. No</th>
            <th>Arrival</th>
            <th>Departure</th>
            <th>Name</th>
            <th>Adults</th>
            <th>Children</th>
            <th>Status</th>
            <th width="160px">Controls</th>
        </tr>
        </thead>
        <tbody>
        @if($bookings->count())
            @foreach($bookings as $booking)
                <tr>
                    <td>{{$booking->id}}</td>
                    <td style="text-align: center">{{$booking->reference_number}}</td>
                    <td style="text-align: center">{{$booking->arrival_date}}</td>
                    <td style="text-align: center">{{date('Y-m-d', strtotime($booking->departure_date))}}</td>
                    <td>{{$booking->booking_name}}</td>
                    <td style="text-align: right">{{$booking->adults}}</td>
                    <td style="text-align: right">{{$booking->children}}</td>
                    <td>{{$booking->val ==0 ? 'Inactive': 'active' }}</td>
                    <td>
                        <div class="">
                            {{ Form::open(array('route'=> array('bookings.show',$booking->id), 'method' =>'get')) }}
                            <button type="submit"
                                    class="btn btn-xs btn-flat btn-primary col-md-2"
                                    style="float: left"><i
                                        class="glyphicon glyphicon-edit"></i></button>
                            {{ Form::close() }}

                            {{ Form::open(array('route'=> array('bookings.destroy',$booking->id), 'method' =>'delete', 'style'=>'float-left')) }}
                            <button type="button"
                                    class="btn btn-xs btn-flat btn-danger delete-button col-md-2"
                                    style="float: left"><i
                                        class="glyphicon glyphicon-trash"></i>
                            </button>
                            {{ Form::close() }}

                            {{--{{ Form::open(array('route'=> array('bookings.show',$booking->id), 'method' =>'get')) }}--}}
                            {{--<button type="submit" class="btn btn-xs btn-flat  col-md-2"--}}
                            {{--style="float: left;"><i--}}
                            {{--class="glyphicon glyphicon-inverse glyphicon-eye-open"></i>--}}
                            {{--</button>--}}
                            {{--{{ Form::close() }}--}}
                            @if($booking->val == 0)

                                {{ Form::open(array('route'=> array('bookings.update',$booking->id), 'method' =>'patch')) }}
                                <button class="btn btn-xs btn-flat btn-success activate-item col-md-2"
                                        type="submit" name="val" value="1"><i
                                            class="glyphicon glyphicon-ok-circle"></i></button>
                                <button style="float: left"
                                        class="btn btn-xs btn-flat btn-default float-left disabled deactivate-item col-md-2"
                                        type="button"><i
                                            class="glyphicon glyphicon-remove-circle"></i>
                                </button>
                                {{ Form::close() }}


                            @else
                                {{ Form::open(array('route'=> array('bookings.update',$booking->id), 'method' =>'patch')) }}
                                <button class="btn btn-xs btn-flat btn-default disabled activate-item col-md-2"
                                        type="button"><i
                                            class="glyphicon glyphicon-ok-circle"></i>
                                </button>
                                <button style="float: left"
                                        class="btn btn-xs btn-flat btn-warning deactivate-item col-md-2"
                                        type="submit" name="val" value="0"><i
                                            class="glyphicon glyphicon-remove-circle"></i>
                                </button>
                                {{ Form::close() }}

                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <th colspan="9">
                    <h2 align=" center">No Bookings Available</h2>
                </th>
            </tr>
        @endif
        </tbody>
    </table>

</div>
