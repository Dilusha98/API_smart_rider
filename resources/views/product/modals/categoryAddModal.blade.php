<div class="modal fade" id="categoryAddModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" enctype="multipart/form-data">
                    <!-- Brand Name -->
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter category name">
                        <span class="text-danger" id="categoryNameError"></span>
                    </div>

                    <!-- Brand Logo -->
                    <div class="form-group">
                        <label for="categoryImage">Image</label>
                        <input type="file" class="form-control dropify" id="categoryImage" name="categoryImage" data-allowed-file-extensions='["jpg", "png"]'>
                        <span class="text-danger" id="categoryImageError"></span>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="catDescription">Description</label>
                        <textarea class="form-control" id="catDescription" name="catDescription"></textarea>
                        <span class="text-danger" id="catDescriptionError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="categoryForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
