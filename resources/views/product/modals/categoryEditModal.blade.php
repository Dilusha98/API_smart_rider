<div class="modal fade" id="categoryEditModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoryEditForm" enctype="multipart/form-data">

                    <input type="hidden" name="categoryID" id="categoryID">

                    <!-- Brand Name -->
                    <div class="form-group">
                        <label for="categoryEditName">Category Name</label>
                        <input type="text" class="form-control" id="categoryEditName" name="categoryEditName" placeholder="Enter category name">
                        <span class="text-danger" id="categoryEditNameError"></span>
                    </div>

                    <!-- Brand Logo -->
                    <div class="form-group">
                        <label for="categoryEditImage">Image</label>
                        <input type="file" class="form-control dropify" id="categoryEditImage" name="categoryEditImage" data-allowed-file-extensions='["jpg", "png"]'>
                        <span class="text-danger" id="categoryEditImageError"></span>
                    </div>

                    <!-- description -->
                    <div class="form-group">
                        <label for="catEditDescription">Description</label>
                        <textarea class="form-control" id="catEditDescription" name="catEditDescription"></textarea>
                        <span class="text-danger" id="catEditDescriptionError"></span>
                    </div>

                    <!-- description -->
                    <div class="form-group">
                        <label for="catStatus">Status</label>
                        <select class="form-control" name="catStatus" id="catStatus">
                            <option value="">- Select -</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span class="text-danger" id="catStatusError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="categoryEditForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
