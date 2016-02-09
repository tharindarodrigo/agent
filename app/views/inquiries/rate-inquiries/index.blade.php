@extends('inquiries.rate-inquiries.rate-inquiries')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Rate Inquires</h5>
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
                                <th>Meal Basis</th>
                                <th>Room Spec</th>
                                <th>Status</th>
                                <th>Control</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($rateinquiries->count())
                                @foreach($rateinquiries as $rateinquiry)
                                    <tr>
                                        <td>{{$rateinquiry->id}}</td>
                                        <td>{{$rateinquiry->from}}</td>
                                        <td>{{$rateinquiry->to}}</td>
                                        <td>{{$rateinquiry->hotel->name}}</td>
                                        <td>{{$rateinquiry->roomType->room_type}}</td>
                                        <td>{{$rateinquiry->mealBasis->meal_basis}}</td>
                                        <td>{{$rateinquiry->roomSpecification->room_specification}}</td>
                                        <td>
                                            @if($rateinquiry->status == 0)
                                                <small class="label label-warning"> Pending</small>

                                            @elseif($rateinquiry->status=1)
                                                <small class="label label-primary"> Confirmed</small>
                                            @endif
                                        </td>
                                        <td width="170px">
                                            <div class="">
                                                {{ Form::open(array('route'=> array('inquiries.rate-inquiries.show',$rateinquiry->id), 'method' =>'get')) }}
                                                <button type="submit"
                                                        class="btn btn-xs btn-flat btn-primary col-md-2"
                                                        style="float: left"><i
                                                            class="glyphicon glyphicon-edit"></i></button>
                                                {{ Form::close() }}

                                                {{ Form::open(array('route'=> array('inquiries.rate-inquiries.destroy',$rateinquiry->id), 'method' =>'delete', 'style'=>'float-left')) }}
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
                                                @if($rateinquiry->val == 0)

                                                    {{ Form::open(array('route'=> array('inquiries.rate-inquiries.update',$rateinquiry->id), 'method' =>'patch')) }}
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
                                                    {{ Form::open(array('route'=> array('inquiries.rate-inquiries.update',$rateinquiry->id), 'method' =>'patch')) }}
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