<div class="modal fade" id="brandEditModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Brand</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="brandEditForm" enctype="multipart/form-data">

                    <input type="hidden" name="brandID" id="brandID">

                    <!-- Brand Name -->
                    <div class="form-group">
                        <label for="brandName">Brand Name</label>
                        <input type="text" class="form-control" id="brandNameEdit" name="brandNameEdit" placeholder="Enter brand name">
                        <span class="text-danger .error-message" id="brandNameEditErrorEdit"></span>
                    </div>

                    <!-- Brand Logo -->
                    <div class="form-group">
                        <label for="brandLogo">Brand Logo</label>
                        <input type="file" class="form-control dropify" id="brandLogoEdit" name="brandLogoEdit" data-default-file="" data-allowed-file-extensions='["jpg", "png" , "webp"]'>
                        <span class="text-danger .error-message" id="brandLogoEditErrorEdit"></span>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="brandStatus">Status</label>
                        <select class="form-control" id="brandStatusEdit" name="brandStatusEdit">
                            <option value="">- Select -</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span class="text-danger .error-message" id="brandStatusEditErrorEdit"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="brandEditForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
