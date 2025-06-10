    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h4 class="m-0">Dashboard</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <div class="container">

        <div class="container-fluid">
            <div class="row">

<div class="col-md-4">
    <div class="card bg-info">
        <div class="card-body">
            <h5 class="card-title">Total Users</h5>
            <p class="card-text">{{ $totalUsers }}</p>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card bg-success">
        <div class="card-body">
            <h5 class="card-title">Pending Driver Confirmations</h5>
            <p class="card-text">{{ $pendingDrivers }}</p>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card bg-warning">
        <div class="card-body">
            <h5 class="card-title">Total Rides</h5>
            <p class="card-text">{{ $weeklyRides }}</p>
        </div>
    </div>
</div>

            </div>
        </div>


      </div>
