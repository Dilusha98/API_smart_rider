
$(document).ready(function() {

    displayPreviewsOfExistingWebPImages ();
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
    showPreviewIncludingWebPFiles();


    $('#BrandListTbl').DataTable({
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


    if ($("#brandForm").length > 0) {

        $('#brandForm').validate({
            errorPlacement: function(error, element) {
                var name = element.attr('name');
                $('#' + name + 'Error').html(error);
            },
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                logo: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter a brand name",
                    minlength: "Brand name must be at least 2 characters long"
                },
                logo: {
                    required: "Please upload a logo",
                },
                status: {
                    required: "Please select a status"
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                // var formData = new FormData(form);
                var formData = new FormData(document.getElementById('brandForm'));

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'/add-brand',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        loadBrandData();
                        Swal.fire({
                            icon: 'success',
                            title: 'Brand Added',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        $('#brandAddModal').modal('hide');
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

    $('#brandAddModal').on('hidden.bs.modal', function () {
        $('#brandForm')[0].reset();
        $('#brandForm').find('.is-invalid').removeClass('is-invalid');
        $('#brandForm').find('.form-control-danger').removeClass('form-control-danger');
        $('#brandForm').find('.text-danger').html('');
    });

});


function loadBrandData() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/get-brand-data',
        method: 'GET',
        success: function(response) {

            $('#BrandListTbl tbody').empty();
            $.each(response.brands, function(index, brand) {

                var statusBadge = brand.status == 1 ?
                    '<span class="badge badge-success">Active</span>' :
                    '<span class="badge badge-warning">Inactive</span>';

                var created_by = brand.created_by ? brand.created_by.name : 'N/A';

                $('#BrandListTbl tbody').append(
                    '<tr>' +
                        '<td>' + brand.name + '</td>' +
                        '<td>' + statusBadge + '</td>' +
                        '<td>' + created_by + '</td>' +
                        '<td>' + brand.created_at + '</td>' +
                        '<td class="text-center">' +
                            '<div class="dropdown open d-inline-block">' +
                                '<button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="actionDropdown' + brand.id + '" data-toggle="dropdown">' +
                                    '<i class="fas fa-edit"></i>' +
                                '</button>' +
                                '<div class="dropdown-menu">' +
                                    '<a class="dropdown-item" onclick="editBrand(' + brand.id + ')"><i class="fas fa-edit mr-2"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="deleteBrand(' + brand.id + ')"><i class="fas fa-trash mr-2"></i>Delete</a>' +
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



    /*
    |--------------------------------------------------------------------------
    | Edit brand
    |--------------------------------------------------------------------------
    |
    */


function editBrand(id){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "get",
        url: "/get-brand-details/"+id,
        dataType: 'json',
        success: function (res) {
            $('#brandEditModal').modal('toggle');
            $('#brandNameEdit').val(res[0].name);
            $('#brandID').val(res[0].id);

            var imagePath = './images/' + res[0].logo;
            resetPreview(imagePath,res[0].logo)

            $('#brandStatusEdit').val(res[0].status ? 1 : 0);

        }
    });

}

function resetPreview(src, fname = '') {
    let input = $('#brandLogoEdit');
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


function displayPreviewsOfExistingWebPImages () { // Call this function when page is ready, i.e. $(document).ready(displayPreviewsOfExistingWebPImages);
    // Initialize Dropify on all elements with the class .dropify
    var dropifyInstances = $('.dropify').dropify();

    // Iterate over each Dropify instance
    dropifyInstances.each(function() {
        // Get the current instance's element and defaultFile data attribute
        var element = $(this);
        var defaultFile = element.data('default-file');

        // Check if the defaultFile exists and ends with '.webp'
        if (defaultFile && defaultFile.endsWith('.webp')) {
            // Find the Dropify preview container for the current instance
            var previewContainer = element.closest('.dropify-wrapper').find('.dropify-render');
            var previewImg = $('<img />').attr('src', defaultFile).css({"max-height": "100%", "max-width": "100%"});

            // Clear any existing content in the preview container
            previewContainer.empty();

            // Append the WebP image as the preview for the current instance
            previewContainer.append(previewImg);

            // Show the clear button for the current instance
            element.closest('.dropify-wrapper').find('.dropify-clear').show();

            // Optionally, hide the message that prompts users to "Drag and drop a file here or click"
            element.closest('.dropify-wrapper').find('.dropify-message').hide();
        }
    });
}


function showPreviewIncludingWebPFiles() { // Call this function whenever you add a new image
    var dropifyElements = document.querySelectorAll('.dropify');
    // Iterate over each element
    dropifyElements.forEach(function(dropifyInput) {
        dropifyInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file && file.type === 'image/webp') {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Find the Dropify preview element relative to the current Dropify input
                    var previewContainer = dropifyInput.closest('.dropify-wrapper').querySelector('.dropify-render');
                    var previewImage = previewContainer.querySelector('img');
                    if (!previewImage) {
                        // If the <img> tag doesn't exist, create it
                        previewImage = document.createElement('img');
                        previewContainer.appendChild(previewImage);
                    }
                    // Set the src of the <img> to the read file for preview
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
}


$(document).ready(function () {

    if ($("#brandEditForm").length > 0) {

        $('#brandEditForm').validate({
            errorPlacement: function(error, element) {
                var name = element.attr('name');
                $('#' + name + 'ErrorEdit').html(error);
            },
            rules: {
                brandNameEdit: {
                    required: true,
                    minlength: 2
                },
                brandStatusEdit: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter a brand name",
                    minlength: "Brand name must be at least 2 characters long"
                },
                status: {
                    required: "Please select a status"
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                var formData = new FormData(document.getElementById('brandEditForm'));
                var id = $('#brandID').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'/edit-brand/'+id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        loadBrandData();
                        Swal.fire({
                            icon: 'success',
                            title: 'Brand Updated',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        $('#brandEditModal').modal('hide');
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


    $('#brandEditModal').on('hidden.bs.modal', function () {
        $('#brandEditForm')[0].reset();
        $('#brandEditForm').find('.is-invalid').removeClass('is-invalid');
        $('#brandEditForm').find('.form-control-danger').removeClass('form-control-danger');
        $('#brandEditForm').find('.text-danger').html('');
    });

});


function deleteBrand(id)
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
                url: "/delete-brand/"+id,
                success: function (response) {
                    loadBrandData();
                    Swal.fire({
                        icon: 'success',
                        title: 'Brand Deleted',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'There was an error deleting the brand. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            });

        }
      });

}
