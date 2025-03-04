$(document).ready(function () {

    // Function to add new row
    document.getElementById('addRow').addEventListener('click', function() {
        var tableBody = document.getElementById('attributeValuesBody');
        var newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" class="form-control" name="values[]" placeholder="Value"></td>
            <td><input type="text" class="form-control" name="value_slugs[]" placeholder="Slug"></td>
            <td><i class="fas fa-times remove-row"></td>
        `;

        tableBody.appendChild(newRow);
    });

    // Function to remove row
    document.getElementById('attributeValuesTable').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });

});


$(document).ready(function() {

    $('#attributesForm').validate({
        rules: {
            attribute_name: {
                required: true,
                maxlength: 152
            },
            attribute_slug: {
                required: true,
                maxlength: 152
            }
        },
        messages: {
            name: {
                required: "Please enter a name",
                maxlength: "Name can't exceed 152 characters"
            },
            slug: {
                required: "Please enter a slug",
                maxlength: "Slug can't exceed 152 characters"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
