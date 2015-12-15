@extends('layout.master')

@section('content')
    <div class="navbar-wrapper2 navbar-fixed-top">

        @include('layout.navbar')

    </div>
    <div class="login-fullwidith">


        <div class="col-md-4 login-wrap">

            <div class="row ">

            {{Form::open(array('url'=>array('account/recover-account',$code), 'method'=>'post'))}}
            <div class="login-c1">
                <div class="cpadding50">
                    <p>{{Session::get('global')}}</p>
                    {{Form::password('password', array('class'=> 'form-control logpadding', 'placeholder'=>'password'))}}
                    {{$errors->first('password', '<span class="size12" style="color: red;">:message</span>') }}
                    <br/>
                    {{Form::password('confirm_password', array('class'=> 'form-control logpadding', 'placeholder'=>'confirm password'))}}
                    {{$errors->first('confirm_password', '<span class="size12" style="color: red;">:message</span>') }}

                    <span class="size12" style="color: red;">{{ Session::get('global') }}</span>
                </div>
            </div>
            <div class="login-c2">
                <div class="logmargfix">
                    <div class="chpadding50">
                        <div class="alignbottom">
                            <button type="submit" class="btn-search4">Change Password</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="login-c3">
                <div class="left"><a href="{{URL::to('/')}}" class="whitelink"><span></span>Website</a></div>
            </div>
            {{Form::close()}}

        </div>

        </div>
    </div>

@endsection

@section('script')
    {{HTML::script("assets/js/initialize-loginpage.js")}}
    {{HTML::script("assets/js/jquery.easing.js")}}
    <script type="text/javascript">
        function errorMessage() {
            $('.login-wrap').animo({
                animateRotate: 'tada'
            });
        }
    </script>

@endsection
