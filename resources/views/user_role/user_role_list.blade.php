
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="m-0">User Role List</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active">User Role List</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

    <!-- /.style s-->
    <style>
        #userRoleListTable th {
            text-align: center;
        }
        
        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-menu {
            min-width: 120px;
        }

        .dropdown-item {
            padding: 0.25rem 1rem;
        }

        .dropdown-item i {
            width: 1rem;
            text-align: center;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }




        .dropdown .btn.dropdown-toggle {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
        }

        .dropdown .btn.dropdown-toggle.btn-xs {
            padding: 3px 8px;
            font-size: 10px;
            border-radius: 4px;
        }

        .dropdown-menu {
            min-width: 120px;
            padding: 0;
            border-radius: 4px;
            border: none;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 10px 15px;
            font-size: 13px;
            transition: background-color 0.3s, color 0.3s;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #cacaca;
            color: white;
        }

        .dropdown-item + .dropdown-item {
            border-top: 1px solid #e9ecef;
        }



        /* Styling the table header */
        #userRoleListTable thead th {
            height: 25px;
            line-height: 30px;
            padding-top: 0;
            padding-bottom: 0;
            background-color: #4a5568;
            color: white;
            font-weight: bold;
            font-size: 80%;
            text-transform: uppercase;
        }

        .dataTables_wrapper .row:first-child {
            background-color: white;
            padding: 10px 0;
        }

        .dataTables_filter input[type="search"] {
            width: 250px;
            display: inline-block;
        }

        .dt-buttons .btn {
            margin-right: 5px;
        }
    </style>
    <!-- /.style e -->

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-12 table-responsive">
                        <table id="userRoleListTable" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>User Role</th>
                                    <th>Created By</th>
                                    <th>Updated By</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


