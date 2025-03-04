<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>POS | {{ $title }}</title>


    @foreach ($css as $path)
        <link href="{{ $path }}" rel="stylesheet">
    @endforeach

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    @foreach ($script as $path)
        <script src="{{ $path }}"></script>
    @endforeach

    <style>
        .content-wrapper,.main-footer{
            margin-left: 0 !important;
            width: 100% !important;
        }
    </style>

</head>
<body class="hold-transition">
    <div class="wrapper">

    <!-- Navbar -->
    <nav class="navbar navbar-success navbar-expand navbar-light">

        <ul class="navbar-nav">
            {{-- <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" id="pqushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li> --}}

            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">Logout</a>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="javascript:void(0);" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav">
            <button id="darkModeToggle" class="btn btn-outline-secondary ml-2">
                <i class="fas fa-moon"></i>
            </button>
        </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            @include($view)
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->


    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="">POS</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
        <b>POS</b>
        </div>
    </footer>

    </div>
<!-- ./wrapper -->

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->


    <script>

        function showAlert(title,msg,type) {
            Swal.fire({
            title: title,
            text: msg,
            icon: type,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
            })
        }

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const darkModeEnabled = localStorage.getItem('darkMode') === 'enabled';
            if (darkModeEnabled) {
                document.body.classList.add('dark-mode');
            }

            // Toggle dark mode
            const darkModeToggle = document.getElementById('darkModeToggle');
            darkModeToggle.addEventListener('click', function () {
                document.body.classList.toggle('dark-mode');

                if (document.body.classList.contains('dark-mode')) {
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                }
            });

        });
    </script>
</body>
</html>
