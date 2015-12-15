<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.3/empty_page.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Nov 2015 11:39:13 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Empty Page</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
                        <a href="index-2.html">This is</a>
                    </li>
                    <li class="active">
                        <strong>Breadcrumb</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-8">
                <div class="title-action">
                    <a href="#" class="btn btn-primary">This is action area</a>
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

<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

@yield('scripts')

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.3/empty_page.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Nov 2015 11:39:13 GMT -->
</html>
