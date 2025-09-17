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
            margin-top: 20px;
        }
    </style>
@endpush
@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="headingdiv">
                            <h3 class="mb-0">Old E-Slip</h3>
                        </div>
                        @if (!Auth::user()->hasRole('VN User Permission'))
                            <div class="col-lg-12 mb-3">
                                <div>
                                    {{ Form::open(['url' => '/survey/filter', 'id' => 'another-element']) }}
                                    <div class="form-row">

                                        <div class="col-md-3 mb-3">
                                            <label for="input_region">Region</label>
                                            <select id="input_region" class="form-control"
                                                onchange="return getRegion(this.value)">
                                                <option value="">Choose...</option>
                                                <option value="1">North</option>
                                                <option value="2">South</option>
                                                <option value="3">East</option>
                                                <option value="4">West</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="vninputState">VN</label>
                                            <select id="vninputState" name="vninputState" class="form-control">
                                                <option value="">Choose...</option>

                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="inputStateget">State</label>
                                            <select id="inputStateget" name="state_id" class="form-control">
                                                <option value="">Choose...</option>
                                                @foreach ($state_list as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->state_name }}</option>
                                                @endforeach;
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3 ">
                                            <label for="validationCustom02">Acess Date To</label>
                                            <input type="Date" class="form-control" id="acess_date_from"
                                                placeholder="Acess Date">
                                        </div>
                                        <div class="col-md-3 mb-3 ">
                                            <label for="validationCustom02">Acess Date From</label>
                                            <input type="Date" class="form-control" id="acess_date_to"
                                                placeholder="Acess Date">
                                        </div>





                                    </div>
                                    <button class="btn btn-primary" type="button" id="btn_serch">Submit</button>
                                    </form>
                                </div><!-- myelement -->
                            </div>

                            <!-- <div class="col-lg-2 mt-4">
           <a class="btn btn-warning" href="{{ route('survey.export') }}">Export User Data</a>
          </div> -->
                            <div class=" mt-4">

                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>

                            <table class="table table-hover align-items-center" id="survy_data_tbl_id">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Client Type</th>
                                        <th scope="col">Assessment Date </th>
                                        <th scope="col">State</th>
                                        <th scope="col">District</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Risk</th>
                                        <th scope="col">UID</th>

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
        function getRegion(id) {

            // getState(id);
            var jsonData = {
                "_token": "{{ csrf_token() }}",
                "rid": id
            };

            $.ajax({
                type: "POST",
                url: "{{ route('survey.vn.by.region') }}",
                data: jsonData,
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $("#vninputState").html(data.vn_list);
                    $("#inputStateget").html(data.optionState);
                }

            });
        }



        $(document).ready(function() {

            var dataTableObj = $('#survy_data_tbl_id').dataTable({
                "processing": true,
                "serverSide": true,
                "bDestroy": true,
                "searching": false,
                "bPaginate": true,
                "sDom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                "ajax": {
                    "url": "{{ route('all.survey.report.slip') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = "<?php echo csrf_token(); ?>",
                            d.state = $("#vninputState").val(),
                            d.region = $("#input_region").val(),
                            d.state_id = $("#inputStateget").val(),
                            d.acess_date_from = $("#acess_date_from").val(),
                            d.acess_date_to = $("#acess_date_to").val();
                    }
                },
                columns: [{
                    data: 'dowload_e_slip',
                    title: 'Dowload E-Slip'
                }, {
                    data: 'book_date',
                    title: 'ASSESSMENT DATE'
                }, {
                    data: "state_name",
                    title: 'State Name'
                }, {
                    data: 'district_name',
                    title: 'District Name'
                }, {
                    data: 'client_phone_number',
                    title: 'MOBILE'
                }, {
                    data: 'risk_level',
                    title: 'RISK'
                }, {
                    data: 'uid',
                    title: 'UID'
                }, ]

            });

            $("#btn_serch").click(function() {
                dataTableObj.fnDraw();
            });


        });
    </script>
@endpush

