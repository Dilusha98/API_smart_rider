<div class="modal fade" id="brandAddModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Brand</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="brandForm" enctype="multipart/form-data">
                    <!-- Brand Name -->
                    <div class="form-group">
                        <label for="brandName">Brand Name</label>
                        <input type="text" class="form-control" id="brandName" name="name" placeholder="Enter brand name">
                        <span class="text-danger" id="nameError"></span>
                    </div>

                    <!-- Brand Logo -->
                    <div class="form-group">
                        <label for="brandLogo">Brand Logo</label>
                        <input type="file" class="form-control dropify" id="brandLogo" name="logo" data-allowed-file-extensions='["jpg", "png"]'>
                        <span class="text-danger" id="logoError"></span>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="brandStatus">Status</label>
                        <select class="form-control" id="brandStatus" name="status">
                            <option value="">- Select -</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span class="text-danger" id="statusError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="brandForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
