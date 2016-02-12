@extends('account.profile.profile')

@section('content')

    @if(Session::has('global'))
        <div class="col-lg-12">
            <div class="widget style2 navy-bg">
                <div class="row">
                    <div class="col-xs-12">

                    <span class="text-center">
                        <h2>{{Session::get('global')}}</h2>
                    </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Update Credentials
                            <small>Change Password</small>
                        </h5>

                    </div>
                    <div class="ibox-content">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="">

                                    {{Form::model($agent, array('url'=>array('account/profile/update-agent-profile/'.$agent->id)))}}
                                    <div class="form-group">
                                        <label for="company">Company</label>
                                        {{Form::text("company",null,array('class'=>'form-control'))}}
                                        {{$errors->first('company', '<span class="size12" style="color: red;">:message</span>') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        {{Form::text("phone",null,array('class'=>'form-control'))}}
                                        {{$errors->first('phone', '<span class="size12" style="color: red;">:message</span>') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        {{Form::text("address",null,array('class'=>'form-control'))}}
                                        {{$errors->first('address', '<span class="size12" style="color: red;">:message</span>') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Country</label>
                                        {{Form::select("country_id",DB::table('countries')->lists('country','id'),null,array('class'=>'form-control'))}}
                                        {{$errors->first('address', '<span class="size12" style="color: red;">:message</span>') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="tax">Tax</label>
                                        {{Form::text("tax",null,array('class'=>'form-control'))}}
                                        {{$errors->first('tax', '<span class="size12" style="color: red;">:message</span>') }}
                                    </div>

                                    <div class="form-group">
                                        {{Form::submit('Update Profile', array('class'=> 'btn btn-primary'))}}
                                    </div>
                                    {{Form::close()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection