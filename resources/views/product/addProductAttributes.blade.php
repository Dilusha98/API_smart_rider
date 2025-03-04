<style>
    .remove-row{
        cursor: pointer;
        color: red;
        font-size: 20px;
        padding:5px;
    }
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="m-0">Add Product Attributes</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Product Attributes</li>
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
                        <!-- Form to add attributes -->
                        <form id="attributesForm" action="/save-attributes" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="attribute_name">Name</label>
                                        <input type="text" id="attribute_name" name="attribute_name" class="form-control" placeholder="Name" maxlength="152">
                                        <small id="nameHelp" class="form-text text-muted">151 characters left</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="attribute_slug">Slug</label>
                                        <input type="text" id="attribute_slug" name="attribute_slug" class="form-control" placeholder="Slug" maxlength="152">
                                        <small id="slugHelp" class="form-text text-muted">151 characters left</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic table for adding attribute values -->
                            <div class="row">
                                <div class="col-12">
                                    <table class="table" id="attributeValuesTable">
                                        <thead>
                                            <tr>
                                                <th>Values</th>
                                                <th>Slug</th>
                                                <th><button type="button" id="addRow" class="btn btn-primary float-right"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody id="attributeValuesBody">
                                            <tr>
                                                <td><input type="text" class="form-control" name="values[]" placeholder="Value"></td>
                                                <td><input type="text" class="form-control" name="value_slugs[]" placeholder="Slug"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
