<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@php
    $notApprovedUsers = $users->filter(function ($user) {
        return $user->userVerificationDocuments->contains(fn ($doc) => $doc->status !== 1);
    });

    $fullyApprovedUsers = $users->filter(function ($user) {
        return $user->userVerificationDocuments->every(fn ($doc) => $doc->status === 1);
    });
@endphp

<!-- Bootstrap Tabs -->
<ul class="nav nav-tabs mb-3" id="docTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="not-approved-tab" data-bs-toggle="tab" data-bs-target="#not-approved" type="button" role="tab">
      Not Approved ({{ $notApprovedUsers->count() }})
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
      Approved ({{ $fullyApprovedUsers->count() }})
    </button>
  </li>
</ul>

<div class="tab-content" id="docTabContent">
  <!-- Not Approved Tab -->
  <div class="tab-pane fade show active" id="not-approved" role="tabpanel">
    @foreach ($notApprovedUsers as $user)
      @include('_user_verification_card', ['user' => $user])
    @endforeach
  </div>

  <!-- Approved Tab -->
  <div class="tab-pane fade" id="approved" role="tabpanel">
    @foreach ($fullyApprovedUsers as $user)
      @include('_user_verification_card', ['user' => $user])
    @endforeach
  </div>
</div>
