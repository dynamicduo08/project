<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Megason Diagnostic Clinic</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
        <style>
            .date_input input[type="date"]::-webkit-calendar-picker-indicator {
                background: transparent;
                bottom: 0;
                color: transparent;
                /* cursor: pointer; */
                height: auto;
                left: 0;
                position: absolute;
                right: 0;
                top: 0;
                width: auto;
            }
            .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('/images/3.gif')}}") 50% 50% no-repeat rgb(249,249,249) ;
            opacity: .8;
            background-size:200px 120px;
        }
        .space 
        {
            white-space: pre;
        }
        </style>

    </head>
    <body class="sb-nav-fixed">
        <div id = "myDiv" style="display:none;" class="loader">
        </div>
        @include('sweetalert::alert')
        @include('layouts.dashboard.navbar')


        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
               
                @include('layouts/dashboard.sidenav')
            </div>

            <div id="layoutSidenav_content">
                @yield('content')
            </div>


        </div>
        <script type='text/javascript'>
            function show()
            {
                document.getElementById("myDiv").style.display="block";
            }
        </script>
        <script src="{{ asset('js/app.js') }}"></script>        
        <script src="{{ asset('js/dependencies.js') }}"></script>
        <script src="{{ asset('js/jquery.js') }}"></script> 
        <script src="{{ asset('js/bootstrap.js') }}"></script> 
        <script src="{{ asset('js/scripts.js') }}"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> --}}
        {{-- <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script> --}}
        
        {{-- <script src="{{ asset('js/jquery.datatables.min.js') }}"></script>
        <script src="{{ asset('js/datatables.bootstrap4.min.js') }}"></script> --}}
        
        

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/sp-1.3.0/datatables.min.css"/>
 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/sp-1.3.0/datatables.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script src="{{ asset('assets/demo/datatables-demo.js') }}"></script> --}}
        <script type="text/javascript">
        
        $(function() {
            $('#dataTable').DataTable({
                dom: 'fBrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],

            });

            $('.multiselect').select2();
        });
        </script>
    </body>
</html>
