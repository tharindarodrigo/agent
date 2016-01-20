<div class="table-responsive">
    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Time</th>
            <th>Flight</th>
            <th>Type</th>
            <th>Manage</th>
        </tr>
        </thead>
        <tbody>
        @foreach($booking->flightDetail as $flight)
            <tr>
                <td>{{$flight->id}}</td>
                <td>{{$flight->date}}</td>
                <td>{{$flight->time}}</td>
                <td>{{$flight->flight}}</td>
                <td>{{$flight->flight_type==1 ? 'Arrival':'Departure'}}</td>
                <td>
                    {{Form::open(array('route'=>array('bookings.flightDetails.destroy',$booking->id,$flight->id), 'method'=>'delete'))}}
                    <button type="button" class="btn btn-danger btn-sm delete-button" value="{{$flight->id.'_flight'}}">
                        <span class="glyphicon glyphicon-trash"></span></button>
                    <button class="btn btn-primary btn-sm edit_flight" data-toggle="modal"
                            data-target="#flightModal_{{$flight->id}}" value="{{$flight->id.'_client'}}"><span
                                class="glyphicon glyphicon-edit"></span></button>
                    {{Form::close()}}
                    <div class="modal fade" id="flightModal_{{$flight->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Booking - Clients</h4>
                                </div>
                                {{Form::open(array('route'=>array('bookings.flightDetails.update',$booking->id,$flight->id), 'method'=>'patch'))}}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        {{Form::text('date_'.$flight->id,$flight->date,array('class'=>'form-control date-control'))}}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Passport No.</label>
                                        {{Form::text('time_'.$flight->id,$flight->time,array('class'=>'form-control time-control'))}}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Flight</label>
                                        {{Form::text('flight_'.$flight->id,$flight->flight,array('class'=>'form-control'))}}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Flight Type</label>
                                        {{Form::select('flight_type_'.$flight->id,array(1=>'Arrival', 0=> 'Departure'),$flight->type==1 ? 1:0, array('class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    {{Form::submit('Save Changes', array('class'=>'btn btn-primary'))}}
                                </div>
                                {{Form::close()}}

                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach

        <tr class="warning">
            {{Form::open(array('route'=>array('bookings.flightDetails.store',$booking->id)))}}
            <td>&nbsp;</td>
            <td>
                {{Form::input('date','date',null, array('class'=>'form-control date-control', 'placeholder'=> 'Date'))}}
                {{$errors->first('date', '<span class="size12" style="color: red;">:message</span>') }}
            </td>
            <td>
                {{Form::input('time','time',null, array('class'=>'form-control time-control', 'placeholder'=> 'Time'))}}
                {{$errors->first('time', '<span class="size12" style="color: red;">:message</span>') }}
            </td>
            <td>
                {{Form::text('flight',null,array('class'=>'form-control', 'placeholder'=> 'Flight'))}}
                {{$errors->first('flight', '<span class="size12" style="color: red;">:message</span>') }}
            </td>
            <td>
                {{Form::select('flight_type',array(''=>'Flight Type', 1=>'arrival',0=>'departure'),null,array('class'=>'form-control'))}}
                {{$errors->first('flight_type', '<span class="size12" style="color: red;">:message</span>') }}
            </td>
            <td>{{Form::submit('Add Flight', array('class'=>'btn btn-primary'))}}</td>
            {{Form::close()}}
        </tr>

        </tbody>
    </table>

</div>
