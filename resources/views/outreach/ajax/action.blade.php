<div class="ml-3 dropdown show">
    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="action" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Select Action
    </a>
    <div class="dropdown-menu" aria-labelledby="action">
        @if (
            (in_array(auth()->user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION]) && $statusID != 0) ||
                (in_array(auth()->user()->getRoleNames()->first(), [SUPER_ADMIN, VN_USER_PERMISSION]) &&
                    in_array($statusID, [0, 3])))
            <a class="dropdown-item" href="{{ route('outreach.profile.edit', $id) }}">Edit Profile</a>
        @endif
        <a class="dropdown-item"
            href="{{ route('outreach.referral-service.create', ['sno' => urlencode($unique_serial_number), 'profile' => $id]) }}">Add
            Referral</a>
        <a class="dropdown-item"
            href="{{ route('outreach.referral-service.index', ['sno' => urlencode($unique_serial_number), 'profile' => $id]) }}">Show
            Referral</a>
        {{-- <a class="dropdown-item"
            href="{{ route('outreach.counselling.create', ['sno' => urlencode($unique_serial_number), 'profile' => $id]) }}">Add
            Counselling</a>
        <a class="dropdown-item"
            href="{{ route('outreach.counselling.index', ['sno' => urlencode($unique_serial_number), 'profile' => $id]) }}">Show
            Counselling</a> --}}
        @empty(!$referral)
            @if (!empty($referral) && $referral['outcome_of_the_service_sought'] == 1)
                @if ($referral['service_type_id'] == 1 || $referral['service_type_id'] == 5)
                    <a class="dropdown-item"
                        href="{{ route('outreach.plhiv.create', ['sno' => urlencode($unique_serial_number), 'profile' => $id]) }}">Add
                        PLHIV Test</a>
                    <a class="dropdown-item"
                        href="{{ route('outreach.plhiv.index', ['sno' => urlencode($unique_serial_number), 'profile' => $id]) }}">Show
                        PLHIV Test</a>
                @endif
                @if ($referral['service_type_id'] == 2 || $referral['service_type_id'] == 5)
                    <a class="dropdown-item"
                        href="{{ route('outreach.sti.create', ['sno' => urlencode($unique_serial_number), 'profile' => $id, 'user_id' => $id]) }}">Add
                        STI</a>
                    <a class="dropdown-item"
                        href="{{ route('outreach.sti.index', ['sno' => urlencode($unique_serial_number), 'profile' => $id]) }}">Show
                        STI</a>
                @endif
            @endif
        @endempty
    </div>
</div>
@if (auth()->user()->getRoleNames()->first() == SUPER_ADMIN)
    <a role="button" class="btn btn-danger text-white item-delete" data-id="{{ $id }}">
        <i class="fas fa-trash"></i>
    </a>
@endif
