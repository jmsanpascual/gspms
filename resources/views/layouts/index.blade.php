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
    <title>Green School</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    {!! HTML::style('css/bootstrap/css/bootstrap.min.css'); !!}
    <!-- {!! HTML::style('css/bootstrap/css/bootstrap-theme.min.css'); !!} --> <!-- Conflict sa template main.css -->
    {!! HTML::style('css/angular-datatable.css') !!}
    {!! HTML::style('js/others/datatable/media/css/jquery.dataTables.min.css'); !!}
    <!-- Font Icons -->
    {!! HTML::style('css/font-awesome.min.css'); !!}
    {!! HTML::style('css/simple-line-icons.css'); !!}
    <!-- CSS Animate -->
    {!! HTML::style('css/animate.css'); !!}
    <!-- Custom styles for this theme -->
    {!! HTML::style('css/main.css'); !!}
    <!-- Fonts -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    --> <!-- Feature detection -->
    {!! HTML::script('js/modernizr-2.6.2.min.js') !!}
    @yield('css')
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="off-canvas">
    <div id="container">
        <header id="header">
            <!--logo start-->
            <div class="brand">
                <a href="#" class="logo"><span>De La</span> Salle</a>
            </div>
            <!--logo end-->
            <div class="toggle-navigation toggle-left">
                <button type="button" class="btn btn-default" id="toggle-left" data-toggle="tooltip" data-placement="right" title="Toggle Navigation">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="user-nav">
                <ul>
                    <li class="profile-photo">
                        <img src="{{ asset('img/avatar.png') }}" alt="" class="img-circle">
                    </li>
                    <li class="dropdown settings">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      {{ Session::get('first_name') . ' ' . Session::get('middle_name') . ' ' .
                      Session::get('last_name') }}
                      <i class="fa fa-angle-down"></i>
                    </a>
                        <ul class="dropdown-menu animated fadeInDown">
                            <li>
                                <a href="{{ URL::to('logout') }}"><i class="fa fa-power-off"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>
        <?php $page = !EMPTY($page) ? $page : ''; ?>
        <!--sidebar left start-->
        <nav class="sidebar sidebar-left">
            <h5 class="sidebar-header">Navigation</h5>
            <ul class="nav nav-pills nav-stacked">
              @if(Session::get('role') == config('constants.role_life'))
              <li ng-class = "{'active' : {{json_encode(($page == 'accounts'))}}; }">
                  <a href="{{ URL::to('users') }}" title="Forms">
                    <i class="fa fa-list-alt"></i> Accounts
                  </a>
              </li>
              @endif

              @if(Session::get('role') == config('constants.role_head')
                || Session::get('role') == config('constants.role_life'))
              <li class="">
                <a href="{{ URL::to('/funds/view') }}" title="Forms">
                    <i class="fa fa-money"></i> Funds
                </a>
              </li>
              @endif

              @if(Session::get('role') == config('constants.role_champion')
                || Session::get('role') == config('constants.role_exec')
                || Session::get('role') == config('constants.role_life'))
                <li ng-class = "{active : {{json_encode(($page == 'projects'))}}; }">
                  <a href="{{ route('view.project2') }}" title="Forms">
                      <i class="icon-doc"></i> Projects
                  </a>
              </li>
              @endif

              @if(Session::get('role') == config('constants.role_champion')
                || Session::get('role') == config('constants.role_exec'))
              <li class="">
                <a href="{{ route('resource-persons.view') }}" title="Forms">
                    <i class="fa fa-user"></i> Resource Person
                </a>
              </li>
              @endif

            </ul>
        </nav>
        <!--sidebar left end-->
        <!--main content start-->
        <section class="main-content-wrapper">
            <section id="main-content">
              @yield('content')
            </section>
        </section>
    </div>
    <!--main content end-->

    <!--Global JS-->
    <!-- // <script src="js/jquery-1.10.2.min.js"></script> -->
    {!! HTML::script('js/others/jquery-1.12.0.min.js') !!}
    {!! HTML::script('plugins/bootstrap/js/bootstrap.min.js') !!}
    {!! HTML::script('plugins/navgoco/jquery.navgoco.min.js') !!}
    {!! HTML::script('plugins/waypoints/waypoints.min.js') !!}
    {!! HTML::script('js/application.js') !!}
    {!! HTML::script('js/others/datatable/media/js/jquery.dataTables.min.js') !!}
    {!! HTML::script('js/vendor/node_modules/angular/angular.min.js') !!}
    {!! HTML::script('js/vendor/node_modules/angular-resource/angular-resource.min.js') !!}
    {!! HTML::script('js/vendor/node_modules/angular-ui-bootstrap/ui-bootstrap-tpls.js') !!}
    {!! HTML::script('js/others/angular-datatable.min.js') !!}
    {!! HTML::script('js/services/common_service.js') !!}
    
    {!! HTML::script('plugins/chartjs/Chart.min.js') !!}
    {!! HTML::script('plugins/chartjs/chartjs-demo.js') !!}
    @yield('scripts')

</body>

</html>
