<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0">User Create</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">User</a></li>
                    <li class="breadcrumb-item active">User Create</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->




<!-- container -->
<div class="container-fluid">
    {{-- container --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Basic Info</span></h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <form id="userCreateForm" enctype="multipart/form-data">
                <div class="form-group">
                    <input hidden type="text" class="form-control form-control-sm" id="userId" name="userId" value="0">
                </div>
                <div class="row">
                    {{-- first section --}}
                    <div class="col-12 col-md-5">
                        {{-- first name --}}
                        <div class="form-group">
                            <label for="firatName">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="firatName" name="firatName" placeholder="Enter first name" maxlength="50">
                            <small id="firatNamecharCount" class="form-text text-muted">50 characters left</small>
                            <span class="text-danger" id="firatNameError"></span>
                        </div>

                        {{-- phone number --}}
                        <div class="form-group">
                            <label for="phoneNo">Phone Number</label>
                            <input type="text" class="form-control form-control-sm" id="phoneNo" name="phoneNo" placeholder="Enter phone number">
                            <span class="text-danger" id="phoneNoError"></span>
                        </div>


                        {{-- user name --}}
                        <div class="form-group">
                            <label for="userName">User Name</label>
                            <input type="text" class="form-control form-control-sm" id="userName" name="userName" placeholder="Enter user name" maxlength="50">
                            <small id="userNameCount" class="form-text text-muted">50 characters left</small>
                            <span class="text-danger" id="userNameError"></span>
                        </div>

                        {{-- dob --}}
                        <div class="form-group">
                            <label for="dob">Date of birth</label>
                            <input type="date" class="form-control form-control-sm" id="dob" name="dob">
                            <span class="text-danger" id="dobError"></span>
                        </div>

                        {{-- address --}}
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control form-control-sm" id="address" name="address" placeholder="Enter address" maxlength="200" rows="3"></textarea>
                            <small id="addressCount" class="form-text text-muted">200 characters left</small>
                            <span class="text-danger" id="addressError"></span>
                        </div>
                    </div>

                    <div class="col-12 col-md-1"></div>

                    {{-- 2nd section --}}
                    <div class="col-12 col-md-5">
                        {{-- last name --}}
                        <div class="form-group">
                            <label for="LastName">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="LastName" name="LastName" placeholder="Enter last name" maxlength="50">
                            <small id="lastNamecharCount" class="form-text text-muted">50 characters left</small>
                            <span class="text-danger" id="lastNameError"></span>
                        </div>

                        {{-- email --}}
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="email" class="form-control form-control-sm" id="userEmail" name="userEmail" placeholder="Enter e-mail" maxlength="50">
                            <small id="userEmailCount" class="form-text text-muted">50 characters left</small>
                            <span class="text-danger" id="userEmailError"></span>
                        </div>

                        {{-- password --}}
                        <div class="form-group">
                            <label for="userEmail">Password</label>
                            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter password" maxlength="20">
                            <small id="passwordCount" class="form-text text-muted">20 characters left</small>
                            <span class="text-danger" id="passwordError"></span>
                        </div>


                        {{-- user role --}}
                        <div class="form-group">
                            <label for="userRole">User Role</label>
                            <select class="form-control form-control-sm selectpicker" data-size="5" id="userRole" name="userRole">
                                <option value=""></option>
                                @if (!empty($userRoleData))
                                    @foreach ($userRoleData as $itm)
                                        <option value="{{ $itm->id }}">{{ $itm->title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="userRoleError"></span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Card Footer --}}
        <div class="card-footer text-right">
            <button type="submit" form="userCreateForm" id="userSbmitBtn" name="userSbmitBtn" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
<!-- /.container -->







