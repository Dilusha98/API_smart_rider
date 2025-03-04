$(function () {

    //form submit
    if ($("#userCreateForm").length > 0) {
        $('#userCreateForm').validate({
            errorPlacement: function(error, element) {
                var name = element.attr('name');
                $('#' + name + 'Error').html(error);
            },
            rules: {
                firatName: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                LastName: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                phoneNo: {
                    required: true,
                    phoneNumber: true,
                    monoExist: true
                },
                userEmail: {
                    required: true,
                    email: true,
                    maxlength: 50,
                    uEmailExist: true
                },
                userName: {
                    required: true,
                    minlength: 5,
                    maxlength: 50,
                    uNameExist: true
                },
                password: {
                    required: true,
                    minlength: 8,  // Minimum length
                    maxlength: 20, // Maximum length
                    pwcheck: true  // Custom validation rule (optional)
                },
                userRole: {
                    required: true,
                },
            },
            messages: {
                firatName: {
                    required: "Please enter a first name",
                    minlength: "First name must be at least 2 characters long",
                    maxlength: "First name must be no more than 50 characters long"
                },
                LastName: {
                    required: "Please enter a last name",
                    minlength: "Last name must be at least 2 characters long",
                    maxlength: "Last name must be no more than 50 characters long"
                },
                phoneNo: {
                    required: "Please enter your phone number.",
                    phoneNumber: "Please enter a valid phone number."
                },
                userEmail: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address",
                    maxlength: "Email must not exceed 50 characters"
                },
                userName: {
                    required: "Please enter a user name",
                    minlength: "User name must be at least 5 characters long",
                    maxlength: "User name must be no more than 50 characters long"
                },
                password: {
                    required: "Please enter a password",
                    minlength: "Password must be at least 8 characters long",
                    maxlength: "Password must be no more than 20 characters long",
                    pwcheck: "Password must contain at least one letter, one number, and one special character"
                },
                userRole: {
                    required: "Please enter a user role"
                },
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                // var formData = new FormData(form);
                var formData = new FormData(document.getElementById('userCreateForm'));

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'/SaveUser',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Brand Added',
                            text: 'The user has been successfully added!',
                            confirmButtonText: 'OK'
                        });
                        form.reset();
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


    // Add event for counting characters for first name
    var maxChars = 50;
    var $firatName = $('#firatName');
    var $firatNamecharCount = $('#firatNamecharCount');
    $firatName.on('input', function() {
        var remaining = maxChars - $(this).val().length;
        $firatNamecharCount.text(remaining + ' characters left');
    });

    // Add event for counting characters for last name
    var $LastName = $('#LastName');
    var $lastNamecharCount = $('#lastNamecharCount');
    $LastName.on('input', function() {
        var remaining = maxChars - $(this).val().length;
        $lastNamecharCount.text(remaining + ' characters left');
    });

    $.validator.addMethod("phoneNumber", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        var isValid = false;
        
        // India: +91 followed by 10 digits
        var indiaRegex = /^(\+91|0)?[6789]\d{9}$/;
        
        // China: +86 followed by 11 digits
        var chinaRegex = /^(\+86|0)?1[3456789]\d{9}$/;
        
        // Japan: +81 followed by 10 digits (excluding first 0)
        var japanRegex = /^(\+81|0)\d{9,10}$/;
        
        // South Korea: +82 followed by 9-10 digits
        var southKoreaRegex = /^(\+82|0)?1[0-9]{7,8}$/;
        
        // Singapore: +65 followed by 8 digits
        var singaporeRegex = /^(\+65|0)?[89]\d{7}$/;

        // Sri Lanka: +94 followed by 9 digits
        var sriLankaRegex = /^(\+94|0)?[1-9]\d{8}$/;
        
        // Check if the number matches any of the country formats
        isValid = indiaRegex.test(phone_number) ||
                  chinaRegex.test(phone_number) ||
                  japanRegex.test(phone_number) ||
                  southKoreaRegex.test(phone_number) ||
                  singaporeRegex.test(phone_number) ||
                  sriLankaRegex.test(phone_number);
        
        return this.optional(element) || isValid;
    }, "Please enter a valid phone number");

    // Add event for counting characters for email
    var $userEmail = $('#userEmail');
    var $userEmailCount = $('#userEmailCount');
    $userEmail.on('input', function() {
        var remaining = maxChars - $(this).val().length;
        $userEmailCount.text(remaining + ' characters left');
    });

    // Add event for counting characters for email
    var $userName = $('#userName');
    var $userNameCount = $('#userNameCount');
    $userName.on('input', function() {
        var remaining = maxChars - $(this).val().length;
        $userNameCount.text(remaining + ' characters left');
    });


    // Custom password validation rule (optional)
    $.validator.addMethod("pwcheck", function(value) {
        return /[A-Za-z]/.test(value) // has a letter
            && /[0-9]/.test(value) // has a digit
            && /[^A-Za-z0-9]/.test(value); // has a special character
    });

    var maxCharsPass = 20;
    var $password = $('#password');
    var $passwordCount = $('#passwordCount');
    $password.on('input', function() {
        var remaining = maxCharsPass - $(this).val().length;
        $passwordCount.text(remaining + ' characters left');
    });


    var maxCharsAddress = 200;
    var $address = $('#address');
    var $addressCount = $('#addressCount');
    $address.on('input', function() {
        var remaining = maxCharsAddress - $(this).val().length;
        $addressCount.text(remaining + ' characters left');
    });
});




/* Start mobile number validation  */
$.validator.addMethod(
    "monoExist",
    function (value, element) {
        var tempStatus = false;
        $.ajax({
            type: "GET",
            url: '/user-phone-uniq-validation',
            async: false,
            data: {
                value: value,
                id: $("#userId").val(),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (status) {
                if (status) {
                    tempStatus = false;
                } else {
                    tempStatus = true;
                }
            },
            error: function () {
            },
        }).fail(function (xhr, status, textStatus, error) {
            located(xhr);
        });

        return tempStatus;
    },
    'This phone number is already in use. Please try again!'
);


/* Start user name validation  */
$.validator.addMethod(
    "uNameExist",
    function (value, element) {
        var tempStatus = false;
        $.ajax({
            type: "GET",
            url: '/user-user-name-uniq-validation',
            async: false,
            data: {
                value: value,
                id: $("#userId").val(),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (status) {
                if (status) {
                    tempStatus = false;
                } else {
                    tempStatus = true;
                }
            },
            error: function () {
            },
        }).fail(function (xhr, status, textStatus, error) {
            located(xhr);
        });

        return tempStatus;
    },
    'This user name is already in use. Please try again!'
);

/* Start user email validation  */
$.validator.addMethod(
    "uEmailExist",
    function (value, element) {
        var tempStatus = false;
        $.ajax({
            type: "GET",
            url: '/user-email-uniq-validation',
            async: false,
            data: {
                value: value,
                id: $("#userId").val(),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (status) {
                if (status) {
                    tempStatus = false;
                } else {
                    tempStatus = true;
                }
            },
            error: function () {
            },
        }).fail(function (xhr, status, textStatus, error) {
            located(xhr);
        });

        return tempStatus;
    },
    'This user email is already in use. Please try again!'
);
