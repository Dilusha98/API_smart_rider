<!-- password reset Modal-->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="passowrdReset" aria-hidden="true" style="display: none;" id="passowrdResetMdl" name="passowrdResetMdl" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="mdi mdi-floppy me-1">&nbsp;</i>Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body py-2 px-4">
                <div class="row">
                    <div class="col-md-12">
                        <form id="passwordResetForm" enctype="multipart/form-data">
                            <input hidden type="text" id="hideUserId" name="hideUserId">
                            <!--Current passowrd -->
                            <div class="form-group">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" class="form-control form-control-sm" id="currentPassword" name="currentPassword" placeholder="Enter current password">
                                <span class="text-danger" id="currentPasswordError"></span>
                            </div>

                            <!--reset password -->
                            <div class="form-group">
                                <label for="newPassowrd">New Passowrd</label>
                                <input type="password" class="form-control form-control-sm" id="newPassowrd" name="newPassowrd" placeholder="Enter new password" maxlength="20">
                                <small id="newPassowrdCount" class="form-text text-muted">20 characters left</small>
                                <span class="text-danger" id="newPassowrdError"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="passwordResetForm" class="btn btn-primary" id="passwordConfirmBtn" name="passwordConfirmBtn">Confirm</button>
            </div>

        </div>
    </div>
</div>