let userTable;


$(function () {
    // Initialize DataTable
    userTable = $('#userListTable').DataTable({
        dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>rtip',
        buttons: [
            {extend: 'excelHtml5', className: 'btn-sm btn-success'},
            {extend: 'pdfHtml5', className: 'btn-sm btn-danger'},
            {extend: 'print', className: 'btn-sm btn-info'}
        ],
        pageLength: 10,
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
        },
        initComplete: function(settings, json) {
            /*$('#userListTable thead th').css({
                'height': '30px',
                'line-height': '30px',
                'padding-top': '0',
                'padding-bottom': '0',
                'background-color': '#4a5568',
                'color': 'white',
                'font-weight': 'bold',
                'text-transform': 'uppercase'
            });
            
            $('.dataTables_wrapper .row:first-child').css({
                'background-color': 'white',
                'padding': '10px 0'
            });
            
            $('.dataTables_filter input').addClass('form-control').css({
                'width': '250px',
                'display': 'inline-block'
            });
            
            $('.dt-buttons .btn').css('margin-right', '5px');*/
        }
    });

    loadUserData();
});

function loadUserData() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/get-user-list',
        method: 'GET',
        success: function(response) {
            userTable.clear(); // Clear existing data

            
            $.each(response.users, function(index, user) {

                var token = encode(user.id);
                var statusBadge = user.status == 1 ?
                '<span class="badge badge-success">Active</span>' :
                '<span class="badge badge-danger">Inactive</span>';

                userTable.row.add([
                    user.name || '',
                    user.last_name || '',
                    user.username || '',
                    user.title || '',
                    user.phone || '',
                    user.dob || '',
                    user.address || '',
                    statusBadge,
                   '<div class="dropdown open d-inline-block">' +
                        '<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actionDropdown' + user.id + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 2px 5px; font-size: 12px;">' +
                            '<i class="fas fa-pencil-alt" style="font-size: 13px;"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item user-edit" href="javascript:void(0);" onclick="editUser(\'' + token + '\')">' +
                                '<i class="fas fa-edit mr-2"></i>Edit' +
                            '</a>' +
                        '</div>' +
                    '</div>'
                ]);
            });

            userTable.draw(); // Redraw the table to update pagination and info
        },
        error: function(xhr, status, error) {
            console.error('Failed to load user data:', error);
        }
    });
}


// Direct to the edit page
function editUser(token) {
    var url = '/UserEdit?token=' + token;
    window.open(url, '_blank', 'noopener,noreferrer');
}

function encode(data) {
    return btoa(data);
}

