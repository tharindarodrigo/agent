@extends('layout.master')

@section('content')
    <div class="navbar-wrapper2 navbar-fixed-top">

        @include('layout.navbar')

    </div>
    <div class="login-fullwidith">

        <!-- Login Wrap  -->
        <div class="login-wrap1">

            {{Form::open(array('url'=>array('account/sign-in')))}}
            <div class="login-c1-s">
                <div class="cpadding50">

                    <div class="">

                        {{Form::open(array('url'=>array('account/create')))}}

                        <div class="form-group">
                            {{Form::text('email', null, array('class'=> 'form-control', 'style: border:none;', 'placeholder' => 'Email'))}}
                            {{$errors->first('email', '<span class="size12" style="color: red;">:message</span>') }}
                        </div>
                        <div class="row">

                            <div class="col-xs-6">
                                <div class="form-group">
                                    {{Form::text('first_name', null, array('class'=> 'form-control', 'placeholder' => 'First Name'))}}
                                    {{$errors->first('first_name', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>

                            </div>
                            <div class="col-xs-6">

                                <div class="form-group">
                                    {{Form::text('last_name', null, array('class'=> 'form-control', 'placeholder'=>'Last Name'))}}
                                    {{$errors->first('last_name', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            {{Form::password('password', array('class'=> 'form-control', 'placeholder'=> 'Password'))}}
                            {{$errors->first('password', '<span class="size12" style="color: red;">:message</span>') }}

                        </div>


                        <div class="form-group">
                            {{Form::password('confirm_password', array('class'=> 'form-control', 'placeholder'=>'Confirm Password'))}}
                            {{$errors->first('confirm_password', '<span class="size12" style="color: red;">:message</span>') }}

                        </div>


                        <label for="user_role">I want to register as :</label>

                        <div class="form-group">
                            {{Form::select('user_role',Role::where('name', '!=', 'Admin')->orderBy('id')->lists('name','name'), null, array('class'=> 'form-control', 'id'=>'role'))}}
                            {{$errors->first('user_role', '<span class="size12" style="color: red;">:message</span>') }}

                        </div>
                    </div>
                    <div class="" id="agent_details">
                        <div class="">
                            <div class="">
                                <div class="form-group">
                                    {{Form::select('country',Country::lists('country','id'), null, array('class'=> 'form-control', 'placeholder'=>'Country'))}}
                                    {{$errors->first('country', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="">
                                <div class="form-group">
                                    {{Form::text('company', null, array('class'=> 'form-control', 'placeholder'=>'Company Name'))}}
                                    {{$errors->first('company', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="">

                                <div class="form-group">
                                    {{Form::text('phone', null, array('class'=> 'form-control', 'placeholder'=>'Telephone'))}}
                                    {{$errors->first('phone', '<span class="size12" style="color: red;">:message</span>') }}

                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="">
                                <div class="form-group">
                                    {{Form::text('fax', null, array('class'=> 'form-control', 'placeholder'=>'Fax'))}}
                                    {{$errors->first('fax', '<span class="size12" style="color: red;">:message</span>') }}
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="">
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

                    {{Form::close()}}

                </div>
            </div>
        </div>
        <div class="login-c2-s">
            <div class="logmargfix">
                <div class="chpadding50">
                    <div class="alignbottom">
                        <button type="submit" class="btn-search4">Sign Up</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="login-c3-s">
            <div class="left"><a href="{{URL::to('/')}}" class="whitelink"><span></span>Website</a></div>
            <div class="right"><a class="whitelink" href="{{URL::to('account/forgot-password')}}">
                    Forgot Password ?
                </a></div>
        </div>
        {{Form::close()}}
    </div>
    </div>

@endsection

@section('script')
    {{HTML::script("assets/js/initialize-loginpage.js")}}
    {{HTML::script("assets/js/jquery.easing.js")}}
    <script type="text/javascript">
        function errorMessage() {
            $('.login-wrap1').animo({
                animateRotate: 'tada'
            });
        }
    </script>
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

@endsection
