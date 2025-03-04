let userRoleTable;


$(function () {
    // Initialize DataTable
    userRoleTable = $('#userRoleListTable').DataTable({
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
            /*$('#userRoleListTable thead th').css({
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

    loadUserRoleData();
});



function loadUserRoleData() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/get-user-role-list',
        method: 'GET',
        success: function(response) {
            userRoleTable.clear(); // Clear existing data

            
            $.each(response.userRoles, function(index, roles) {

                var token = encode(roles.id);
                var statusBadge = roles.status == 1 ?
                '<span class="badge badge-success">Active</span>' :
                '<span class="badge badge-danger">Inactive</span>';

                const createdDate = roles.created_at.split('T')[0];
                const updatedDate = roles.updated_at.split('T')[0];

                userRoleTable.row.add([
                    roles.title || '',
                    roles.createdBy || '',
                    roles.updatedBy || '',
                    createdDate || '',
                    updatedDate || '',
                    statusBadge,
                   '<div class="dropdown open d-inline-block">' +
                        '<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actionDropdown' + roles.id + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 2px 5px; font-size: 12px;">' +
                            '<i class="fas fa-pencil-alt" style="font-size: 13px;"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item user-edit" href="javascript:void(0);" onclick="editUserRole(\'' + token + '\')">' +
                                '<i class="fas fa-edit mr-2"></i>Edit' +
                            '</a>' +
                        '</div>' +
                    '</div>'
                ]);
            });

            userRoleTable.draw(); // Redraw the table to update pagination and info
        },
        error: function(xhr, status, error) {
            console.error('Failed to load user data:', error);
        }
    });
}

// Direct to the edit page
function editUserRole(token) {
    var url = '/UserRoleEdit?token=' + token;
    window.open(url, '_blank', 'noopener,noreferrer');
}

function encode(data) {
    return btoa(data);
}