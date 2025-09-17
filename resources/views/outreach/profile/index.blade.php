@extends('layouts.app')

@push('styles')
    <style>
        .custom-control-inline {
            margin-right: 0rem !important;
        }

        form#another-element {
            padding: 15px;
            border: 1px solid #666;
            background: #fff;
            display: none;
            margin-top: 20px;
        }

        .required-field::before {
            content: "*";
            color: red;
            float: right;
        }


        .assessment_date {
            display: none;
        }

        .referral_date {
            display: none;
        }

        .acess_date {
            display: none;
        }
    </style>

    @section('content')
    
    <div class="row">
        <div class="col-md-12 my-2">
                <a href="{{ route('outreach.profile.list.export') }}" class="btn btn-primary  w-2 m-2 text-white" role="button" id="btn-export-meet-counsellor">Export</a>
                @if (in_array($roleName, [SUPER_ADMIN, PO_PERMISSION]))
                    <input type="text" class="form-control w-25 float-right" placeholder="Reject Comment" id="comment">
                    <button class="btn btn-danger float-right mx-2" id="reject" value="3">
                        <i class="fa fa-times"></i>
                        Reject
                    </button>
                    <button class="btn btn-success float-right" id="accept" value="2">
                        <i class="fa fa-check"></i>
                        Accept
                    </button>
                @elseif($roleName == VN_USER_PERMISSION)
                    <button class="btn btn-primary float-right" id="assign-now">
                        <i class="fa fa-plus"></i>
                        Submit to PO
                    </button>
                @endif
            </div>
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-header bg-transparent">
                        <div class="row">
                            <div class="col-lg-4">
                                <h3 class="mb-0">All Profiles</h3>
                                <button class="btn btn-sm btn-info mb-0" type="button" data-toggle="modal"
                                    data-target="#exampleModal">Upload Data</button>
                                <a href="{{ route('outreach.download') }}" class="btn btn-sm btn-info mb-0"
                                    role="button">Download Sample Sheet</a>
                                <select id="statusFilter" class="form-control w-25 mt-4">
                                    <option value='4'>Show All</option>
                                    <option value="0">Not Assigned</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Accepted</option>
                                    <option value="3">Rejected</option>
                                </select>
                            </div>
                            <div class="col-lg-4 text-right">
                                <a href="{{ route('outreach.profile.create') }}" class="btn btn-sm btn-neutral">Create New
                                    Profile</a>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-0">
                                    {{ Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Search by unique serial number or name', 'id' => 'search']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-items-center" id="survy_data_tbl_id">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">
                                            <input type="checkbox" name="select-all" id="select-all">
                                            Select
                                        </th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Profile Name/Name</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Comment</th>
                                        {{-- <th scope="col">uid</th> --}}
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Unique Serial Number</th>
                                        <th scope="col">Reg Date</th>
                                        <th scope="col">State</th>
                                        <th scope="col">District</th>
                                        <th scope="col">App Platform</th>
                                        <th scope="col">Other</th>
                                        <th scope="col">Remarks</th>

                                    </tr>
                                </thead>
                                <tbody></tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('modal')
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ url('/ImportProfile') }}" enctype="multipart/form-data"> @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Excel file upload</label>
                                <input type="file" name="efile" class="form-control" required="true">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endpush
    @push('scripts')
        <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
        <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
        <script src="{{ asset('assets/vendor/custom_alert/bootbox.all.min.js') }}"></script>
        <link rel="stylesheet" media="all" href="{{ asset('assets/css/jquery.dataTables.css') }}">
        <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

        <script>
            function refreshTable(search = '', datax = 4) {
                var dataTableObj = $('#survy_data_tbl_id').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "bDestroy": true,
                    "searching": false,
                    "bPaginate": true,
                    "sDom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                    "columnDefs": [{
                        "orderable": false,
                        "targets": 0
                    }],
                    "ajax": {
                        "url": "{{ route('outreach.profile.list') }}",
                        "type": "POST",
                        "data": {
                            _token: "<?php echo csrf_token(); ?>",
                            search,
                            datax,
                        }
                    }

                });
                $('#select-all').prop('checked', false);

                $("#btn_serch").click(function() {
                    dataTableObj.fnDraw();
                });

            }
            $(document).ready(function() {
                refreshTable();
            });

            const debouncedRefresh = debounce(refreshTable, 500);
            $('#search').on('input', (e) => {
                const val = e.target.value;
                debouncedRefresh(val);
            });

            $(document).on('change', '#statusFilter', function() {


                refreshTable(search = '', datax = $(this).val());
            })
            $(document).on('click', '#assign-now', function() {
                var data = [];
                $('#survy_data_tbl_id').find('td.sorting_1 input[type=checkbox]').each(function(key, val) {
                    if ($(val).is(':checked')) data.push($(val).val());
                });
                $.ajax({
                    url: '/outreach/assign',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        data: data
                    },
                    success: function() {
                        refreshTable();
                    }
                })
            })

            $(document).on('click', '#accept', function() {
                var data = [];
                var status = $(this).val();
                $('#survy_data_tbl_id').find('td.sorting_1 input[type=checkbox]').each(function(key, val) {
                    if ($(val).is(':checked')) data.push($(val).val());
                });
                $.ajax({
                    url: '/outreach/take-action',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        data: data,
                        status: status,
                    },
                    success: function() {
                        refreshTable();
                    }
                })
            })
            $(document).on('click', '#reject', function() {
                var data = [];
                var status = $(this).val();
                if ($("#comment").val()) {

                    var comment = $("#comment").val();
                    $('#survy_data_tbl_id').find('td.sorting_1 input[type=checkbox]').each(function(key, val) {
                        if ($(val).is(':checked')) data.push($(val).val());
                    });
                    $.ajax({
                        url: '/outreach/take-action',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            data: data,
                            status: status,
                            comment: comment
                        },
                        success: function() {
                            refreshTable();
                        }
                    })
                } else {
                    alert('Please enter a comment');
                }
            })

            $(document).on('click', '#select-all', function() {
                var status = $(this).is(':checked') ? true : false;

                $('#survy_data_tbl_id').find('td.sorting_1 input[type=checkbox]').each(function(key, val) {
                    $(val).prop('checked', status);
                });
            })

            $(document).on('click', '.item-delete', function() {
                if (confirm('Are you sure you want to delete, also you will lose other related data to this record?')) {
                    $.ajax({
                        url: '/outreach/delete',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            profile_id: $(this).attr('data-id')
                        },
                        success: function() {
                            refreshTable();
                        }
                    })
                }
            })
        </script>
    @endpush

    @push('modal')

    @endpush
