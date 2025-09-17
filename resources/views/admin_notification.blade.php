@extends('layouts.app')

@section('content')
    <div class="row">
      

        <div class="col-md-12">
            

            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-4">
                            <h3 class="mb-0">Centres created by VNs</h3>
                        </div>
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
                    url: "/admin-notification",
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

        });
    </script>
@endpush

@push('modal')
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