@push('modal')
    <div class="modal fade" id="vn_file_upload_form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">File Attachment</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="form-group">
                                <label>Report File </label>
                                <div class="" id="files_detail_msg"></div>
                            </div>
                            <div class="form-group">
                                <label>Detail </label>
                                <div class="" id="detail_msg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="multiple-po-action-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">

                        <div class="card-body px-lg-5 py-lg-5">

                            <form id="po-mul-upload" method="POST" action="javascript:void(0)" accept-charset="utf-8"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea id="mul_detail" name="mul_detail" class="required form-control" rows="4" cols="30"></textarea>
                                    <div class="" id="mul_detail_err"></div>
                                </div>

                                <div class="form-group">
                                    <label>Action</label>
                                    <select name="mul_action" id="mul_action" class="form-control required">
                                        <option value=''>--Select--</option>
                                        <option value="1">Approve</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                    <div class="" id="mul_action_err"></div>
                                </div>

                                <div class="text-center">
                                    <input type="hidden" id="survey_mul_po_id" name="survey_mul_po_id"
                                        class="custom-control-input">
                                    <button type="button" class="btn btn-primary my-4"
                                        onclick="return submit_action();">Submit</button>
                                </div>
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-po-action-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">

                        <div class="card-body px-lg-5 py-lg-5">

                            <form id="po-upload" method="POST" action="javascript:void(0)" accept-charset="utf-8"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea id="detail" name="detail" class="required form-control" rows="4" cols="30"></textarea>
                                    <div class="" id="detail_err"></div>
                                </div>

                                <div class="form-group">
                                    <label>Action</label>
                                    <select name="action" id="action" class="form-control required">
                                        <option value=''>--Select--</option>
                                        <option value="1">Approve</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                    <div class="" id="action_err"></div>
                                </div>

                                <div class="text-center">
                                    <input type="hidden" id="survey_po_id" name="survey_po_id"
                                        class="custom-control-input">
                                    <button type="submit" class="btn btn-primary my-4">Submit</button>
                                </div>
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <!--<div class="card-header bg-white pb-5">
                                                    <div class="text-muted text-center mb-3"><small>Sign in with</small>
                                                    </div>
                                                </div>-->

                        <div class="card-body px-lg-5 py-lg-5">

                            <form id="multi-file-upload" method="POST" action="javascript:void(0)"
                                accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <label>Acess Date</label>
                                    <input class="form-control required" placeholder="" type="text" id="acess_date"
                                        name="acess_date" readonly>

                                    <div class="" id="acess_date_err"></div>

                                </div>
                                <div class="form-group">
                                    <input class="form-control required" placeholder="PID" type="text"
                                        name="user_pid" id="user_pid">
                                    <div id="user_pid_err"></div>
                                </div>

                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea id="detail_upload" name="detail_upload" class="required" rows="4" cols="30"></textarea>
                                    <div id="detail_err"></div>
                                </div>

                                <div class="form-group">
                                    <label>File Upload</label>
                                    <input class="form-control required" type="file" name="files[]" id="files"
                                        multiple>
                                    <div id="file_err"></div>
                                </div>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="negative" name="outcome" class="custom-control-input "
                                        value="1">
                                    <label class="custom-control-label" for="negative">Negative</label>
                                </div>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="positive" name="outcome" class="custom-control-input"
                                        value="2">
                                    <label class="custom-control-label" for="positive">Positive</label>
                                </div>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="non_reactive" name="outcome" class="custom-control-input"
                                        value="3">
                                    <label class="custom-control-label" for="non_reactive">Non-reactive </label>
                                </div>
                                <div id="outcome_err"></div>

                                <!-- not share -->
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="dontshare_id" name="outcome" class="custom-control-input"
                                        value="4">
                                    <label class="custom-control-label" for="dontshare_id"> Did not shared </label>
                                </div>
                                <div id="dontshare_err"></div>

                                <div class="text-center">
                                    <input type="hidden" id="survey_id" name="survey_id" class="custom-control-input">
                                    <button type="submit" class="btn btn-primary my-4">Save</button>
                                </div>
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
        aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content bg-gradient-danger">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Your Data Save </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">You should read this!</h4>
                        <p>Your have been Successfully! Save </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white">Ok, Got it</button>
                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
