@if ((in_array(auth()->user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION]) && in_array($statusID, [1, 3])) || (in_array(auth()->user()->getRoleNames()->first(), [SUPER_ADMIN, VN_USER_PERMISSION])) && in_array($statusID, [0, 3]))
    <input type="checkbox" class="form-check-input form-control m-auto mt-0 outreach-profile position-relative" value="{{ $id }}">
@endif