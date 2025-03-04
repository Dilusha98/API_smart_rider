{{-- css --}}
<link href="{{ asset('plugins/mohithg-switchery/mohithg-switchery.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Content Header (Page header) -->
<div class="content-header">
   
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0">User Edit</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">User</a></li>
                    <li class="breadcrumb-item active">User Edit</li>
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

        <form id="userEditForm" action="/UpdateUser" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <input hidden type="text" class="form-control form-control-sm" id="userId" name="userId" value="{{ $editData[0]['id'] }}">
                </div>
                <div class="row">
                    {{-- first section --}}
                    <div class="col-12 col-md-5">
                        {{-- first name --}}
                        <div class="form-group">
                            <label for="firatName">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="firatName" name="firatName" placeholder="Enter first name" maxlength="50" value="{{ $editData[0]['name'] }}">
                            <small id="firatNamecharCount" class="form-text text-muted">50 characters left</small>
                            <span class="text-danger" id="firatNameError"></span>
                        </div>

                        {{-- phone number --}}
                        <div class="form-group">
                            <label for="phoneNo">Phone Number</label>
                            <input type="text" class="form-control form-control-sm" id="phoneNo" name="phoneNo" placeholder="Enter phone number" value="{{ $editData[0]['phone'] }}">
                            <span class="text-danger" id="phoneNoError"></span>
                        </div>


                        {{-- user name --}}
                        <div class="form-group">
                            <label for="userName">User Name</label>
                            <input type="text" class="form-control form-control-sm" id="userName" name="userName" placeholder="Enter user name" maxlength="50" value="{{ $editData[0]['username'] }}">
                            <small id="userNameCount" class="form-text text-muted">50 characters left</small>
                            <span class="text-danger" id="userNameError"></span>
                        </div>

                        {{-- dob --}}
                        <div class="form-group">
                            <label for="dob">Date of birth</label>
                            <input type="date" class="form-control form-control-sm" id="dob" name="dob" value="{{ $editData[0]['dob'] }}">
                            <span class="text-danger" id="dobError"></span>
                        </div>

                        {{-- address --}}
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control form-control-sm" id="address" name="address" placeholder="Enter address" maxlength="200" rows="3">{{ $editData[0]['address']}}</textarea>
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
                            <input type="text" class="form-control form-control-sm" id="LastName" name="LastName" placeholder="Enter last name" maxlength="50" value="{{ $editData[0]['last_name'] }}">
                            <small id="lastNamecharCount" class="form-text text-muted">50 characters left</small>
                            <span class="text-danger" id="lastNameError"></span>
                        </div>

                        {{-- email --}}
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="email" class="form-control form-control-sm" id="userEmail" name="userEmail" placeholder="Enter e-mail" maxlength="50" value="{{ $editData[0]['email'] }}">
                            <small id="userEmailCount" class="form-text text-muted">50 characters left</small>
                            <span class="text-danger" id="userEmailError"></span>
                        </div>

                        {{-- password --}}
                        <div class="form-group">
                            <label for="userEmail">Password</label>
                            <div class="input-group" id="tooltip-container">
                                <a type="button" class="btn btn-sm btn-success waves-effect waves-light grp" id="resetPaswordBtn" name="resetPaswordBtn" data-toggle="modal" data-target="#passowrdResetMdl">Reset Password</a>
                            </div>
                        </div>

                        {{-- user role --}}
                        <div class="form-group">
                            <label for="userRole">User Role</label>
                            <select class="form-control form-control-sm selectpicker" data-size="5" id="userRole" name="userRole">
                                <option value=""></option>
                                @if (!empty($userRoleData))
                                    @foreach ($userRoleData as $itm)
                                        <option value="{{ $itm->id }}" {{ $editData[0]['user_role'] == $itm->id ? 'selected' : '' }}>{{ $itm->title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="userRoleError"></span>
                        </div>

                        {{-- user status --}}
                        <div class="form-group">
                            <label for="userStatus">User Status</label>
                            <div class="switchery-demo">
                            </div>
                            <input hidden class="form-control form-control-sm" type="text" id="stus" name="stus" value="">     
                        </div>

                    </div>
                </div>
            </div>

            {{-- Card Footer --}}
            <div class="card-footer text-right">
                <button type="submit" id="userUpdateSbmitBtn" name="userUpdateSbmitBtn" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- /.container -->
<!-- brand add modal -->
@include('user_role.models.password_reset_model')

{{-- plug script --}}
<script src="{{ asset('plugins/mohithg-switchery/mohithg-switchery.min.js') }}"></script>
<script type="text/javascript">
   
    //get edit data
    var editData = JSON.parse('@json($editData)');
    var userId = editData[0].id;

    //set ststus element
    $(".switchery-demo").html(
            `<input type="checkbox" id='stschk${userId}' onchange="changeState(${userId})" name="stschk" value=""  data-switchery="true" data-plugin="switchery" class="js-switchery stschk" />  `
    );


    //set edit data
    if(editData[0].status === 1){
        $("#stus").val("1");
    }else{
        $("#stus").val("0");
    }

    //set stasus
    editData[0].status === 1
            ? $("#stschk" + userId).attr("checked", true)
            : $("#stschk" + userId).removeAttr("checked");
        var elem = document.querySelector("#stschk" + userId);
        new Switchery(elem, { secondaryColor: "#dc3545", size: "small" });



    //state change function when onchange toggle
    function changeState(event) {
        if ($(`#stschk${event}`).is(":checked")) {
            $("#stus").val("1");
        } else {
            $("#stus").val("0");
        }
    }

    //set user id
    $('#hideUserId').val(userId);
</script>









