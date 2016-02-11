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


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection