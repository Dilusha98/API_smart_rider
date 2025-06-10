<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ride Offers Management</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="rideOffersTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Driver</th>
                                <th>Passenger</th>
                                <th>Ride Date</th>
                                <th>Pickup Place</th>
                                <th>Drop Place</th>
                                <th>Price</th>
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

<!-- View Offer Modal -->
<div class="modal fade" id="viewOfferModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ride Offer Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><strong>Ride Information</strong></h6>
                        <p><strong>Ride ID:</strong> <span id="modal-ride-id"></span></p>
                        <p><strong>Driver:</strong> <span id="modal-driver-name"></span></p>
                        <p><strong>Date:</strong> <span id="modal-ride-date"></span></p>
                        <p><strong>Time:</strong> <span id="modal-ride-time"></span></p>
                        <p><strong>Seats:</strong> <span id="modal-seats"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Offer Information</strong></h6>
                        <p><strong>Offer ID:</strong> <span id="modal-offer-id"></span></p>
                        <p><strong>Passenger:</strong> <span id="modal-passenger-name"></span></p>
                        <p><strong>Price:</strong> <span id="modal-price"></span></p>
                        <p><strong>Status:</strong> <span id="modal-status"></span></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6><strong>Route Information</strong></h6>
                        <p><strong>Pickup Place:</strong> <span id="modal-pickup-place"></span></p>
                        <p><strong>Drop Place:</strong> <span id="modal-drop-place"></span></p>
                        <p><strong>Distance:</strong> <span id="modal-distance"></span> km</p>
                    </div>
                </div>
                <div class="row mt-4" id="ride-map-section" style="display:none;">
                    <div class="col-md-12">
                        <h6><strong>Ride Tracking (Map View)</strong></h6>
                        <div id="ride-tracking-map" style="height: 400px;"></div>
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
    $('#rideOffersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('ride_offers') }}",
            type: 'GET'
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'driver_name', name: 'driver_name'},
            {data: 'passenger_name', name: 'passenger_name'},
            {data: 'ride_date', name: 'ride_date'},
            {data: 'pickup_place', name: 'pickup_place'},
            {data: 'drop_place', name: 'drop_place'},
            {data: 'price', name: 'price'},
            {data: 'status_text', name: 'status_text'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order: [[0, 'desc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // View offer details
    $(document).on('click', '.view-offer', function() {
        var offerId = $(this).data('id');

        $.ajax({
            url: "{{ url('admin/ride-offer') }}/" + offerId,
            type: 'GET',
            success: function(response) {
                // Populate modal with data
                $('#modal-offer-id').text(response.id);
                $('#modal-ride-id').text(response.ride_id);
                $('#modal-driver-name').text(response.ride.user.name);
                $('#modal-passenger-name').text(response.passenger_user.name);
                $('#modal-ride-date').text(response.ride.date);
                $('#modal-ride-time').text(response.ride.time);
                $('#modal-seats').text(response.ride.seats);
                $('#modal-price').text('LKR ' + response.price);
                $('#modal-pickup-place').text(response.request.pickup_place);
                $('#modal-drop-place').text(response.request.drop_place);
                $('#modal-distance').text(response.request.distance);

                // Status badge
                var statusText = '';
                switch(response.status) {
                    case 0: statusText = '<span class="badge badge-warning">Pending</span>'; break;
                    case 1: statusText = '<span class="badge badge-info">Accepted</span>'; break;
                    case 2: statusText = '<span class="badge badge-success">Completed</span>'; break;
                    default: statusText = '<span class="badge badge-secondary">Unknown</span>';
                }
                $('#modal-status').html(statusText);

                $('#viewOfferModal').modal('show');

                    // Clear previous map if any
                    if (window.rideMap) {
                        window.rideMap.remove();
                    }

                    // Show map only if completed
                    if (response.status == 2) {
                        $('#ride-map-section').show();

                        // Load driver locations via AJAX
                        $.ajax({
                            url: '/admin/ride-location/' + response.ride_id,
                            type: 'GET',
                            success: function(locations) {
                                if (locations.length > 0) {
                                    const map = L.map('ride-tracking-map').setView([locations[0].lat, locations[0].lng], 13);
                                    // $('#ride-tracking-map').html('');
                                    window.rideMap = map;

                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 19,
                                        attribution: '&copy; OpenStreetMap contributors'
                                    }).addTo(map);

                                    const latlngs = locations.map(loc => [loc.lat, loc.lng]);

                                    // Draw route
                                    L.polyline(latlngs, { color: 'blue' }).addTo(map);

                                    // Mark start and end
                                    L.marker(latlngs[0]).addTo(map).bindPopup('Start').openPopup();
                                    L.marker(latlngs[latlngs.length - 1]).addTo(map).bindPopup('End');
                                }
                            },
                            error: function() {
                                toastr.error('Failed to load ride tracking data');
                            }
                        });
                    } else {
                        $('#ride-map-section').hide();
                    }
            },
            error: function() {
                toastr.error('Error loading offer details');
            }
        });
    });
});
</script>

