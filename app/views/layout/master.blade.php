<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Empty Page</title>

    {{HTML::style("css/bootstrap.min.css")}}
    {{HTML::style("font-awesome/css/font-awesome.css")}}

    {{HTML::style("css/animate.css")}}
    {{HTML::style("css/style.css")}}

    {{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}

    @yield('css')

</head>

<body class="">

<div id="wrapper">

    @include('layout.sidebar')

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            @include('layout.navbar')
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>@yield('main-title')</h2>
                <ol class="breadcrumb">
                    @yield('bread-crumbs')
                    <li>
                        <a href="#">This is</a>
                    </li>
                    <li class="active">
                        <strong>Breadcrumb</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-8">
                <div class="title-action">
                    {{ Form::open(array('url' => '/booking-cart', 'files'=> true, 'id' => 'view_booking_cart', 'class' => 'wizard-big', 'method' => 'POST', )) }}
                    <button class="pull-right book_hotel btn-xs btn-primary" type="submit">
                        <i class="fa fa-check"></i>&nbsp;Book
                    </button>
                    {{Form::close()}}
                </div>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            @yield('content')
        </div>

        {{--<div class="footer">--}}
            {{--<div>--}}
                {{--<strong>Copyright</strong> Exotic Holidays International (Pvt) LTD. &copy; {{date('Y')}}--}}
            {{--</div>--}}
        {{--</div>--}}

    </div>
</div>

{{HTML::script("//code.jquery.com/jquery-2.1.4.min.js")}}
{{HTML::script("js/bootstrap.min.js")}}
{{HTML::script("js/plugins/metisMenu/jquery.metisMenu.js")}}
{{HTML::script("js/plugins/slimscroll/jquery.slimscroll.min.js")}}

{{HTML::script("js/inspinia.js")}}
{{HTML::script("js/plugins/pace/pace.min.js")}}

<!-- Custom js -->
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js') }}

@yield('script')

</body>

</html>
