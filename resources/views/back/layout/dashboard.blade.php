<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png')  }}">
    <title>{{ env('APP_NAME') }} - @yield("contentTitle")</title>
    <!-- This page CSS -->

    @yield("CSS")

    <!--Toaster Popup message CSS -->
    <link href="{{ asset('assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">

    <!-- Bostrap dataTable -->
    <link href="{{ asset('assets/node_modules/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="{{ asset('template/dist/css/style.min.css') }}" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{ asset('template/dist/css/pages/dashboard1.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-default-dark fixed-layout">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Cargando</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header">
                <a class="navbar-brand">

                    <img src="{{ asset('assets/images/logo-light-icon.png') }}" class="mini"/>
                    <img src="{{ asset('assets/images/logo-light-text.png') }}" class="expanded"/>

                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto">
                    <!-- This is  -->
                    <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                    <!-- ============================================================== -->
                    <!-- Search -->
                    <!-- ============================================================== -->
                    {{--<li class="nav-item">--}}
                        {{--<form class="app-search d-none d-md-block d-lg-block">--}}
                            {{--<input type="text" class="form-control" placeholder="Search & enter">--}}
                        {{--</form>--}}
                    {{--</li>--}}
                </ul>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                {{--<ul class="navbar-nav my-lg-0">--}}
                    <!-- ============================================================== -->
                    <!-- Comment -->
                    <!-- ============================================================== -->
                    {{--<li class="nav-item dropdown">--}}
                        {{--<a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-email"></i>--}}
                            {{--<div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">--}}
                            {{--<ul>--}}
                                {{--<li>--}}
                                    {{--<div class="drop-title">Notifications</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<div class="message-center">--}}
                                        {{--<!-- Message -->--}}
                                        {{--<a href="javascript:void(0)">--}}
                                            {{--<div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>--}}
                                            {{--<div class="mail-contnet">--}}
                                                {{--<h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>--}}
                                        {{--</a>--}}
                                        {{--<!-- Message -->--}}
                                        {{--<a href="javascript:void(0)">--}}
                                            {{--<div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>--}}
                                            {{--<div class="mail-contnet">--}}
                                                {{--<h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>--}}
                                        {{--</a>--}}
                                        {{--<!-- Message -->--}}
                                        {{--<a href="javascript:void(0)">--}}
                                            {{--<div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>--}}
                                            {{--<div class="mail-contnet">--}}
                                                {{--<h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>--}}
                                        {{--</a>--}}
                                        {{--<!-- Message -->--}}
                                        {{--<a href="javascript:void(0)">--}}
                                            {{--<div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>--}}
                                            {{--<div class="mail-contnet">--}}
                                                {{--<h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    <!-- ============================================================== -->
                    <!-- End Comment -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Messages -->
                    <!-- ============================================================== -->
                    {{--<li class="nav-item dropdown">--}}
                        {{--<a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon-note"></i>--}}
                            {{--<div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">--}}
                            {{--<ul>--}}
                                {{--<li>--}}
                                    {{--<div class="drop-title">You have 4 new messages</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<div class="message-center">--}}
                                        {{--<!-- Message -->--}}
                                        {{--<a href="javascript:void(0)">--}}
                                            {{--<div class="user-img"> <img src="{{ asset('assets/images/users/1.jpg') }}" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>--}}
                                            {{--<div class="mail-contnet">--}}
                                                {{--<h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>--}}
                                        {{--</a>--}}
                                        {{--<!-- Message -->--}}
                                        {{--<a href="javascript:void(0)">--}}
                                            {{--<div class="user-img"> <img src="{{ asset('assets/images/users/2.jpg') }}" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>--}}
                                            {{--<div class="mail-contnet">--}}
                                                {{--<h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>--}}
                                        {{--</a>--}}
                                        {{--<!-- Message -->--}}
                                        {{--<a href="javascript:void(0)">--}}
                                            {{--<div class="user-img"> <img src="{{ asset('assets/images/users/3.jpg') }}" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>--}}
                                            {{--<div class="mail-contnet">--}}
                                                {{--<h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>--}}
                                        {{--</a>--}}
                                        {{--<!-- Message -->--}}
                                        {{--<a href="javascript:void(0)">--}}
                                            {{--<div class="user-img"> <img src="{{ asset('assets/images/users/4.jpg') }}" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>--}}
                                            {{--<div class="mail-contnet">--}}
                                                {{--<h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a class="nav-link text-center link" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    <!-- ============================================================== -->
                    <!-- End Messages -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- mega menu -->
                    <!-- ============================================================== -->
                    {{--<li class="nav-item dropdown mega-dropdown"> <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-layout-width-default"></i></a>--}}
                        {{--<div class="dropdown-menu animated bounceInDown">--}}
                            {{--<ul class="mega-dropdown-menu row">--}}
                                {{--<li class="col-lg-3 col-xlg-2 m-b-30">--}}
                                    {{--<h4 class="m-b-20">CAROUSEL</h4>--}}
                                    {{--<!-- CAROUSEL -->--}}
                                    {{--<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">--}}
                                        {{--<div class="carousel-inner" role="listbox">--}}
                                            {{--<div class="carousel-item active">--}}
                                                {{--<div class="container"> <img class="d-block img-fluid" src="{{ asset('assets/images/big/img1.jpg') }}" alt="First slide"></div>--}}
                                            {{--</div>--}}
                                            {{--<div class="carousel-item">--}}
                                                {{--<div class="container"><img class="d-block img-fluid" src="{{ asset('assets/images/big/img2.jpg') }}" alt="Second slide"></div>--}}
                                            {{--</div>--}}
                                            {{--<div class="carousel-item">--}}
                                                {{--<div class="container"><img class="d-block img-fluid" src="{{ asset('assets/images/big/img3.jpg') }}" alt="Third slide"></div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>--}}
                                        {{--<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>--}}
                                    {{--</div>--}}
                                    {{--<!-- End CAROUSEL -->--}}
                                {{--</li>--}}
                                {{--<li class="col-lg-3 m-b-30">--}}
                                    {{--<h4 class="m-b-20">ACCORDION</h4>--}}
                                    {{--<!-- Accordian -->--}}
                                    {{--<div class="accordion" id="accordionExample">--}}
                                        {{--<div class="card m-b-0">--}}
                                            {{--<div class="card-header bg-white p-0" id="headingOne">--}}
                                                {{--<h5 class="mb-0">--}}
                                                    {{--<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">--}}
                                                        {{--Collapsible Group Item #1--}}
                                                    {{--</button>--}}
                                                {{--</h5>--}}
                                            {{--</div>--}}

                                            {{--<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">--}}
                                                {{--<div class="card-body">--}}
                                                    {{--Anim pariatur cliche reprehenderit, enim eiusmod high.--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="card m-b-0">--}}
                                            {{--<div class="card-header bg-white p-0" id="headingTwo">--}}
                                                {{--<h5 class="mb-0">--}}
                                                    {{--<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"--}}
                                                            {{--aria-controls="collapseTwo">--}}
                                                        {{--Collapsible Group Item #2--}}
                                                    {{--</button>--}}
                                                {{--</h5>--}}
                                            {{--</div>--}}
                                            {{--<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">--}}
                                                {{--<div class="card-body">--}}
                                                    {{--Anim pariatur cliche reprehenderit, enim eiusmod high.--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="card m-b-0">--}}
                                            {{--<div class="card-header bg-white p-0" id="headingThree">--}}
                                                {{--<h5 class="mb-0">--}}
                                                    {{--<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"--}}
                                                            {{--aria-controls="collapseThree">--}}
                                                        {{--Collapsible Group Item #3--}}
                                                    {{--</button>--}}
                                                {{--</h5>--}}
                                            {{--</div>--}}
                                            {{--<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">--}}
                                                {{--<div class="card-body">--}}
                                                    {{--Anim pariatur cliche reprehenderit, enim eiusmod high.--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                                {{--<li class="col-lg-3  m-b-30">--}}
                                    {{--<h4 class="m-b-20">CONTACT US</h4>--}}
                                    {{--<!-- Contact -->--}}
                                    {{--<form>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<input type="text" class="form-control" id="exampleInputname1" placeholder="Enter Name"> </div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<input type="email" class="form-control" placeholder="Enter email"> </div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>--}}
                                        {{--</div>--}}
                                        {{--<button type="submit" class="btn btn-info">Submit</button>--}}
                                    {{--</form>--}}
                                {{--</li>--}}
                                {{--<li class="col-lg-3 col-xlg-4 m-b-30">--}}
                                    {{--<h4 class="m-b-20">List style</h4>--}}
                                    {{--<!-- List style -->--}}
                                    {{--<ul class="list-style-none">--}}
                                        {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> You can give link</a></li>--}}
                                        {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Give link</a></li>--}}
                                        {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another Give link</a></li>--}}
                                        {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Forth link</a></li>--}}
                                        {{--<li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another fifth link</a></li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    <!-- ============================================================== -->
                    <!-- End mega menu -->
                    <!-- ============================================================== -->
                    {{--<li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>--}}
                {{--</ul>--}}
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- User Profile-->
            <div class="user-profile">
                <div class="user-pro-body">
                    <div>
                        @if( \Illuminate\Support\Facades\Auth::user()->profile_image != "" )
                            <img src="{{ asset(\Illuminate\Support\Facades\Auth::user()->profile_image) }}" alt="user-img" class="img-circle">
                        @else
                            <img src="{{ asset('assets/images/users/2.jpg') }}" alt="user-img" class="img-circle">
                        @endif
                    </div>
                    <div class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ \Illuminate\Support\Facades\Auth::user()->name }} <span class="caret"></span></a>
                        <div class="dropdown-menu animated flipInY">
                            <!-- text-->
                            <a href="{{ route('user_unique_edit', base64_encode(\Illuminate\Support\Facades\Auth::user()->id)) }}" class="dropdown-item"><i class="ti-user"></i> Mi Perfil</a>
                            <!-- text-->
                            {{--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>--}}
                            <!-- text-->
                            {{--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>--}}
                            <!-- text-->
                            <div class="dropdown-divider"></div>
                            <!-- text-->
                            {{--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>--}}
                            <!-- text-->
                            {{--<div class="dropdown-divider"></div>--}}
                            <!-- text-->
                            <a href="{{ route('admin_logout') }}" class="dropdown-item"><i class="fas fa-power-off"></i> Salir</a>
                            <!-- text-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar navigation-->


            <nav class="sidebar-nav">
                <ul id="sidebarnav">

                    @foreach($menuItems['parents'] as $k => $item)

                        @if( $item->parent_as_child == 1 )

                            <li>
                                <a class="waves-effect waves-dark" href="{{ url('cms/dashboard').'/'.$item['url'] }}" aria-expanded="false">
                                    <i class="{{$item['icon']}}"></i>
                                    <span class="hide-menu">{{$item['name']}}</span>
                                </a>
                            </li>

                        @else

                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                    <i class="{{$item['icon']}}"></i>
                                    <span class="hide-menu">{{$item['name']}}</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">

                                    @foreach($menuItems[$item->id]['children'] as $ki => $i)
                                        @if($i['parent'] == $item['id'])
                                            <li><a href="{{ url('cms/dashboard').'/'.$i['url'] }}">{{ $i['name'] }}</a></li>
                                        @endif
                                    @endforeach

                                </ul>
                            </li>

                        @endif


                    @endforeach

                </ul>
            </nav>


            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">@yield("contentTitle")</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        {!! $breadcums !!}
                        @yield("topButton")
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->


            <!-- START CONTENT -->

            @yield("content_dashboard")

            <!-- FINISH CONTENT -->



            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            {{--<div class="right-sidebar">--}}
                {{--<div class="slimscrollright">--}}
                    {{--<div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>--}}
                    {{--<div class="r-panel-body">--}}
                        {{--<ul id="themecolors" class="m-t-20">--}}
                            {{--<li><b>With Light sidebar</b></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme">1</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme">4</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme">6</a></li>--}}
                            {{--<li class="d-block m-t-30"><b>With Dark sidebar</b></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme working">7</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>--}}
                            {{--<li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme ">12</a></li>--}}
                        {{--</ul>--}}
                        {{--<ul class="m-t-20 chatonline">--}}
                            {{--<li><b>Chat option</b></li>--}}
                            {{--<li>--}}
                                {{--<a href="javascript:void(0)"><img src="{{ asset('assets/images/users/1.jpg') }}" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="javascript:void(0)"><img src="{{ asset('assets/images/users/2.jpg') }}" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="javascript:void(0)"><img src="{{ asset('assets/images/users/3.jpg') }}" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="javascript:void(0)"><img src="{{ asset('assets/images/users/4.jpg') }}" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="javascript:void(0)"><img src="{{ asset('assets/images/users/5.jpg') }}" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="javascript:void(0)"><img src="{{ asset('assets/images/users/6.jpg') }}" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="javascript:void(0)"><img src="{{ asset('assets/images/users/7.jpg') }}" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="javascript:void(0)"><img src="{{ asset('assets/images/users/8.jpg') }}" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer">
        Engineered by <a href="https://xenotech.mx" target="_blank">Xenotech</a> © {{date('Y')}}
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap popper Core JavaScript -->
<script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ url('template/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>

<!--Wave Effects -->
<script src="{{ asset('template/dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ url('template/dist/js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ url('template/dist/js/custom.js') }}"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!--morris JavaScript -->
<script src="{{ asset('assets/node_modules/raphael/raphael-min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('assets/node_modules/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

{{ Html::script('system/js/pastora.js')  }}

@yield("JS")


<!-- Popup message jquery -->
<script src="{{ asset('assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>

<script src="{{ asset('assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
<!-- jQuery peity -->
<script src="{{ asset('assets/node_modules/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/peity/jquery.peity.init.js') }}"></script>

<script src="{{ asset('assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/sweetalert/jquery.sweet-alert.custom.js') }}"></script>

</body>

</html>