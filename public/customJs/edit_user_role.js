//common things
$(function () {
    // Add event for counting characters
    updateRNameCount();
    $('#roleName').on('input', function() {
        updateRNameCount();
    });

    // Add event listener to all 'Select All' checkboxes
    $('.select-all').on('change', function() {
        var target = $(this).data('target');
        var $checkboxes = $('#' + target + ' input[type="checkbox"]').not('.select-all');

        // Set all checkboxes to the state of the 'Select All' checkbox
        $checkboxes.prop('checked', $(this).prop('checked'));
    });

    // Add event listener to all individual checkboxes
    $('.tab-pane input[type="checkbox"]').not('.select-all').on('change', function() {
        var $tabPane = $(this).closest('.tab-pane');
        var allChecked = $tabPane.find('input[type="checkbox"]').not('.select-all').length === 
                         $tabPane.find('input[type="checkbox"]:checked').not('.select-all').length;

        // Check or uncheck the 'Select All' checkbox based on individual checkboxes
        $tabPane.find('.select-all').prop('checked', allChecked);
    });


    //validation
    $('#userRoleUpdateBtn').on('click', function(e) { 
        if ($("#userRoleUpdateForm").length > 0) {
            $('#userRoleUpdateForm').validate({
                errorPlacement: function(error, element) {
                    var name = element.attr('name');
                    $('#' + name + 'Error').html(error);
                },
                rules: {
                    roleName: {
                        required: true,
                        minlength: 2
                    },
                },
                messages: {
                    roleName: {
                        required: "Please enter a role name",
                    },
                },
                /*submitHandler: function(form, event) {
                    event.preventDefault();
    
                    // var formData = new FormData(form);
                    var formData = new FormData(document.getElementById('userRoleForm'));
    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
    
                    $.ajax({
                        url:'/CreateUserRole',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'User  Role Added',
                                text: 'The user role has been successfully added!',
                                confirmButtonText: 'OK'
                            });
                            form.reset();
    
                            formClear();
                        },
                        error: function(response) {
                            if (response.status === 422) {
                                var errors = response.responseJSON.errors;
                                $.each(errors, function(key, error) {
                                    $('#' + key + 'Error').html(error[0]);
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'There was an error adding the brand. Please try again.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                }*/
            });
        }
    });
});



function updateRNameCount() {
    const maxLength = 45;
    const currentLength = $('#roleName').val().length;
    const remainingCharacters = maxLength - currentLength;
    $('#charCount').text(remainingCharacters + " characters left");
}