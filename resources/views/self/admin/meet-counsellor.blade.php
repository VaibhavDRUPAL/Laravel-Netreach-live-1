@extends('layouts.app')
@section('content')
    <div class="d-flex align-items-center">
        <button class="btn btn-primary w-2 m-2 text-white" type="button" id="btn-export-meet-counsellor">
            Export
        </button>

        <button class="btn btn-primary w-2 m-2" id="filter-toggle-btn">Filter</button>
        <a href="{{ url('/admin/meet-counsellor') }}" class="btn btn-primary float-right" title="Reset Filters">
            <i class="fas fa-sync-alt"> Reset Filter</i>
        </a>
    </div>
    <div class="col-md-12">
        {{-- -----------Filter code---------------------------------- --}}
        <div id="filter-container" style="display: none;">
            <form action="{{ route('admin.meet-counsellor.index') }}" method="post" id="meet-counsellor-filter-form">
                @csrf
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="meet_id">Meet ID</label>
                        <input type="text" class="form-control" id="meet_id" name="meet_id" placeholder="Meet ID"
                            value="{{ request('meet_id') }}">
                    </div>

                    <!-- Name -->
                    <div class="col-md-4 mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name"
                            value="{{ request('name') }}">
                    </div>
                    <!-- Mobile No -->
                    <div class="col-md-4 mb-3">
                        <label for="mobile_no">Mobile No</label>
                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile No"
                            value="{{ request('mobile_no') }}">
                    </div>

                    <!-- State -->
                    <div class="col-md-4">
                        <label for="inputStateget">State</label>
                        <select id="input-state" name="state_id" class="form-control">
                            <option value="">Choose...</option>
                            @foreach ($state_list as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->state_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="col-md-4 mb-3">
                        <label for="from_date">From Date</label>
                        <input type="date" id="from_date" name="from_date" class="form-control"
                            value="{{ request('from_date') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="to_date">To Date</label>
                        <input type="date" id="to_date" name="to_date" class="form-control"
                            value="{{ request('to_date') }}">
                    </div>
                    <!-- Is follow-up -->
                    <div class="col-md-4 mb-2">
                        <label for="inputStateget">Follow-Up</label>
                        <select id="has_followup" name="has_followup" class="form-control">
                            <option value="">Choose...</option>
                            <option value="1" {{ request('has_followup') === '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ request('has_followup') === '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
            </form>
            <input type="hidden" class="form-control" id="search" name="search" value="search">
            <button class="btn btn-primary" type="button" id="btn_appointment_search">Submit</button>
        </div>
        {{-- -----------------Filter code ends--------------------------- --}}

        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Meet Counsellor Data</h3>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center" id="meet-counsellor-details">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="z-index: 2 !important;">ID</th>
                                        <th scope="col" style="z-index: 2 !important;">Name</th>
                                        <th scope="col" style="z-index: 2 !important;">Mobile Number</th>
                                        <th scope="col" style="z-index: 2 !important;">State</th>
                                        <th scope="col" style="z-index: 2 !important;">Region</th>
                                        <th scope="col" style="z-index: 2 !important;">Message</th>
                                        <th scope="col" style="z-index: 2 !important;">Date</th>
                                        <th scope="col" style="z-index: 2 !important;">Follow-up Date</th>
                                        <th scope="col" style="z-index: 2 !important;">Contacted</th>
                                        <th scope="col" style="z-index: 2 !important;">Follow-up</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($meetCounsellor as $data)
                                        <tr>
                                            <td>{{ $data->meet_id }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->mobile_no }}</td>
                                            <td>{{ $data->state_name }}</td>
                                            <td>
                                                @if ($data->region == 1)
                                                    North
                                                @elseif ($data->region == 2)
                                                    South
                                                @elseif ($data->region == 3)
                                                    East
                                                @else
                                                    West
                                                @endif

                                            </td>
                                            <td
                                                style="white-space: normal; word-break: break-word; min-width: 400px; max-width: 600px;">
                                                {{ $data->message }}</td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>
                                                {{ optional($data->followUps->sortByDesc('created_at')->first())->created_at ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ optional($data->followUps->sortByDesc('contacted')->first())->contacted == 1 ? 'Yes' : (optional($data->followUps->sortByDesc('contacted')->first())->contacted === 0 ? 'No' : 'N/A') }}

                                            </td>

                                            <td>
                                                <button class="btn btn-sm btn-primary follow-up-btn" data-toggle="modal"
                                                    title="Add Follow Up" data-target="#addFollowUpModal"
                                                    data-id="{{ $data->meet_id }}" data-name="{{ $data->name }}">
                                                    <i class="fas fa-reply"></i>
                                                </button>

                                                @if ($data->followUps->isNotEmpty())
                                                    <button class="btn btn-sm btn-primary viewFollowUpBtn"
                                                        title="View follow-up" data-toggle="modal"
                                                        data-target="#viewFollowUpModal" data-id="{{ $data->meet_id }}"
                                                        data-name="{{ $data->name }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Add Follow-Up Modal -->
    <div class="modal fade" id="addFollowUpModal" tabindex="-1" aria-labelledby="addFollowUpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.meet-counsellor.saveFollowUp') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="followUpModalLabel">Follow-Up</h5>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <b>X</b>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="meet_id" id="followUpMeetId">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="followUpName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Have you Ever Contacted</label>
                            <select name="contacted" id="contacted" class="form-control" required>
                                <option value="" selected disabled>------Select------</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">What Action Taken?</label>
                            <textarea name="action_taken" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="follow_up_image" class="form-label">Upload Attachment</label>
                            <input class="form-control" type="file" name="follow_up_image" id="follow_up_image"
                                onchange="previewImage(event)">
                            <div class="mt-2">
                                <img src="" id="imagePreview" alt=""
                                    style="display: none; max-width:100%; height:auto; border: 1px solid #ccc; padding: 5px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Follow-Up</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Add Follow-Up Modal ends -->

    <!--View Follow-Up Modal -->
    <div class="modal fade" id="viewFollowUpModal" tabindex="-1" aria-labelledby="viewFollowUpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="followUpModalLabel">View Follow-Ups</h5>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <b>X</b>
                    </button>
                </div>
                <div class="modal-body" id="followUpContainer">
                    {{-- fetching dynamic follow-up entries --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!--View Follow-Up Modal ends-->
@endsection

@push('scripts')
    <link rel="stylesheet" media="all" href="{{ asset('assets/css/jquery.dataTables.css') }}">
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ App::isProduction() ? secure_asset('assets/js/custom/meet-counsellor.js') : asset('assets/js/custom/meet-counsellor.js') }}">
    </script>
    <script
        src="{{ App::isProduction() ? secure_asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') : asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}">
    </script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#filter-toggle-btn').on('click', function() {
                $('#filter-container').toggle();
            });
            $('#btn_appointment_search').on('click', function() {
                $('#meet-counsellor-filter-form').submit();
            });
            $('#btn_appointment_search').on('click', function() {
                $('input[name="export"]').remove();
                $('#meet-counsellor-filter-form').submit();
            });

            // Export button: submit with export=1
            $('#btn-export-meet-counsellor').on('click', function() {
                // Add export input if not exists
                if (!$('input[name="export"]').length) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'export',
                        value: 1
                    }).appendTo('#meet-counsellor-filter-form');
                }
                $('#meet-counsellor-filter-form').submit();
            });
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap.min.css">
    <style>
        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }
    </style>
@endpush
