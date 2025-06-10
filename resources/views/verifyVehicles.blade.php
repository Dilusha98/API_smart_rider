<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
  <h2 class="mb-4">Vehicle Verification</h2>

  @foreach ($vehicles as $vehicle)
    <div class="card mb-4 shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h5 class="mb-0">
            <strong>{{ $vehicle->model }}</strong> ({{ $vehicle->plate_number }})
          </h5>
          @if ($vehicle->status == 1)
            <span class="badge bg-success">Approved</span>
          @elseif ($vehicle->status == 2)
            <span class="badge bg-danger">Rejected</span>
          @else
            <span class="badge bg-warning text-dark">Pending</span>
          @endif
        </div>

        <p class="mb-1">
          <strong>Owner ID:</strong> {{ $vehicle->owner }} <br>
          <strong>Brand:</strong> {{ $vehicle->brand }} |
          <strong>Year:</strong> {{ $vehicle->year }} |
          <strong>Fuel:</strong> {{ $vehicle->fuel_type }} |
          <strong>Seats:</strong> {{ $vehicle->max_seats }}
        </p>

        @if ($vehicle->images->isNotEmpty())
          <div class="d-flex flex-wrap gap-2 mt-3">
            @foreach ($vehicle->images as $image)
              <!-- Thumbnail -->
              <img src="{{ asset('storage/vehicle_images/' . $image->image_name) }}"
                   class="img-thumbnail"
                   style="max-width: 60px; cursor: pointer;"
                   data-bs-toggle="modal"
                   data-bs-target="#imgModal{{ $image->id }}" />

              <!-- Modal -->
              <div class="modal fade" id="imgModal{{ $image->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Image Preview</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                      <img src="{{ asset('storage/vehicle_images/' . $image->image_name) }}"
                           class="img-fluid rounded" />
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-muted">No images available.</p>
        @endif

        @if ($vehicle->status == 0)
          <form method="POST" action="{{ route('admin.vehicles.review', $vehicle->id) }}" class="mt-3">
            @csrf
            <div class="d-flex gap-2">
              <button type="submit" name="status" value="1" class="btn btn-success btn-sm">Approve</button>
              <button type="submit" name="status" value="2" class="btn btn-danger btn-sm">Reject</button>
            </div>
          </form>
        @endif

      </div>
    </div>
  @endforeach
</div>
