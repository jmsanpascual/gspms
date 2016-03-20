<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <!-- Fonts from Font Awsome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- CSS Animate -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Custom styles for this theme -->
    <link rel="stylesheet" href="css/main.css">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <!-- Feature detection -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="animated fadeIn">
    <section id="login-container" ng-app='login'>

        <div class="row" ng-controller='LoginCtrl'>
            <div class="col-md-3" id="login-wrapper">
                <div class="panel panel-primary animated flipInY">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                           Sign In
                        </h3>
                    </div>
                    <div class="panel-body">
                       <p> Login to access your account.</p>
                        <form class="form-horizontal" role="form" ng-submit='login()'>
                            <input type ="hidden" ng-model = "user.token" ng-value = "{{ csrf_token()}}">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id='email' placeholder="Username"
                                    ng-model='user.username' required>
                                    <i class="fa fa-user"></i>
                                </div>
                            </div>
                            <div class="form-group">
                               <div class="col-md-12">
                                    <input type="password" class="form-control" id='password' placeholder="Password"
                                    ng-model='user.password' required>
                                    <i class="fa fa-lock"></i>
                                    <!-- <a href="javascript:void(0)" class="help-block">Forgot Your Password?</a> -->
                                </div>
                            </div>
                            <div class="form-group">
                               <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                    <!-- <hr />
                                    <a href="pages-sign-up.html" class="btn btn-default btn-block">Not a member? Sign Up</a> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--Global JS-->
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/waypoints/waypoints.min.js"></script>
    <script src="js/application.js"></script>
    {!! HTML::script('js/vendor/node_modules/angular/angular.min.js') !!}
    {!! HTML::script('js/controllers/login.js') !!}
</body>

</html>
