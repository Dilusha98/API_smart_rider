<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Smart Ride | {{ $title }}</title>


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
        .error {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        .btn-primary {
            background-color: #3F51B5 !important;
            border-color: #3F51B5 !important;
            border-radius: 0 !important;
            color: white !important;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2C3D99 !important;
            border-color: #2C3D99 !important;
            color: white !important;
        }

        .btn-primary:active, .btn-primary:focus {
            background-color: #1F2C6D !important;
            border-color: #1F2C6D !important;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            border-radius: 12px;
        }

        /* Warning badge */
        .badge-warning {
            background-color: #FFCC80;
            color: #8C5100;
            border: 1px solid #FFB74D;
        }

        .badge-warning:hover {
            background-color: #FFB74D;
        }

        /* Success badge */
        .badge-success {
            background-color: #A5D6A7;
            color: #2E7D32;
            border: 1px solid #81C784;
        }

        .badge-success:hover {
            background-color: #81C784;
        }

        /* Danger badge */
        .badge-danger {
            background-color: #EF9A9A;
            color: #C62828;
            border: 1px solid #E57373;
        }

        .badge-danger:hover {
            background-color: #E57373;
        }
    </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="200" width="300">
  </div> --}}

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Home</a>
      </li> --}}
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">Logout</a>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        {{-- <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a> --}}
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        {{-- <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a> --}}
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Smart Ride</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <?php
          $permission_titles = session('permissions');
        ?>

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/logo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Dashboard</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <?php
                $product_permissions = array(
                    'brand_list',
                    'category_list',
                    'category_list',
                    'add_new_product',
                    'add_product_attributes',
                );

                $user_permissions = array(
                    'user',
                    'create_user_role',
                    'assign_permissions',
                    'user_role_list',
                    'create_user',
                    'edit_user',
                    'verify_app_user',
                    'verify_vehicle',
                    'ride_offers',
                    'ride_requests',
                );

                $pos_permissions = array(
                    'accesspos',
                );
           ?>

           @if (!empty(array_intersect( $permission_titles, $pos_permissions)))

           <li class="nav-item">
            <a href="/pos" class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>POS</p>
            </a>
          </li>

           @endif

            @if (!empty(array_intersect( $permission_titles, $product_permissions)))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-dolly"></i>
                        <p>
                        Product
                        <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (in_array('add_new_product',$permission_titles))
                            <li class="nav-item">
                                <a href="/add-new-product" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Product</p>
                                </a>
                        </li>
                        @endif
                        @if (in_array('add_product_attributes',$permission_titles))
                            <li class="nav-item">
                                <a href="/add-product-attributes" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product Attributes</p>
                                </a>
                        </li>
                        @endif
                        @if (in_array('category_list',$permission_titles))
                            <li class="nav-item">
                                <a href="/categories" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category</p>
                                </a>
                           </li>
                        @endif
                        @if (in_array('brand_list',$permission_titles))
                            <li class="nav-item">
                                <a href="/brand" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Brand</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


            {{-- ride share --}}

            @if (!empty(array_intersect($permission_titles, $user_permissions)))

            <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-car"></i>
                  <p>
                      Rides
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                    @if (in_array('ride_offers',$permission_titles))
                        <li class="nav-item">
                        <a href="/ride-offers" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ride Offers</p>
                        </a>
                        </li>
                    @endif

                    @if (in_array('ride_requests',$permission_titles))
                        <li class="nav-item">
                        <a href="/ride-requests" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ride Requests</p>
                        </a>
                        </li>
                    @endif

                    @if (in_array('verify_app_user',$permission_titles))
                        <li class="nav-item">
                        <a href="/verify-app-users" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Verify App Users</p>
                        </a>
                        </li>
                    @endif

                    @if (in_array('verify_vehicle',$permission_titles))
                        <li class="nav-item">
                        <a href="/verify-vehicles" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Verify Vehicles</p>
                        </a>
                        </li>
                    @endif

                </ul>
              </li>

            @endif



          {{-- user role section start --}}
          @if (!empty(array_intersect($permission_titles, $user_permissions)))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    User
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                @if (in_array('create_user',$permission_titles))
                  <li class="nav-item">
                    <a href="/CreateUser" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Create User</p>
                    </a>
                  </li>
                @endif

                @if (in_array('user_list',$permission_titles))
                  <li class="nav-item">
                    <a href="/UserList" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>User List</p>
                    </a>
                  </li>
                @endif

                @if (in_array('create_user_role',$permission_titles))
                  <li class="nav-item">
                    <a href="/UserRole" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Create User Role</p>
                    </a>
                  </li>
                @endif

                @if (in_array('user_role_list',$permission_titles))
                  <li class="nav-item">
                    <a href="/UserRoleList" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>User Role List</p>
                    </a>
                  </li>
                @endif


              </ul>
            </li>
          @endif

            </ul>
          </li>

        </nav>
          {{-- user role section end --}}
  </aside>

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
    <strong>Copyright &copy; 2024 <a href="">Smart Ride</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Dilusha Senevirathna ( 2500855 )</b>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
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


    @if(Session::has('success'))
        <script>
            $( document ).ready(function() {
                showAlert('Success!','{{Session::get("success")}}','success');
            });
        </script>
    @endif

    @if(Session::has('error'))
        <script>
            $( document ).ready(function() {
                showAlert('Ooops!','{{Session::get("error")}}','error');
            });
        </script>
    @endif

    <script>

        /*function showAlert(title,message,type) {
          console.log(title,message,type);
            Swal.fire({
            title: title,
            text: message,
            icon: type,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
            })
        }*/


        $(document).ready(function() {
            var url = window.location;
            // for sidebar menu entirely but not cover treeview
            $('ul.nav-sidebar a').filter(function() {
                if (this.href) {
                    return this.href == url || url.href.indexOf(this.href) == 0;
                }
            }).addClass('active');

            // for the treeview
            $('ul.nav-treeview a').filter(function() {
                if (this.href) {
                    return this.href == url || url.href.indexOf(this.href) == 0;
                }
            }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
        });



        function showAlert(title, message, type, errorId = null) {
            let alertConfig = {
                title: title,
                text: message,
                icon: type,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            };

            if (errorId) {
                alertConfig.footer = `<p>Error Code (ID: ${errorId})</p>`;
            }

            Swal.fire(alertConfig);
        }

        function reportError(errorId) {
            console.log('Reporting error:', errorId);
            // Implement your error reporting logic here
            // For example, you could open a new window with a pre-filled error report form
            window.open(`/report-error?id=${errorId}`, '_blank');
        }

        function handleResponse(response) {
          if (response.success) {
              showAlert(response.title, response.message, 'success', response.errorId);
          } else {
              showAlert(response.title, response.message, 'error', response.errorId);
          }
      }

    </script>
</body>
</html>
