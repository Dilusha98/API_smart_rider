$(document).ready(function () {

    $('.dropify').dropify({
        messages: {
            'default': 'Select an image',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Oops, something wrong happened.'
        },
        error: {
            'fileSize': 'The file size is too big (2MB max).',
            'imageFormat': 'The image format is not allowed (only JPG, PNG, GIF).'
        },
        maxFileSize: '2M',
    });

    $('#categoryTbl').DataTable({
        dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>rtip',
        buttons: [
            {extend: 'excelHtml5', className: 'btn-sm btn-success'},
            {extend: 'pdfHtml5', className: 'btn-sm btn-danger'},
            {extend: 'print', className: 'btn-sm btn-info'}
        ],
        pageLength:10,
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records..."
        }
    });



    if ($("#categoryForm").length > 0) {

        $('#categoryForm').validate({
            errorPlacement: function(error, element) {
                var name = element.attr('name');
                $('#' + name + 'Error').html(error);
            },
            rules: {
                categoryName: {
                    required: true,
                    minlength: 2
                },
                categoryImage: {
                    required: true,
                },
                catDescription: {
                    required: true,
                    maxlength: 500,
                }
            },
            messages: {
                categoryName: {
                    required: "Please enter a category name",
                    minlength: "Category name must be at least 2 characters long"
                },
                categoryImage: {
                    required: "Please upload a Image",
                },
                catDescription: {
                    required: "Please enter a description",
                    maxlength: "Description must not exceed 500 characters"
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                // var formData = new FormData(form);
                var formData = new FormData(document.getElementById('categoryForm'));

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'/add-category',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        loadCategoryData();
                        Swal.fire({
                            icon: 'success',
                            title: 'Category Added',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        $('#categoryAddModal').modal('hide');
                        form.reset();
                        $('.dropify-clear').click();
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            var errors = response.responseJSON.errors;
                            $.each(errors, function(key, error) {
                                $('#' + key + 'Error').html(error[0]);
                            });
                        }else if(response.status === 403){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.responseJSON.error,
                                confirmButtonText: 'OK'
                            });
                        }else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error adding the brand. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
    }

    $('#categoryAddModal').on('hidden.bs.modal', function () {
        $('#categoryForm')[0].reset();
        $('#categoryForm').find('.is-invalid').removeClass('is-invalid');
        $('#categoryForm').find('.form-control-danger').removeClass('form-control-danger');
        $('#categoryForm').find('.text-danger').html('');
    });

});


function editCategory(id){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "get",
        url: "/get-category-details/"+id,
        dataType: 'json',
        success: function (res) {

            $('#categoryEditModal').modal('toggle');
            $('#categoryEditName').val(res[0].name);
            $('#categoryID').val(res[0].id);
            $('#catEditDescription').text(res[0].description);

            var imagePath = './images/' + res[0].image;
            resetPreview(imagePath,res[0].image)

            $('#catStatus').val(res[0].status ? 1 : 0);

        }
    });

}


function resetPreview(src, fname = '') {
    let input = $('#categoryEditImage');
    let dropify = input.data('dropify');

    // If Dropify instance is not initialized, initialize it
    if (!dropify) {
        input.dropify();
        dropify = input.data('dropify');
    }

    // Reset the Dropify preview and update the image
    let wrapper = input.closest('.dropify-wrapper');
    let preview = wrapper.find('.dropify-preview');
    let filename = wrapper.find('.dropify-filename-inner');
    let render = wrapper.find('.dropify-render').empty();

    input.val('').attr('title', fname);
    wrapper.removeClass('has-error').addClass('has-preview');
    filename.text(fname);

    // Set the default image in Dropify
    preview.fadeIn();
    render.append($('<img />').attr('src', src).css('max-height', input.data('height') || ''));
}


$(document).ready(function () {

    if ($("#categoryEditForm").length > 0) {

        $('#categoryEditForm').validate({
            errorPlacement: function(error, element) {
                var name = element.attr('name');
                $('#' + name + 'Error').html(error);
            },
            rules: {
                categoryEditName: {
                    required: true,
                    minlength: 2
                },
                catEditDescription: {
                    required: true,
                    maxlength: 500,
                },
                catStatus:{
                    required: true,
                }
            },
            messages: {
                categoryEditName: {
                    required: "Please enter a category name",
                    minlength: "Category name must be at least 2 characters long"
                },
                catEditDescription: {
                    required: "Please enter the description"
                },
                catEditDescription: {
                    required: "Please select a status",
                    maxlength:"Description must be 500 characters"
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                var formData = new FormData(document.getElementById('categoryEditForm'));
                var id = $('#categoryID').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'/edit-category/'+id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        loadCategoryData();
                        Swal.fire({
                            icon: 'success',
                            title: 'Category Updated',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        $('#categoryEditModal').modal('hide');
                        form.reset();
                        $('.dropify-clear').click();
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            var errors = response.responseJSON.errors;
                            $.each(errors, function(key, error) {
                                $('#' + key + 'ErrorEdit').html(error[0]);
                            });
                        } else if(response.status === 403){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.responseJSON.error,
                                confirmButtonText: 'OK'
                            });
                        }else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error adding the brand. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
    }


    $('#categoryEditModal').on('hidden.bs.modal', function () {
        $('#categoryEditForm')[0].reset();
        $('#categoryEditForm').find('.is-invalid').removeClass('is-invalid');
        $('#categoryEditForm').find('.form-control-danger').removeClass('form-control-danger');
        $('#categoryEditForm').find('.text-danger').html('');
    });

});


function loadCategoryData() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/get-category-data',
        method: 'GET',
        success: function(response) {

            $('#categoryTbl tbody').empty();
            $.each(response.category, function(index, category) {

                var statusBadge = category.status == 1 ?
                    '<span class="badge badge-success">Active</span>' :
                    '<span class="badge badge-warning">Inactive</span>';

                var created_by = category.created_by ? category.created_by.name : 'N/A';

                var imageUrl = category.image ? '/images/' + category.image : '';
                var imageTag = imageUrl ? '<img src="' + imageUrl + '" class="categoryLogo" alt="Category Image" style="width: 50px; height: 50px;">' : 'N/A';

                $('#categoryTbl tbody').append(
                    '<tr>' +
                        '<td>' + category.name + '</td>' +
                        '<td>' + category.description + '</td>' +
                        '<td>' + imageTag + '</td>' +
                        '<td>' + statusBadge + '</td>' +
                        '<td>' + created_by + '</td>' +
                        '<td class="text-center">' +
                            '<div class="dropdown open d-inline-block">' +
                                '<button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="actionDropdown' + category.id + '" data-toggle="dropdown">' +
                                    '<i class="fas fa-edit"></i>' +
                                '</button>' +
                                '<div class="dropdown-menu">' +
                                    '<a class="dropdown-item" onclick="editCategory(' + category.id + ')"><i class="fas fa-edit mr-2"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="deleteCategory(' + category.id + ')"><i class="fas fa-trash mr-2"></i>Delete</a>' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                    '</tr>'
                );
            });
        },
        error: function(xhr, status, error) {
            console.error('Failed to load brand data:', error);
        }
    });
}


function deleteCategory(id)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "DELETE",
                url: "/delete-category/"+id,
                success: function (response) {
                    loadCategoryData();
                    Swal.fire({
                        icon: 'success',
                        title: 'Category Updated',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'There was an error deleting the category. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            });

        }
      });

}
