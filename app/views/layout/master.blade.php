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
    {{HTML::style("js/plugins/gritter/jquery.gritter.css")}}

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

                </ol>
            </div>
            <div class="col-sm-8">
                <div class="title-action">

                </div>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            @yield('content')
        </div>

        <div class="footer">
            <div>
                <div class="col-md-3">
                    {{date('Y-m-d')}}
                </div>
                <div class="col-md-6">

                    <strong>Copyright</strong> Exotic Holidays International (Pvt) LTD. &copy; {{date('Y')}}
                </div>
            </div>
        </div>

    </div>
</div>

{{HTML::script("//code.jquery.com/jquery-2.1.4.min.js")}}
{{HTML::script("js/bootstrap.min.js")}}
{{HTML::script("js/plugins/metisMenu/jquery.metisMenu.js")}}
{{HTML::script("js/plugins/slimscroll/jquery.slimscroll.min.js")}}
{{HTML::script("js/plugins/gritter/jquery.gritter.min.js")}}

{{HTML::script("js/inspinia.js")}}
{{HTML::script("js/plugins/pace/pace.min.js")}}

@yield('script')


<script type="text/javascript">

    $(document).ready(function () {

        $.ajax({
            url: 'http://' + window.location.host + '/inquiries/get-inquiry-notifications',
            method: 'post',
            data: null,
            cache: false,
            processDate: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {

                /**
                 * Display the number of inquirires
                 */
                var inquiry_count = data.inquiry_count;
                $('#inquiry_count').html(inquiry_count).click(function(){

                });

                var list = listInquiries(data);
                $('#inquiries').html(list);
            },

            error: function () {
                alert('error');
            }

        });

        function listInquiries(data) {

            var list = '';
            array = data.rate_inquiries;
            $.each(array, function (index, item) {

                list += '<div><a id="rinq_' + item.id + '" href="' + item.rateinquiries_url + '">' + item.hotel + ' rates have been added</a></div>';
                list += '<li class="divider"></li>';

            });

            return list;
        }
    });
</script>

</body>

</html>
