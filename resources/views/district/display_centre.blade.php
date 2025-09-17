@extends('layouts.app')

@push('pg_btn')
    @can('add-center')
        <a href="{{ route('center.create_center') }}" class="btn btn-sm btn-neutral">Create New Center</a>
    @endcan
@endpush

@section('content')
    <div class="row">
        <button class="btn btn-primary float-right w-2 m-2" role="button" id="btn-toggle-filter">Filter</button>

        <div class="col-md-12">
            <div id="filter-container" style="display: none;">
                {{ Form::open(['url' => '/survey/filter', 'id' => 'filter-form']) }}
                <div class="form-row">
                    <!-- VN Name -->
                    @if (Auth::id() == 1)
                        <div class="col-md-4 mb-3">
                            <label for="vn_name">VN Name</label>
                            <select id="vn_name" name="vn_name" class="form-control">
                                <option value="">Choose...</option>
                                @foreach ($vn_list as $vn)
                                    <option value="{{ $vn->id }}">{{ $vn->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <!-- State -->
                    <div class="col-md-4 mb-3">
                        <label for="inputStateget">State</label>
                        <select id="state_code" name="state_id" class="form-control">
                            <option value="">Choose...</option>
                            @foreach ($state as $key => $value)
                                <option value="{{ $value->state_code }}" data-code="{{ $value->state_code }}">
                                    {{ $value->state_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- District -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            {{ Form::label('district', 'District *', ['class' => 'form-control-label']) }}
                            <select class="form-control" name="district_id" id="district_id"></select>
                        </div>
                    </div>
                </div>

                <input type="hidden" class="form-control" id="search" name="search" value="search">
                <button class="btn btn-primary" type="button" id="btn_search">Submit</button>
                <br />
                {{ Form::close() }}
            </div>

            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-4">
                            <h3 class="mb-0">All Centre</h3>
                        </div>

                        @can('edit-centre')
                            <div class="col-lg-3">
                                <button class="btn btn-sm btn-info mb-0" type="button" data-toggle="modal"
                                    data-target="#exampleModal">Upload Data</button>
                                <a href="{{ route('centre.sample-template') }}"><small>Sample Template</small></a>
                                <a class="btn" href="{{ route('centre.export') }} "><small>Export Center</small> </a>
                            </div>
                        @endcan

                        {{-- <div class="col-lg-4">
                            {!! Form::open(['route' => 'all.centre.index', 'method' => 'get']) !!}
                            <div class="form-group mb-0">
                                {{ Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Search Centre']) }}
                            </div>
                            {!! Form::close() !!}
                        </div> --}}

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center" id="centreTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">PinCode</th>
                                        <th scope="col">State</th>
                                        <th scope="col">District</th>
                                        <th scope="col">VN Name</th>
                                        <th scope="col">Services</th>
                                        <th scope="col">Facility</th>
                                        <th scope="col">Centre Contact No</th>
                                        <th scope="col">Name of the ICTC Incharge / Medical Officer</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    <!-- Data will be populated by DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#btn-toggle-filter').click(function() {
            $('#filter-container').toggle();
        });

        $('#state_code').change(function() {
            var selectedOption = $(this).find('option:selected');
            var state_id = selectedOption.val();
            var dataCode = selectedOption.data('code');
            var DataJson = {
                "_token": "{{ csrf_token() }}",
                "std_code": dataCode
            }

            $.ajax({
                type: "POST",
                url: "{{ route('district.state') }}",
                data: (DataJson),
                dataType: "json",
                success: function(data) {
                    $("#district_id").html(data.resultsHtml);
                }
            });
        });

        $(document).ready(function() {
            var table = $('#centreTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/all-centre",
                    data: function(d) {
                        d.sr_no = $('#sr_no').val();
                        d.vn_name = $('#vn_name').val();
                        d.state_id = $('#state_code').val();
                        d.district_id = $('#district_id').val();
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'pin_code',
                        name: 'pin_code'
                    },
                    {
                        data: 'state_name',
                        name: 'state_name'
                    },
                    {
                        data: 'district_name',
                        name: 'district_name'
                    },
                    {
                        data: 'vn_name',
                        name: 'vn_name',
                    },
                    {
                        data: 'services_avail',
                        name: 'services_avail',
                    },
                    {
                        data: 'services_available',
                        name: 'services_available',
                    },
                    {
                        data: 'centre_contact_no',
                        name: 'centre_contact_no',
                    },
                    {
                        data: 'incharge',
                        name: 'incharge',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#btn_search').click(function() {
                table.draw();
            });
        });
    </script>
@endpush

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
                <form method="POST" action="{{ url('/storecentre') }}" enctype="multipart/form-data"> @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>State</label>
                            <select class="form-control" name="state_id" id="stateChange_id" required="true"
                                onchange="return get_StateDistrict(this.value);">
                                <option value="">Choose...</option>
                                @foreach ($state as $s)
                                    <option value="{{ $s->state_code }}">{{ $s->state_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>District</label>
                            <select class="form-control" name="district_id" id="inputDistrict" required="true">
                                <option value="">Choose...</option>
                                {{-- @foreach ($district as $d)
                                    <option value="{{ $d->id }}">{{ $d->district_name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
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
    <link rel="stylesheet" media="all" href="{{ asset('assets/css/jquery.dataTables.css') }}">
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ App::isProduction() ? secure_asset('assets/js/custom/self-risk-assessment.js') : asset('assets/js/custom/self-risk-assessment.js') }}">
    </script>
    <script
        src="{{ App::isProduction() ? secure_asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') : asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}">
    </script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
@endpush
