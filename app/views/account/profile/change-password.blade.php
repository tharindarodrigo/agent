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
       a         </div>
            </div>
        </div>
    @endif
    @if(Session::has('wrong-password'))
        <div class="col-lg-12">
            <div class="widget style2 red-bg">
                <div class="row">
                    <div class="col-xs-12">

                    <span class="text-center">
                        <h2>{{Session::get('wrong-password')}}</h2>
                    </span>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                </div>
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

                                    {{Form::open(array('url'=>array('account/profile/post-change-password')))}}
                                    <div class="form-group">
                                        <label for="old_password">Old Password</label>
                                        {{Form::password("current_password",array('class'=>'form-control'))}}
                                        {{$errors->first('current_password', '<span class="size12" style="color: red;">:message</span>') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="old_password">New Password</label>
                                        {{Form::password("new_password",array('class'=>'form-control'))}}
                                        {{$errors->first('new_password', '<span class="size12" style="color: red;">:message</span>') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="old_password">Password Again</label>
                                        {{Form::password("password_again",array('class'=>'form-control'))}}
                                        {{$errors->first('password_again', '<span class="size12" style="color: red;">:message</span>') }}

                                    </div>
                                    <div class="form-group">
                                        {{Form::submit('Change Password', array('class'=> 'btn btn-primary'))}}
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