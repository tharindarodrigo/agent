<!DOCTYPE html>
<html>

<head>
    {{HTML::style("css/bootstrap.min.css" )}}
    {{HTML::style("font-awesome/css/font-awesome.css" )}}

    {{HTML::style("css/animate.css" )}}
    {{HTML::style("css/style.css" )}}
</head>


<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown" style="vertical-align: middle">
    <div style="vertical-align: middle">
        <div class="col-md-12" style="height: 100px;">
            &nbsp;
        </div>
        {{Form::open(array('url'=>array('account/sign-in'), 'class'=>'m-t', 'role'=>'form'))}}
            <div class="form-group">
                <input name="email" class="form-control" placeholder="Username" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

            <a href="#">
                <small>Forgot password?</small>
            </a>

            <p class="text-muted text-center">
                <small>Do not have an account?</small>
            </p>
            <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>
        {{Form::close()}}
        <p class="m-t">
            <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small>
        </p>
    </div>
</div>

<!-- Mainly scripts -->
{{HTML::script("js/jquery-2.1.1.js")}}
{{HTML::script("js/bootstrap.min.js")}}

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.3/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Nov 2015 11:36:17 GMT -->
</html>
