@extends('layouts.app')

@section('content')
    <div class="row">
        <a class="btn btn-primary float-right w-2 m-2 text-white" role="button" id="btn-export-risk-assessment">Export</a>
        <button class="btn btn-primary w-2 m-2" id="filter-toggle-btn">Filter</button>
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <h3 class="mb-0"> All Self-Risk Assessments</h3>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            @empty(!$selflink)
                                <span class="float-right">
                                    Your link: {{ $selflink }}
                                </span>
                            @endempty
                            <br>
                            @empty(!$oldSelflink)
                                <span class="float-right">
                                    Your Old link: {{ $oldSelflink }}
                                </span>
                            @endempty
                        </div>
                    </div>
                    <div id="filter-form-container" style="display: none;">
                        <form action="{{ route('admin.self-risk-assessment.index') }}" method="post" id="frm-sra">
                            <div class="form-row">
                                @csrf
                                <input type="hidden" name="export" value="1">
                                <div class="col-md-4 mb-3">
                                    <label for="risk_assessment_id">Assessment No</label>
                                    <input type="text" class="form-control" id="risk_assessment_id"
                                        name="risk_assessment_id" placeholder="Assessments No" value="">
                                </div>
                                @if (Auth::user()->user_type != 2)
                                    <!-- VN Name -->
                                    <div class="col-md-4 mb-3">
                                        <label for="vn_id">VN Name</label>
                                        <select id="vn_id" name="vn_id[]" class="form-control js-example-basic-multiple"
                                            multiple>
                                            <option value="">Choose...</option>
                                            @foreach ($vn_list as $vn)
                                                <option value="{{ $vn->id }}">{{ $vn->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <!-- Risk Score -->
                                <div class="col-md-4 mb-3">
                                    <label for="risk_score">Risk Score</label>
                                    <select id="risk_score" name="risk_score" class="form-control">
                                        <option value="">Choose...</option>
                                        @for ($i = 1; $i <= 100; $i += 10)
                                            <option value="{{ $i }}-{{ $i + 9 }}">
                                                {{ $i }}-{{ $i + 9 }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Mobile No -->
                                <div class="col-md-4 mb-3">
                                    <label for="mobile_no">Mobile No</label>
                                    <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                                        placeholder="Mobile No" value="">
                                </div>

                                <!-- Services -->
                                <div class="col-md-4 mb-3">
                                    <label for="services">Services</label>
                                    <select id="services" name="services" class="form-control">
                                        <option value="">Choose...</option>
                                        @foreach (SERVICES as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- State -->
                                <div class="col-md-4 mb-3">
                                    <label for="inputStateget">State</label>
                                    <select id="input-state" name="state_id" class="form-control">
                                        <option value="">Choose...</option>
                                        @foreach ($state_list as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->state_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- From Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="from_date">From Date</label>
                                    <input type="date" id="from" name="from" class="form-control">
                                </div>
                                <!-- To Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="to_date">To Date</label>
                                    <input type="date" id="to" name="to" class="form-control">
                                </div>
                            </div>
                        </form>
                        <input type="hidden" class="form-control" id="search" name="search" value="search">
                        <button class="btn btn-primary" type="button" id="btn_search">Submit</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center" id="self-risk-assessment-details">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="z-index: 2 !important;">Assessment No</th>
                                        <th scope="col" style="z-index: 2 !important;">Appointment No</th>
                                        <th scope="col" style="z-index: 2 !important;">Total Risk</th>
                                        <th scope="col">Meet Counsellor ID</th>
                                        <th scope="col" style="z-index: 2 !important;">VN Name</th>
                                        <th scope="col" style="z-index: 2 !important;">Has Appointment</th>
                                        @foreach ($header as $key => $value)
                                            @php
                                                $temp = $key;
                                            @endphp
                                            <th scope="col" data-toggle="tooltip" data-placement="bottom"
                                                title="{{ $header2[$key] }}"
                                                @if ($loop->index == 0) style="z-index: 2 !important;" @endif>
                                                {{ ++$temp }}</th>
                                        @endforeach
                                        <th scope="col">RA Date</th>
                                        <th scope="col">IP</th>
                                        <th scope="col">User Country</th>
                                        <th scope="col">User State</th>
                                        <th scope="col">User City</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" media="all" href="{{ asset('assets/css/jquery.dataTables.css') }}">
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ App::isProduction() ? secure_asset('assets/js/custom/self-risk-assessment.js') : asset('assets/js/custom/self-risk-assessment.js') }}">
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
            $('#filter-toggle-btn').click(function() {
                $('#filter-form-container').toggle();
            });

            $('#vn_id').select2();
        });

        function confirmDeleteSubmit() {
            var userConfirmed = confirm("Are you sure you want to delete this record?");

            return userConfirmed ? true : false;
        }
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
