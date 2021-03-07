<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <title>{{ trans('panel.site_title') }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Noty -->
    <link href="{{ asset('plugins/noty/noty.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />

    @yield('styles')
</head>

<body class="hold-transition accent-primary sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <img src="https://ui-avatars.com/api/?name={{ \Auth::user()->name }}&size=160&length=3&font-size=0.3&bold=true&background=001f3f&color=ffffff"
                            class="user-image img-circle elevation-2" alt="{{ \Auth::user()->name }}">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-success">
                            <img src="https://ui-avatars.com/api/?name={{ \Auth::user()->name }}&size=160&length=3&font-size=0.3&bold=true&background=001f3f&color=ffffff"
                                class="img-circle elevation-2" alt="{{ \Auth::user()->name }}">
                            <p>
                                {{ \Auth::user()->name }}
                                <small>{{ \Auth::user()->kelas }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer d-flex flex-wrap justify-content-between">
                            <a href="#" onclick="logout()" class="btn btn-default btn-flat mt-2">{{ trans('logout') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 ">
            <!-- Brand Logo -->
            {{-- <a href="{{ route('settings') }}" class="brand-link ">
                <img src="{{ asset('img/default-150x150.png') }}" alt="{{ trans('panel.site_title') }}" class="brand-image">
            </a> --}}
        
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://ui-avatars.com/api/?name={{ trans('panel.site_title') }}&size=160&length=3&font-size=0.3&bold=true&background=28a745&color=ffffff"
                            class="img-circle elevation-1" alt="{{ \Auth::user()->name }}">
                    </div>
                    <div class="info dropdown">
                        <a href="#" class="d-block">{{ trans('panel.site_title') }}</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('settings') }}" class="nav-link {{ request()->is('settings') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-gear"></i>
                                <p>{{ trans('global.settings') }}</p>
                            </a>
                        </li>
                        @if(\Auth::user()->is_admin)
                            <li class="nav-item">
                                <a href="{{ route('soal.index') }}" class="nav-link {{ request()->is('soal') || request()->is('soal/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-gear"></i>
                                    <p>Soal</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->is('siswa') || request()->is('siswa/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-gear"></i>
                                    <p>Hasil Tes Siswa</p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('tes') }}" class="nav-link {{ request()->is('tes') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-gear"></i>
                                    <p>Tes</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>

                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    @yield('content_header')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @if (session('message'))
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            </div>
                        </div>
                    @endif
                    @if ($errors->count() > 0)
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="alert alert-danger">
                                    <ul class="list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            {{-- <strong>Copyright © 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.5
            </div> --}}
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Noty -->
	<script type="text/javascript" src="{{ asset('plugins/noty/noty.min.js') }}"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/i18n/'.str_replace('_', '-', app()->getLocale()).'.js') }}"></script>

    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <!-- jQuery LoadingOverlay -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <!-- Ekko Lightbox -->
    <script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script src="{{ asset('js/main.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('js/adminlte.js') }}"></script>
    
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>

    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <script>
        // "use strict";
        window._token = $('meta[name="csrf-token"]').attr('content')
        
        //Noty.setMaxVisible(5) //global queue's max visible amount (default is 5)
        Noty.setMaxVisible(5, 'bottomRight')
        // Set default options

        Noty.overrideDefaults({
            layout: 'topRight',
            theme: 'nest',
            closeWith: ['click'],
            timeout: 10000,
            force: true,
            animation: {
                //        open: mojsOpenExample,
                //        close: mojsCloseExample
            }
        })
        $(function () {
            // hold onto the drop down menu                                             
            var dropdownMenu;

            // and when you show it, move it to the body                                     
            $(window).on('show.bs.dropdown', function (e) {
                if($(e.target).parent().is('td')){
                    // grab the menu        
                    dropdownMenu = $(e.target).find('.dropdown-menu');
                    // detach it and append it to the body
                    $('body').append(dropdownMenu.detach());
        
                    // grab the new offset position
                    var eOffset = $(e.target).offset();
        
                    // make sure to place it where it would normally go (this could be improved)
                    dropdownMenu.css({
                        'display': 'block',
                            'top': eOffset.top + $(e.target).outerHeight(),
                            'left': eOffset.left
                    });
                }
            });

            // and when you hide it, reattach the drop down, and hide it normally                                                   
            $(window).on('hide.bs.dropdown', function (e) {
                if($(e.target).parent().is('td')){
                    $(e.target).append(dropdownMenu.detach());
                    dropdownMenu.hide();
                }
            });
        });

        $(function() {

            $('[data-toggle="tooltip"]').tooltip()

            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });
        });

    </script>
    @stack('scripts')

</body>

</html>
