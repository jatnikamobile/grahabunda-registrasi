<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title> @yield('title') </title>

    <link rel="icon" href="/template/images/thumb/logo-grahabunda.png" type="image/ico" />

   <!-- bootstrap & fontawesome -->
   <link rel="stylesheet" href="/template/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/template/font-awesome/4.5.0/css/font-awesome.min.css" />
    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="/template/css/fonts.googleapis.com.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="/template/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="/template/css/ace-skins.min.css" />
    <link rel="stylesheet" href="/template/css/ace-rtl.min.css" />

    <!-- Select2 -->
    <link href="/template/select2/css/select2.css" rel="stylesheet">

    <!-- inline styles related to this page -->
    <link rel="stylesheet" href="/template/css/jquery-ui.custom.min.css" />
    <link rel="stylesheet" href="/template/css/chosen.min.css" />
    <link rel="stylesheet" href="/template/bootstrap-datepicker/css/datepicker.css') ?>" />
    <link rel="stylesheet" href="/template/css/bootstrap-timepicker.min.css" />
    <link rel="stylesheet" href="/template/css/daterangepicker.min.css" />
    <link rel="stylesheet" href="/template/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="/template/css/bootstrap-colorpicker.min.css" />
    <link rel="stylesheet" href="/template/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/template/datatables/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/css/palette.css">
    <link rel="stylesheet" href="/template/SweetAlert/sweetalert2.min.css">
    <link rel="stylesheet" href="/template/print/printArea.css">
    <link rel="stylesheet" href="/css/select2-fix.css">
    <!-- High Chart -->
    <link href="/template/highchart/code/css/highcharts.css" rel="stylesheet" />
    <script src="/template/jquery.min.js"></script>
    <script src="/js/axios.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }
            });
        });
    </script>
  </head>

   <body class="no-skin">
        <div id="navbar" class="navbar navbar-default navbar-fixed-top" style=" background-color: #0A9A06;">
            <div class="navbar-container" id="navbar-container">
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small><!-- <i class="fa fa-laptop"></i> --><img src="/template/images/thumb/logo-grahabunda.png" width="25px">&nbsp; Modul Registrasi</small>
                    </a>
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('reg-bpjs-daftar.form') }}"><i class="menu-icon fa fa-list-alt"></i>&nbsp; Daftar BPJS</a></li>
                        <li><a href="{{ route('reg-umum-daftar.form') }}"><i class="menu-icon fa fa-list-alt"></i>&nbsp; Daftar Umum</a></li>
                        <li><a href="{{ route('register-perjanjian') }}"><i class="fa fa-users"></i>&nbsp;List Perjanjian</a></li>
                        <li><a href="{{ route('register-mcu') }}"><i class="fa fa-user"></i>&nbsp;MCU</a></li>
                        <li><a href="{{ route('register') }}"><i class="fa fa-book"></i>&nbsp; Registrasi Harian</a></li>
                        <!-- <li><a href="{{ route('antrian-lama') }}"><i class="fa fa-book"></i>&nbsp; Antrian Aplikasi lama</a></li> -->
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" fa fa-circle-o"></i>
                                Admission&nbsp;
                                <i class="ace-icon fa fa-angle-down bigger-110"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-light-blue dropdown-caret">
                                <li><a href="{{ route('reg-umum-mutasi.form') }}"><i class="ace-icon fa fa-circle bigger-110 blue"></i>Mutasi Pasien Umum</a></li>
                                <li><a href="{{ route('reg-bpjs-mutasi.form') }}"><i class="ace-icon fa fa-circle bigger-110 blue"></i>Mutasi Pasien BPJS</a></li>
                            </ul>
                        </li>
                        <li><a href="http://192.168.136.252:81/new/perjanjian"><i class="fa fa-check"></i>Input Perjanjian</a></li>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" fa fa-circle-o"></i>
                                Penunjang&nbsp;
                                <i class="ace-icon fa fa-angle-down bigger-110"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-light-blue dropdown-caret">
                                <li><a href="http://192.168.136.252:81/microbiologi/registrasi/index_reg" target="_blank"><i class="ace-icon fa fa-circle bigger-110 blue"></i>Mikrobiologi</a></li>
                                <li><a href="http://192.168.136.252:81/rsau-lab/registrasi/index" target="_blank"><i class="ace-icon fa fa-circle bigger-110 blue"></i>Laboratorium</a></li>
                                <!-- <li><a href="http://192.168.136.252:81/rsau-rad" target="_blank"><i class="ace-icon fa fa-circle bigger-110 blue"></i>Radiologi</a></li> -->
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('rubah-kategori') }}"><i class="menu-icon fa fa-list"></i>Rubah Kategori</a>
                        </li>
                        <li>
                            <a href="{{ route('rubah-dokter') }}"><i class="menu-icon fa fa-stethoscope"></i>Rubah Dokter</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="light-blue dropdown-modal" style="background-color: #0A9A06;">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background-color: #0A9A06;">Halo, {{ Auth::user()->DisplayName == '' ? Auth::user()->NamaUser : Auth::user()->DisplayName }} &nbsp;
                                <!-- <img class="nav-user-photo" src="assets/images/avatars/user.jpg" alt="Jason's Photo" /> -->
                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>
                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li><a href="{{ route('change_password') }}"><i class="ace-icon fa fa-user"></i>Ganti Password</a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!-- /.navbar-container -->
        </div>
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try{ace.settings.loadState('main-container')}catch(e){}
            </script>
            <!--  -->
            @include('layouts.sidebar')
            <!--  -->
            <div class="main-content">
                <div class="main-content-inner">
                    <div class="page-content" style="background-image: url(/template/images/bg.jpeg); background-size: cover;">
                        <div class="page-header">
                            <h1>
                                @yield('header')
                                @yield('subheader')
                                <!-- <small>
                                @if(isset($sub_header) && $sub_header != '')
                                    <i class="ace-icon fa fa-angle-double-right"></i>
                                    {{$sub_header}}	
                                @endif
                                </small> -->
                            </h1>
                        </div><!-- /.page-header -->
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                @yield('content')
                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->
            <!--  -->
            <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder"><!-- <i class="fa fa-laptop"></i> --><img src="/template/images/thumb/logo-grahabunda.png" width="25px">&nbsp;Modul Registrasi 1.0</span> MK Medika| RSU Graha Bunda &copy;<?=date('Y')?>
                        </span>
                        &nbsp; &nbsp;
                        <!-- <span class="action-buttons">
                            <a href="#"><i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i></a>
                            <a href="#"><i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i></a>
                            <a href="#"><i class="ace-icon fa fa-rss-square orange bigger-150"></i></a>
                        </span> -->
                    </div>
                </div>
            </div>
            <!-- <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a> -->
        </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!-- <![endif]-->

    <!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
    <!-- jQuery -->
    <!-- Print Element -->
    <script src="/js/PrintEl/jquery.printElement.js"></script>
    <!-- Select2 -->
    <script src="/template/select2/js/select2.min.js"></script>
    <!-- ace scripts -->
    <script src="/template/js/ace-elements.min.js"></script>
    <script src="/template/js/ace-extra.min.js"></script>
    <script src="/template/js/ace.min.js"></script>

    <!-- High Chart -->
    <script src="/template/highchart/code/js/highcharts.js"></script>
    <script src="/template/highchart/code/highcharts.js"></script>
    <script src="/template/highchart/code/modules/exporting.js"></script>
    <script src="/template/highchart/code/modules/export-data.js"></script>
    <!-- page specific plugin scripts -->
    <script src="/template/js/bootstrap.min.js"></script>
    <script src="/template/js/jquery-ui.min.js"></script>
    <script src="/template/js/jquery-ui.custom.min.js"></script>
    <script src="/template/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/template/js/autosize.min.js"></script>
    <script src="/template/js/jquery.maskedinput.min.js"></script>
    <script src="/template/js/bootstrap-tag.min.js"></script>
    <script src="/template/js/jquery.validate.min.js"></script>
    <script src="/template/js/jquery-additional-methods.min.js"></script>
    <script src="/template/js/bootbox.js"></script>
    <script src="/template/js/jquery.blockUI.js"></script>
    <script src="/template/SweetAlert/sweetalert.min.js"></script>
    
    <script src="/template/webcamjs/webcam.min.js"></script>
    <script src="/template/print/jquery.printArea.js"></script>
    <script src="/template/print/printThis.js"></script>
    <script src="/template/bootstrap-datepicker/js/bootstrap-datepicker.js') ?>"></script>


    <script type="text/javascript" src="/template/datatables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/template/datatables/js/dataTables.bootstrap.min.js"></script>
    
    <script src="/template/chart.js/Chart.js') ?>"></script>
    <script src="/js/inputmask/inputmask.min.js') ?>"></script>
    <script src="/js/inputmask/jquery.inputmask.min.js') ?>"></script>
    <script src="/js/inputmask/bindings/inputmask.binding.js') ?>"></script>
    <script type="text/javascript">        
        //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
        //so disable dragging when clicking on label
        var agent = navigator.userAgent.toLowerCase();
        if(ace.vars['touch'] && ace.vars['android']) {
            $('#tasks').on('touchstart', function(e){
            var li = $(e.target).closest('#tasks li');
            if(li.length == 0)return;
            var label = li.find('label.inline').get(0);
            if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
            });
        }
        var url = '/template/js/jquery.mobile.custom.min.js';
        if('ontouchstart' in document.documentElement) document.write("<script src="+url+">"+"<"+"/script>");

        $(document).ready(function(){
            $.ajaxSetup({
                headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }
            });
        });
        if('ontouchstart' in document.documentElement) document.write("<script src='./template/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <!-- inline scripts related to this page -->
    @yield('script')

        <!-- page specific plugin scripts -->

        <!-- ace scripts -->
        <!-- <script src="assets/js/ace-elements.min.js"></script>
        <script src="assets/js/ace.min.js"></script> -->

        <!-- inline scripts related to this page -->
    </body>
</html>