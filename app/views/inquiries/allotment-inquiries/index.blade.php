@extends('inquiries.allotment-inquiries.allotment-inquiries')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="col-md-3">
                            <h5>Allotment Inquiries</h5>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    Agent :
                                    {{Form::select('agent_id', array('%'=>'All')+Agent::lists('company', 'id'), null , array('class' => 'form-control'))}}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    From :
                                    {{Form::input('date', 'from', null, array('class' => 'form-control', ))}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    To : 
                                    {{Form::input('date', 'to', null, array('class' => 'form-control'))}}
                                </div>
                            </div>
                            <div class="col-md-3" align="center">
                                <div class="form-group">
                                    &nbsp;
                                    {{Form::submit('Search', array('class'=>'btn btn-block btn-primary'))}}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="ibox-content">
                        <table class="table bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Hotel</th>
                                <th>Room Type</th>
                                <th>Status</th>
                                <th>Controls</th>
                            <tr>
                            </thead>
                            <tbody>
                            @if($allotmentinquiries->count())

                                @foreach($allotmentinquiries as $allotmentinquiry)
                                    <tr>
                                        <td>{{$allotmentinquiry->id}}</td>
                                        <td>{{$allotmentinquiry->from}}</td>
                                        <td>{{$allotmentinquiry->to}}</td>
                                        <td>{{$allotmentinquiry->hotel->name}}</td>
                                        <td>{{$allotmentinquiry->roomType->room_type}}</td>
                                        <td>
                                            @if($allotmentinquiry->status == 0)
                                                <small class="label label-warning"> Pending</small>
                                            @elseif($allotmentinquiry->status==1)
                                                <small class="label label-primary"> Confirmed</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{Form::open(array('url'=>array('inquiries.allotment-inquiries.delete', $allotmentinquiry->id), 'method'=>'delete' ))}}
                                            <button class="btn btn-sm btn-danger delete-button"><span
                                                        class="glyphicon glyphicon-trash"></span></button>
                                            {{Form::close()}}

                                            {{Form::open(array(''))}}
                                            <button class="btn btn-sm btn-warning "><span
                                                        class="glyphicon glyphicon-"></span></button>
                                            {{Form::close()}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else

                                <tr>
                                    <td colspan="8" align="center"><h3>No results Found</h3></td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection