@extends('account.account')

@section('styles')
    <style type="text/css">
        .form-control {
            border-left: none;
            background: none;
        }
    </style>
@endsection

@section('bread-crumbs')
    <li>/</li>
    <li><a href="#" class="active">Sign Up</a></li>
@endsection

@section('body-content')


    <div class="container">


        <div class="line3"></div>

        <div class="row">
            <br>
            <br>

            {{Form::open(array('url'=>array('account/create')))}}
            <div class="col-md-12">
                <div class="col-md-offset-4 col-md-4">
                    <label for="last_name">Email</label>

                    <div class="form-group">
                        {{Form::text('email', null, array('class'=> 'form-control', 'style: border:none;'))}}
                        {{$errors->first('email', '<span class="size12" style="color: red;">:message</span>') }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-offset-4 col-md-4">
                    <div class="row">

                        <div class="col-xs-6">
                            <label for="first_name">First Name</label>

                            <div class="form-group">
                                {{Form::text('first_name', null, array('class'=> 'form-control'))}}
                                {{$errors->first('first_name', '<span class="size12" style="color: red;">:message</span>') }}

                            </div>

                        </div>
                        <div class="col-xs-6">


                            <label for="last_name">Last Name</label>

                            <div class="form-group">
                                {{Form::text('last_name', null, array('class'=> 'form-control'))}}
                                {{$errors->first('last_name', '<span class="size12" style="color: red;">:message</span>') }}

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="col-md-offset-4 col-md-4">

                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-offset-4 col-md-4">
                    <label for="last_name">Password</label>

                    <div class="form-group">
                        {{Form::password('password', array('class'=> 'form-control'))}}
                        {{$errors->first('password', '<span class="size12" style="color: red;">:message</span>') }}

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-offset-4 col-md-4">
                    <label for="last_name">Confirm Password</label>

                    <div class="form-group">
                        {{Form::password('confirm_password', array('class'=> 'form-control'))}}
                        {{$errors->first('confirm_password', '<span class="size12" style="color: red;">:message</span>') }}

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-offset-4 col-md-4">
                    <label for="user_role">I want to register as :</label>

                    <div class="form-group">
                        {{Form::select('user_role',Role::where('name', '!=', 'Admin')->orderBy('id')->lists('name','name'), null, array('class'=> 'form-control', 'id'=>'role'))}}
                        {{$errors->first('user_role', '<span class="size12" style="color: red;">:message</span>') }}

                    </div>
                </div>
            </div>
            <div id="agent_details">
                <div class="col-md-12">
                    <div class="col-md-offset-4 col-md-4">
                        <label for="last_name">Country</label>

                        <div class="form-group">
                            {{Form::select('country',Country::lists('country','id'), null, array('class'=> 'form-control'))}}
                            {{$errors->first('country', '<span class="size12" style="color: red;">:message</span>') }}

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-offset-4 col-md-4">
                        <label for="telephone2">Company Name</label>

                        <div class="form-group">
                            {{Form::text('company', null, array('class'=> 'form-control'))}}
                            {{$errors->first('company', '<span class="size12" style="color: red;">:message</span>') }}

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-offset-4 col-md-4">
                        <label for="telephone2">Telephone:</label>

                        <div class="form-group">
                            {{Form::text('phone', null, array('class'=> 'form-control'))}}
                            {{$errors->first('phone', '<span class="size12" style="color: red;">:message</span>') }}

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-offset-4 col-md-4">
                        <label for="fax">Fax</label>

                        <div class="form-group">
                            {{Form::text('fax', null, array('class'=> 'form-control'))}}
                            {{$errors->first('fax', '<span class="size12" style="color: red;">:message</span>') }}
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            <div class="check-box">

                                {{Form::checkbox('agreement')}}
                                I accept <a href="#">Agreement</a>
                                {{$errors->first('agreement', '<p class="size12" style="color: red;">:message</p>') }}

                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-offset-4 col-md-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block ">Sign-Up</button>
                    </div>
                </div>
            </div>

            {{Form::close()}}

        </div>
    </div>

    <div class="clearfix"></div>
    <br/><br/>
    <!-- END CONTENT -->

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            var agent = $("#agent_details");
            agent.hide();
            if ($("#role").val() == 'Agent') {
                agent.show();
            }
            $("#role").change(function () {
                var x = $(this).val();
                if (x == 'Agent') {
                    agent.show();
                } else {
                    agent.hide();
                }
            });
        });
    </script>
@stop

