<div class="table-responsive">
    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Passport No.</th>
            <th>DoB</th>
            <th>Gender</th>
            <th>Manage</th>
        </tr>
        </thead>
        <tbody>
        @foreach($booking->client as $client)
            <tr>
                <td>{{$client->id}}</td>
                <td>{{$client->name}}</td>
                <td>{{$client->passport_number}}</td>
                <td>{{$client->dob}}</td>
                <td>{{$client->gender==1 ? 'Male':'Female'}}</td>
                <td>
                    {{Form::open(array('route'=>array('bookings.clients.destroy',$booking->id,$client->id),'method'=>'delete'))}}
                    <button type="button" class="btn btn-danger btn-sm delete-button" value="{{$client->id.'_client'}}">
                        <span class="glyphicon glyphicon-trash"></span></button>
                    <button type="button" class="btn btn-primary btn-sm edit_client" data-toggle="modal"
                            data-target="#clientModal_{{$client->id}}" value="{{$client->id.'_client'}}"><span
                                class="glyphicon glyphicon-edit"></span></button>
                    {{Form::close()}}
                    <div class="modal fade" id="clientModal_{{$client->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Booking - Clients</h4>
                                </div>
                                {{Form::open(array('route'=>array('bookings.clients.update',$booking->id,$client->id), 'method'=>'patch'))}}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        {{Form::text('name_'.$client->id,$client->name,array('class'=>'form-control'))}}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Passport No.</label>
                                        {{Form::text('passport_number_'.$client->id,$client->passport_number,array('class'=>'form-control'))}}
                                    </div>
                                    <div class="form-group">
                                        <label for="">DoB</label>
                                        {{Form::text('dob_'.$client->id,$client->dob,array('class'=>'form-control my_dob'))}}
                                    </div>
                                    <div class="form-group">
                                        <label for="">Dob</label>
                                        {{Form::select('gender_'.$client->id,array(1=>'male', 0=> 'female'),$client->gender==1 ? 1:0, array('class'=>'form-control'))}}
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
            {{Form::open(array('route'=>array('bookings.clients.store',$booking->id)))}}
            <td>&nbsp;</td>
            <td>
                {{Form::text('name',null, array('class'=>'form-control', 'placeholder'=> 'Name'))}}
                {{$errors->first('name', '<span class="size12" style="color: red;">:message</span>') }}
            </td>
            <td>
                {{Form::text('passport_number',null, array('class'=>'form-control', 'placeholder'=> 'Passport No.'))}}
                {{$errors->first('passport_number', '<span class="size12" style="color: red;">:message</span>') }}
            </td>
            <td>
                {{Form::input('date','dob',null,array('class'=>'form-control', 'placeholder'=> 'Date of Birth', 'id'=>'dob'))}}
                {{$errors->first('dob', '<span class="size12" style="color: red;">:message</span>') }}
            </td>
            <td>
                {{Form::select('gender',array(''=>'gender', 1=>'male',0=>'female'),null,array('class'=>'form-control'))}}
                {{$errors->first('gender', '<span class="size12" style="color: red;">:message</span>') }}
            </td>
            <td>{{Form::submit('add Client', array('class'=>'btn btn-primary'))}}</td>
            {{Form::close()}}
        </tr>

        </tbody>
    </table>

</div>



