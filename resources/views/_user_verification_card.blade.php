<div class="card mb-4">
    <div class="card-header">
        <h5>{{ $user->name }} (ID: {{ $user->id }})</h5>
    </div>

    <div class="card-body row">
        @foreach ($user->userVerificationDocuments as $doc)
            <div class="col-md-4 mb-3">
                <div class="border p-2">
                    <strong>{{ ucfirst(str_replace('_', ' ', $doc->type)) }}</strong><br>

                    @if (file_exists(storage_path('app/public/user_verifications/' . $doc->file_name)))
                        <img src="{{ asset('storage/user_verifications/' . $doc->file_name) }}"
                             class="img-thumbnail"
                             style="max-width: 80px; cursor: pointer;"
                             data-bs-toggle="modal"
                             data-bs-target="#imgModal{{ $doc->id }}">
                    @else
                        <p class="text-warning">Image not found.</p>
                    @endif

                    <!-- Modal -->
                    <div class="modal fade" id="imgModal{{ $doc->id }}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">{{ ucfirst($doc->type) }} - Document Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body text-center">
                            <img src="{{ asset('storage/user_verifications/' . $doc->file_name) }}" class="img-fluid">
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Review actions -->
                    @if ($doc->status === 0)
                        <form method="POST" action="{{ route('admin.verification.review', $doc->id) }}">
                            @csrf
                            <textarea name="admin_note" class="form-control mb-2" placeholder="Optional note..."></textarea>
                            <div class="d-flex gap-2">
                                <button name="status" value="1" class="btn btn-success btn-sm">Accept</button>
                                <button name="status" value="2" class="btn btn-danger btn-sm">Reject</button>
                            </div>
                        </form>
                    @else
                        <span class="badge {{ $doc->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $doc->status_text }}
                        </span>
                        <div><small>Note: {{ $doc->admin_note ?? '—' }}</small></div>
                        <div><small>Reviewed: {{ $doc->reviewed_at ?? '—' }}</small></div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
