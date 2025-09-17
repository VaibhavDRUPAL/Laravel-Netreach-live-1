@extends('layouts.app')

@section('content')
    <div class="row dashboard-ab">
        <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card-stats ab-blue">
                <div class="card-body analytics" style="cursor: pointer" data-type="service" data-id="1">
                    <div class="row">
                        <div class="col">
                            <div class="indicate">{{ $positive }}</div>
                            <h5 class="card-title mb-0 card-title">Total No. of Positive</h5>
                        </div>
                        <div class="col-auto">
                            <div class="ab-icon-info ab-light-blue">
                                <img src="{{ asset('assets/img/icons/analytics/2.png') }}" class="w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card-stats ab-blue">
                <div class="card-body analytics" style="cursor: pointer" data-type="service" data-id="2">
                    <div class="row">
                        <div class="col">
                            <div class="indicate">{{ $negative }}</div>
                            <h5 class="card-title mb-0 card-title">Total No. of Negative</h5>
                        </div>
                        <div class="col-auto">
                            <div class="ab-icon-info ab-light-blue">
                                <img src="{{ asset('assets/img/icons/analytics/3.png') }}" class="w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card-stats ab-blue">
                <div class="card-body analytics" style="cursor: pointer" data-type="service" data-id="3">
                    <div class="row">
                        <div class="col">
                            <div class="indicate">{{ $notdisclosed }}</div>
                            <h5 class="card-title mb-0 card-title">Total No. of Not Disclosed</h5>
                        </div>
                        <div class="col-auto">
                            <div class="ab-icon-info ab-light-blue">
                                <img src="{{ asset('assets/img/icons/analytics/1.png') }}" class="w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card-stats ab-blue">
                <div class="card-body analytics" style="cursor: pointer" data-type="evidence" data-id="1">
                    <div class="row">
                        <div class="col">
                            <div class="indicate">{{ $withevidence }}</div>
                            <h5 class="card-title mb-0 card-title">Total No. of With Evidence</h5>
                        </div>
                        <div class="col-auto">
                            <div class="ab-icon-info ab-light-blue">
                                <img src="{{ asset('assets/img/icons/analytics/4.png') }}" class="w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card-stats ab-blue">
                <div class="card-body analytics" style="cursor: pointer" data-type="evidence" data-id="0">
                    <div class="row">
                        <div class="col">
                            <div class="indicate">{{ $withoutevidence }}</div>
                            <h5 class="card-title mb-0 card-title">Total No. of Without Evidence</h5>
                        </div>
                        <div class="col-auto">
                            <div class="ab-icon-info ab-light-blue">
                                <img src="{{ asset('assets/img/icons/analytics/5.png') }}" class="w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="analatical-list" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="analatical-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a id="btn-export" href="{{ route('admin.self-risk-assessment.appointment', ['export' => true]) }}"
                        data-target="{{ route('admin.self-risk-assessment.appointment', ['export' => true]) }}"
                        class="btn btn-primary float-right w-2 m-2" role="button"
                        id="btn-export-risk-assessment">Export</a>
                    <table class="table table-hover align-items-center" id="tbl-self-analatical-list">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Sr. No</th>
                                <th scope="col">UID</th>
                                <th scope="col">VN name</th>
                                <th scope="col">Appointment ID</th>
                                <th scope="col">Risk Score</th>
                                <th scope="col">Full name</th>
                                <th scope="col">Mobile No</th>
                                <th scope="col">Services</th>
                                <th scope="col">Type Of Test</th>
                                <th scope="col">State</th>
                                <th scope="col">District</th>
                                <th scope="col">Centre</th>
                                <th scope="col">Remark</th>
                                <th scope="col">Pre art</th>
                                <th scope="col">On art</th>
                            </tr>
                        </thead>
                        <tbody class="list"></tbody>
                    </table>
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
@endpush
