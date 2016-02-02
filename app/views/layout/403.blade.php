@extends('reservations.reservations')

@section('head-styles')
    {{ HTML::style('css/plugins/iCheck/custom.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}
    {{ HTML::style('css/plugins/steps/jquery.steps.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}

    <!-- FooTable -->
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">

    <style type="text/css">
        h5 {
            color: #3498db;
        }

        .hotel_list_hide {
            display: none;
        }

        .room_list_hide {
            display: none;
        }

        .hotel_img_1 {
            width: 40px;
            height: 34px;
        }
    </style>

@endsection

@section('reservations-content')

    <div id="" class="gray-bg" style="min-height: 300px;">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5> 403 Page </h5>
                        </div>
                        <div class="ibox-content">
                            {{ HTML::image('images/403.png', '', array('class' => '403')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection

@section('footer-scripts')

    <!-- Steps -->
    {{HTML::script("js/plugins/staps/jquery.steps.min.js")}}

    <!-- Jquery Validate -->
    {{HTML::script("js/plugins/validate/jquery.validate.min.js")}}

    {{HTML::script("js/plugins/iCheck/icheck.min.js")}}

    <!-- Custom js -->
    {{ HTML::script('js/my_script.js') }}
    {{ HTML::script('js/booking.js') }}

    <!-- FooTable -->
    <script src="js/plugins/footable/footable.all.min.js"></script>

    <!-- Page-Level Scripts -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('.footable').footable();
        });
    </script>

@endsection