<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> srilankahotels.travel Sign-in </title>

    <!-- Bootstrap -->
    {{ HTML::style('dist/css/bootstrap.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}
    {{ HTML::style('assets/css/custom.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}
    {{ HTML::style('assets/css/intro.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {{ HTML::script('assets/js/html5shiv.js') }}
    {{ HTML::script('assets/js/respond.min.js') }}
    <![endif]-->

    <!-- Fonts -->
    {{ HTML::style('http://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}
    {{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:700,400,300,300italic' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}

    <!-- Font-Awesome -->
    {{ HTML::style('assets/css/font-awesome.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}
    <!--[if lt IE 7]>
    {{ HTML::style('assets/css/font-awesome-ie7.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}
    <![endif]-->

    <!-- Carousel -->
    {{ HTML::style('examples/carousel/carousel.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}

    <!-- Revolution banner css settings -->
    {{ HTML::style('css/fullscreen.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}
    {{ HTML::style('rs-plugin/css/settings.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}

    <!-- Picker -->
    {{ HTML::style('assets/css/jquery-ui.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}

    <!-- jQuery -->
    {{ HTML::script('assets/js/jquery.v2.0.3.js') }}

    <style type="text/css">
        .logo {
            margin-left: 20px;
            width: 304px;
            height: 92px;
        }

        .sign-in {
            width: 30px;
            height: 30px;
        }
    </style>

</head>
<body>

<!-- BLUE SECTION -->
<div class="bluediv">
    <div class="loader">{{ HTML::image('images/loading.gif') }}</div>

    <br/> <br/>
    <a href="intro2.html">{{ HTML::image('images/site/logo11.png', '', array('class' => 'logo')) }}</a>

    <div class="tabscontainer">
        <ul class='tabs'>
            <li class="b1" onclick='mySelectUpdate();'><a href='#tab1'>
                    <div class="anivacations">{{ HTML::image('images/Sign-in-icon.jpg', '', array('class' => 'sign-in')) }}
                        Sign-in
                    </div>
                </a></li>
            <li class="b2" onclick='mySelectUpdate();'><a href='#tab2'>
                    <div class="anihotels">{{ HTML::image('images/user_signup.png', '', array('class' => 'sign-in')) }}
                        Register
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <div class="social">
        <a href="#">{{ HTML::image('images/icon-facebook.png') }}</a>
        <a href="#">{{ HTML::image('images/icon-twitter.png') }}</a>
        <a href="#">{{ HTML::image('images/icon-gplus.png') }}</a>
        <a href="#">{{ HTML::image('images/icon-youtube.png') }}</a>
        <br/><br/>
        &copy; 2013 |<a href="#">Travel Agency</a><br/>All rights reserved.
    </div>
</div>
<!-- END OF BLUE SECTION -->

<!--WHITE SECTION -->
<div class="whitediv">

    <!--HOME OBJECTS -->

    <img class="girl-car" src="images/girl-car.png" alt=""/>
    <img class="car" src="images/car.png" alt=""/>
    <img class="girl-cruise" src="images/girl-cruise.png" alt=""/>

    <div class="palmbgcontainer"></div>
    <img class="dubai" src="images/dubai.jpg" alt=""/>
    <img class="plane" src="images/plane.jpg" alt=""/>
    <img class="road" src="images/road.jpg" alt=""/>
    <img class="cruise" src="images/cruise.jpg" alt=""/>

    <!--TAB 1 -->
    <div id="tab2">

        <form role="form" action="{{ URL::route('account-create-post') }}" method="post" id="form1"
              class="">

            <div class="form-group">
                <span class="opensans size18"> First name </span>
                <input type="text" placeholder="First name..." class="form-first-name form-control" id="first_name" name="first_name">
            </div>
            <div class="custom_validation" style="color: firebrick; font-style: italic; font-size: small; "></div>

            <div class="form-group">
                <span class="opensans size18"> Last name </span>
                <input type="text" placeholder="Last name..." class="form-last-name form-control" id="last_name" name="last_name"{{ (Input::old('last_name')) ? ' value="' . e(Input::old('last_name'))  . '"' : ''  }}>
            </div>
            <div class="custom_validation" style="color: firebrick; font-style: italic; font-size: small; "></div>

            <div class="form-group">
                <span class="opensans size18"> Email </span>
                <input type="text" placeholder="Email..." class="form-email form-control" id="email" name="email">
            </div>
            <div class="custom_validation" style="color: firebrick; font-style: italic; font-size: small; "></div>

            <div class="form-group">
                <span class="opensans size18"> Password </span>
                <input type="password" placeholder="Password..." class="form-password form-control" id="password" name="password">
            </div>
            <div class="custom_validation" style="color: firebrick; font-style: italic; font-size: small; "></div>


            <div class="form-group">
                <span class="opensans size18"> Confirm Password </span>
                <input type="password" placeholder="Confirm Password..." class="form-password form-control" id="confirm_password" name="confirm_password">
            </div>
            <div class="custom_validation" style="color: firebrick; font-style: italic; font-size: small; "></div>

            <button type="submit" class="btn-search2" id="sub1"> Register</button>

            {{ Form::token() }}

        </form>

    </div>
    <!-- END OF TAB1 -->

    <!--TAB 2 -->
    <div id="tab1" >

        <form role="form" action="{{ URL::route('account-sign-in-post') }}" method="post" class="" id="form2">
            <div class="form-group">
                <span class="opensans size18"> Email </span>
                <input type="text" placeholder="Email..." class="form-email form-control" id="log_email" name="email">
            </div>
            <div class="custom_validation" style="color: firebrick; font-style: italic; font-size: small; "></div>

            <div class="form-group">
                <span class="opensans size18"> Password </span>
                <input type="password" placeholder="Password..." class="form-password form-control" id="log_password" name="password"{{ (Input::old('log_password')) ? ' value="' . e(Input::old('log_password'))  . '"' : ''  }}>
            </div>
            <div class="custom_validation" style="color: firebrick; font-style: italic; font-size: small; "></div>

            <p>
                <span class="opensans size18"> <input type="checkbox" name="remember" id="remember"> Remember Me! </span>
            </p>
            <div class="unsuccess_alert" style="color: firebrick; font-style: italic; font-size:medium; font-weight: bold "></div>


            <button type="submit" class="btn-search2"> Sign In</button>
            &nbsp;&nbsp;&nbsp;&nbsp;

            <a href="{{ URL::route('account-forgot-password')}}">Forgot your password?</a>

            {{--{{ Form::token() }}--}}
        </form>

    </div>
    <!--END OF TAB 2 -->

</div>
<!-- END OF WHITE SECTION -->


<!-- Include all compiled plugins (below), or include individual files as needed -->
{{ HTML::script('dist/js/bootstrap.min.js') }}

<!-- Javascript -->
{{ HTML::script('assets/js/js-intro.js') }}

<!-- Preload images -->
{{ HTML::script('assets/js/jquery.preload.js') }}

<!-- Easing -->
{{ HTML::script('assets/js/jquery.easing.js') }}

<!-- Nicescroll  -->
{{ HTML::script('assets/js/jquery.nicescroll.min.js') }}

<!-- Picker UI-->
{{ HTML::script('assets/js/jquery-ui.js') }}

<!-- Custom Select -->
{{ HTML::script('assets/js/jquery.customSelect.js') }}

<!-- Functions -->
{{ HTML::script('assets/js/functions.js') }}

<!-- CarouFredSel -->
{{ HTML::script('assets/js/jquery.carouFredSel-6.2.1-packed.js') }}
{{ HTML::script('assets/js/helper-plugins/jquery.touchSwipe.min.js') }}
{{ HTML::script('assets/js/helper-plugins/jquery.mousewheel.min.js') }}
{{ HTML::script('assets/js/helper-plugins/jquery.transit.min.js') }}
{{ HTML::script('assets/js/helper-plugins/jquery.ba-throttle-debounce.min.js') }}

{{ HTML::script('js/functions/dataFunctions.js')}}

<script type="text/javascript">

    $(function(){

        $('.custom_validation').hide();
        $('.unsuccess_alert').hide();

        $('#form1').submit(function(e){
            var url = 'create';
            var method = 'post';
            var prefix = '';
            var successpage = 'http://'+window.location.host+'/account/account-confirmation';
            var defaultPage = 'http://'+window.location.host;

            $('.custom_validation').slideUp(200);

            e.preventDefault();
            var formData = new FormData;
            formData.append('first_name', $('#first_name').val());
            formData.append('last_name', $('#last_name').val());
            formData.append('email', $('#email').val());
            formData.append('password', $('#password').val());
            formData.append('confirm_password', $('#confirm_password').val());

            postData(url, method, prefix, formData, successpage, defaultPage);
        });

        $('#form2').submit(function(e){
            var url = 'sign-in';
            var method = 'post';
            var prefix = 'log_';
            var successpage = 'http://'+window.location.host;
            var defaultPage = 'http://'+window.location.host;


            e.preventDefault();

            $('.custom_validation').slideUp(200);
            $('.unsuccess_alert').slideUp();

            var formData =new FormData;
            formData.append('email', $('#log_email').val());
            formData.append('password', $('#log_password').val());
            formData.append('remember', $('#remember').val());

            postData(url, method, prefix, formData, successpage, defaultPage);

        });
    });

</script>

</body>
</html>
