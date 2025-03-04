//common things
$(function () {
    // Add event for counting characters
    var maxChars = 45;
    var $input = $('#roleName');
    var $charCount = $('#charCount');

    $input.on('input', function() {
        var remaining = maxChars - $(this).val().length;
        $charCount.text(remaining + ' characters left');
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

    // Empty field and uncheck checkboxes when reloading the page
    $(window).on('load', function() {
        // Clear the text input
        $('#roleName').val('');

        // Uncheck all checkboxes within the tab content
        $('#custom-tabs-four-tabContent input[type="checkbox"]').prop('checked', false);
    });
});

//saving form data
$(function () {
    if ($("#userRoleForm").length > 0) {

        $('#userRoleForm').validate({
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
            submitHandler: function(form, event) {
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
                        handleResponse(response);

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
            }
        });
    }
});

//clear form data
function formClear() {
    // Clear the text input
    $('#roleName').val('');

    // Uncheck all checkboxes within the tab content
    $('#custom-tabs-four-tabContent input[type="checkbox"]').prop('checked', false);
}