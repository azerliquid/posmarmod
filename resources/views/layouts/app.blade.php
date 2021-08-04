<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <title>Martabak Modern</title>

        <meta http-equiv="Content-Type" content="tex    t/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('gentelella-master') }}/production/images/favicon.ico" type="image/ico" />

        <!-- <title>Gentelella Alela! | </title> -->

        <!-- Bootstrap -->
        <link  href="{{ asset('gentelella-master') }}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link  href="{{ asset('gentelella-master') }}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link  href="{{ asset('gentelella-master') }}/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link  href="{{ asset('gentelella-master') }}/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        
        <!-- bootstrap-progressbar -->
        <link  href="{{ asset('gentelella-master') }}/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <!-- JQVMap -->
        <link  href="{{ asset('gentelella-master') }}/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link  href="{{ asset('gentelella-master') }}/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link  href="{{ asset('gentelella-master') }}/build/css/custom.min.css" rel="stylesheet">

        <!-- Datatables -->
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

        <!-- sweetalert -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>




        <!-- <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->

    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @if(Auth::user()->role == 'admin')
                    @include('admin.layouts.sidebar')
                @else
                    @include('kasir.layouts.sidebar')
                @endif
                @include('layouts.admin.topnav')
                @include('sweetalert::alert')
                @yield('content')
                @include('layouts.admin.footer')
            </div>
        </div>
        <!-- jQuery -->
        <script src="{{ asset('gentelella-master') }}/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('gentelella-master') }}/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- FastClick -->
        <script src="{{ asset('gentelella-master') }}/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="{{ asset('gentelella-master') }}/vendors/nprogress/nprogress.js"></script>
        <!-- Chart.js -->
        <script src="{{ asset('gentelella-master') }}/vendors/Chart.js/dist/Chart.min.js"></script>
        <!-- gauge.js -->
        <script src="{{ asset('gentelella-master') }}/vendors/gauge.js/dist/gauge.min.js"></script>
        <!-- bootstrap-progressbar -->
        <script src="{{ asset('gentelella-master') }}/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <!-- iCheck -->
        <script src="{{ asset('gentelella-master') }}/vendors/iCheck/icheck.min.js"></script>
        <!-- Skycons -->
        <script src="{{ asset('gentelella-master') }}/vendors/skycons/skycons.js"></script>
        <!-- Flot -->
        <script src="{{ asset('gentelella-master') }}/vendors/Flot/jquery.flot.js"></script>
        <script src="{{ asset('gentelella-master') }}/vendors/Flot/jquery.flot.pie.js"></script>
        <script src="{{ asset('gentelella-master') }}/vendors/Flot/jquery.flot.time.js"></script>
        <script src="{{ asset('gentelella-master') }}/vendors/Flot/jquery.flot.stack.js"></script>
        <script src="{{ asset('gentelella-master') }}/vendors/Flot/jquery.flot.resize.js"></script>
        <!-- Flot plugins -->
        <script src="{{ asset('gentelella-master') }}/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
        <script src="{{ asset('gentelella-master') }}/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
        <script src="{{ asset('gentelella-master') }}/vendors/flot.curvedlines/curvedLines.js"></script>
        <!-- DateJS -->
        <script src="{{ asset('gentelella-master') }}/vendors/DateJS/build/date.js"></script>
        <!-- JQVMap -->
        <script src="{{ asset('gentelella-master') }}/vendors/jqvmap/dist/jquery.vmap.js"></script>
        <script src="{{ asset('gentelella-master') }}/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
        <script src="{{ asset('gentelella-master') }}/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="{{ asset('gentelella-master') }}/vendors/moment/min/moment.min.js"></script>
        <script src="{{ asset('gentelella-master') }}/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="{{ asset('gentelella-master') }}/build/js/custom.min.js"></script>

        
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
        <!-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script> -->
        


        @yield('modals')
    </body>
</html>
