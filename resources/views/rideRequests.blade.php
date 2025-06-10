<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ride Requests Management</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="rideRequestsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Pickup Place</th>
                                <th>Drop Place</th>
                                <th>Seats</th>
                                <th>Distance</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Request Modal -->
<div class="modal fade" id="viewRequestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ride Request Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><strong>Request Information</strong></h6>
                        <p><strong>Request ID:</strong> <span id="modal-request-id"></span></p>
                        <p><strong>User:</strong> <span id="modal-user-name"></span></p>
                        <p><strong>Date:</strong> <span id="modal-req-date"></span></p>
                        <p><strong>Time:</strong> <span id="modal-req-time"></span></p>
                        <p><strong>Seats Required:</strong> <span id="modal-req-seats"></span></p>
                        <p><strong>Status:</strong> <span id="modal-req-status"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Location Information</strong></h6>
                        <p><strong>Pickup Place:</strong> <span id="modal-req-pickup-place"></span></p>
                        <p><strong>Drop Place:</strong> <span id="modal-req-drop-place"></span></p>
                        <p><strong>Distance:</strong> <span id="modal-req-distance"></span> km</p>
                        <p><strong>Pickup Coordinates:</strong> <span id="modal-pickup-coords"></span></p>
                        <p><strong>Dropoff Coordinates:</strong> <span id="modal-dropoff-coords"></span></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6><strong>Additional Information</strong></h6>
                        <p><strong>Note:</strong> <span id="modal-req-note"></span></p>
                        <p><strong>Ride Key:</strong> <span id="modal-ride-key"></span></p>
                        <p><strong>Driver Rating:</strong> <span id="modal-driver-rating"></span></p>
                    </div>
                </div>
                <div class="row mt-4" id="ride-request-map-section" style="display:none;">
                    <div class="col-md-12">
                        <h6><strong>Pickup & Dropoff Map</strong></h6>
                        <div id="ride-request-map" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#rideRequestsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('ride_requests') }}",
            type: 'GET'
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'user_name', name: 'user_name'},
            {data: 'formatted_date', name: 'date'},
            {data: 'formatted_time', name: 'time'},
            {data: 'pickup_place', name: 'pickup_place'},
            {data: 'drop_place', name: 'drop_place'},
            {data: 'seats', name: 'seats'},
            {data: 'distance', name: 'distance'},
            {data: 'status_text', name: 'status_text'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order: [[0, 'desc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // View request details
    $(document).on('click', '.view-request', function() {
        var requestId = $(this).data('id');

        $.ajax({
            url: "{{ url('admin/ride-request') }}/" + requestId,
            type: 'GET',
            success: function(response) {
                // Populate modal with data
                $('#modal-request-id').text(response.id);
                $('#modal-user-name').text(response.ride && response.ride.user ? response.ride.user.name : 'N/A');
                $('#modal-req-date').text(response.date);
                $('#modal-req-time').text(response.time);
                $('#modal-req-seats').text(response.seats);
                $('#modal-req-pickup-place').text(response.pickup_place || 'N/A');
                $('#modal-req-drop-place').text(response.drop_place || 'N/A');
                $('#modal-req-distance').text(response.distance || 'N/A');
                $('#modal-pickup-coords').text(response.pickup_lat + ', ' + response.pickup_lng);
                $('#modal-dropoff-coords').text(response.dropoff_lat + ', ' + response.dropoff_lng);
                $('#modal-req-note').text(response.note || 'No notes');
                $('#modal-ride-key').text(response.ride_key || 'N/A');
                $('#modal-driver-rating').text(response.driver_rating || 'N/A');

                // Status badge with past date check
                var currentDate = new Date().toISOString().split('T')[0];
                var actualStatus = response.status;

                if ((response.status == 0 || response.status == 1) && response.date < currentDate) {
                    actualStatus = 2;
                }

                var statusText = '';
                switch(actualStatus) {
                    case 0: statusText = '<span class="badge badge-info">Upcoming</span>'; break;
                    case 1: statusText = '<span class="badge badge-warning">Ongoing</span>'; break;
                    case 2: statusText = '<span class="badge badge-success">Completed</span>'; break;
                    default: statusText = '<span class="badge badge-secondary">Unknown</span>';
                }
                $('#modal-req-status').html(statusText);

                $('#viewRequestModal').modal('show');

                // Clear previous map if any
                if (window.requestMap) {
                    window.requestMap.remove();
                    $('#ride-request-map').html(''); // Reset container
                }

                // Only show map if both coordinates are present
                if (response.pickup_lat && response.pickup_lng && response.dropoff_lat && response.dropoff_lng) {
                    $('#ride-request-map-section').show();

                    const map = L.map('ride-request-map').setView([response.pickup_lat, response.pickup_lng], 13);
                    window.requestMap = map;

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    const pickup = [response.pickup_lat, response.pickup_lng];
                    const dropoff = [response.dropoff_lat, response.dropoff_lng];

                    // Add markers
                    L.marker(pickup).addTo(map).bindPopup('Pickup Location').openPopup();
                    L.marker(dropoff).addTo(map).bindPopup('Dropoff Location');

                    // Draw a line between points
                    L.polyline([pickup, dropoff], { color: 'green' }).addTo(map);
                } else {
                    $('#ride-request-map-section').hide();
                }

            },
            error: function() {
                toastr.error('Error loading request details');
            }
        });
    });
});
</script>
