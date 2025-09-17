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
                @if (in_array(auth()->user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION]))
                    <button class="btn btn-success float-right" id="accept" value="2">
                        <i class="fa fa-check"></i>
                        Accept
                    </button>
                    <button class="btn btn-danger float-right mx-2" id="reject" value="3">
                        <i class="fa fa-times"></i>
                        Reject
                    </button>
                @elseif(auth()->user()->getRoleNames()->first() == VN_USER_PERMISSION)
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
                                <h3 class="mb-0">All STI</h3>
                                <button class="btn btn-sm btn-info mb-0" type="button"  data-toggle="modal" data-target="#exampleModal">Upload Data</button>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-0">
                                    {{ Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Search by unique serial number', 'id'=>'search']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <div>

                                <table class="table table-hover align-items-center" id="survy_data_tbl_id">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" name="select-all" id="select-all">
                                                Select
                                            </th>
                                            <th scope="col">Unique Serial Number</th>
                                            <th scope="col">Employee Name</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Client Type</th>
                                            <th scope="col">Date Of STI</th>
                                            <th scope="col">PID or other unique ID of the client provided at the service centre </th>
                                            <th scope="col">Applicable for STI service</th>
                                            <th scope="col">Applicable for STI syphillis</th>
                                            <th scope="col">Other STI Service</th>
                                            <th scope="col">Treated</th>
                                            <th scope="col">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>

                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
        <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
        <script src="{{ asset('assets/vendor/custom_alert/bootbox.all.min.js') }}"></script>
        <link rel="stylesheet" media="all" href="{{ asset('assets/css/jquery.dataTables.css') }}">
        <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

        <script>
            function refreshTable(search = '') {
                $(document).ready(function() {
                    var dataTableObj = $('#survy_data_tbl_id').dataTable({
                        "processing": true,
                        "serverSide": true,
                        "bDestroy": true,
                        "searching": false,
                        "bPaginate": true,
                        "sDom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                        "columnDefs": [
                            { "orderable": false, "targets": 0 }
                        ],
                        "ajax": {
                            "url": "{{ route('outreach.sti.list') }}",
                            "type": "POST",
                            "data":  {
                                _token: "<?php echo csrf_token(); ?>",
                                unique_serial_number: "{{ $unique_serial_number }}",
                                profile_id: "{{ $profileID }}",
                                search,
                            }
                        }

                    });
                    $('#select-all').prop('checked', false);
                    $("#btn_serch").click(function() {
                        dataTableObj.fnDraw();
                    });
                });
            };
            $(document).ready(function() {
                refreshTable();
                $(document).on('click', '#accept, #reject', function() {
                    var data = [];
                    var status = $(this).val();
                    $('#survy_data_tbl_id').find('td.sorting_1 input[type=checkbox]').each(function (key, val){
                        if($(val).is(':checked')) data.push($(val).val());
                    });
                    $.ajax({
                        url : '/outreach/sti/take-action',
                        method : 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : {
                            data: data,
                            status : status
                        },
                        success : function () {
                            refreshTable();
                        }
                    })
                })
            });
        </script>
    @endpush
@endpush.