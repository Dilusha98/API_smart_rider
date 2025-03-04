<style>
    .categoryLogo{
        width: 35px;
        height: 35px;
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
    #categoryTbl thead th {
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

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="m-0">Categories</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Categories</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#categoryAddModal">Add New</button>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                    <table id="categoryTbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Logo</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name ?? ' - '}}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($category->description, 20, '...') }}</td>
                                    <td><img src="{{ asset('images/' . $category->image) }}" class="categoryLogo" alt=""></td>
                                    <td>
                                        @if ($category->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->createdBy ? ucfirst($category->createdBy->name) : ' - ' }}</td>
                                    <td class="text-center">
                                        <div class="dropdown open d-inline-block">
                                            <button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="actionDropdown{{ $category->id }}" data-toggle="dropdown">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" onclick="editCategory({{ $category->id }})"><i class="fas fa-edit mr-2"></i>Edit</a>
                                                <a class="dropdown-item" onclick="deleteCategory({{ $category->id }})"><i class="fas fa-trash mr-2"></i>Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                             @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            </div>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- category modals -->
@include('product.modals.categoryAddModal')
@include('product.modals.categoryEditModal')
